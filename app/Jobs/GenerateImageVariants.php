<?php

namespace App\Jobs;

use App\Models\BatchFile;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;
use Intervention\Image\Drivers\Gd\Encoders\WebpEncoder;
use Intervention\Image\ImageManager;

class GenerateImageVariants implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $timeout = 7200;  // was 120 — increase to match worker
    public int $tries   = 150;
    public int $backoff = 50;

    public function __construct(
        public readonly int    $batchFileId,
        public readonly string $highPath,
    ) {}

    public function handle(): void
    {
        $batchFile = BatchFile::findOrFail($this->batchFileId);
        $imageName = $batchFile->file_name;

        // ── Download from S3 to a local temp file ────────────────────────────
        // Avoids holding entire image in memory as a string
        $tempPath = storage_path('app/temp/' . uniqid() . '_' . $imageName);

        try {
            // Stream from S3 to disk instead of loading into memory
            $stream = Storage::disk('s3')->readStream($this->highPath);
            if (!Storage::disk('s3')->exists($this->highPath)) {
                throw new \Exception("File not available on S3: {$this->highPath}");
            }
            $tempFile = fopen($tempPath, 'wb');
            stream_copy_to_stream($stream, $tempFile);
            fclose($tempFile);
            if (is_resource($stream)) fclose($stream);

            $manager = new ImageManager(new GdDriver());

            // ── Get dimensions ────────────────────────────────────────────────
            $img    = $manager->read($tempPath);
            $width  = $img->width();
            $height = $img->height();

            // ── Watermark sizing ──────────────────────────────────────────────
            $megapixels = ($width * $height) / 1_000_000;
            $wmPercent  = match (true) {
                $megapixels >= 20 => 0.35,
                $megapixels >= 10 => 0.38,
                $megapixels >= 5  => 0.40,
                $megapixels >= 2  => 0.43,
                default           => 0.45,
            };
            $wmSize        = (int) ($width * $wmPercent);
            $watermarkPath = storage_path('app/watermark.png');

            // ── MID — encode, upload, free immediately ────────────────────────
            $midImg = $manager->read($tempPath);  // fresh read, not clone
            $wm     = $manager->read($watermarkPath);
            $wm->scale(width: $wmSize);
            $midImg->place($wm, 'bottom', 0, 30);
            $midEncoded = $midImg->encode(new WebpEncoder(quality: 80))->toString();
            $midPath    = "batch/image/mid/mid_$imageName";

            Storage::disk('s3')->put($midPath, $midEncoded, ['visibility' => 'public']);

            // Free MID memory immediately before doing thumbnail
            unset($midImg, $wm, $midEncoded);
            gc_collect_cycles();

            // // ── THUMBNAIL — fresh read, encode, upload, free ──────────────────
            // $thumbImg = $manager->read($tempPath);  // fresh read
            // $thumbImg->scale(width: 300);
            // $thumbEncoded = $thumbImg->encode(new WebpEncoder(quality: 75))->toString();
            // $thumbPath    = "batch/image/thumb/thumb_$imageName";

            // Storage::disk('s3')->put($thumbPath, $thumbEncoded, ['visibility' => 'public']);

            // unset($thumbImg, $thumbEncoded, $img);
            // gc_collect_cycles();

            // ── Update DB ─────────────────────────────────────────────────────
            $batchFile->update([
                'mid_path'       => $midPath,
                // 'thumbnail_path' => $thumbPath,
                // 'status'         => 'not_submitted',
            ]);

            Log::info('GenerateImageVariants done: ' . $this->batchFileId);
        } finally {
            // Always delete temp file
            if (file_exists($tempPath)) {
                @unlink($tempPath);
            }
            unset($manager);
            gc_collect_cycles();
        }
    }

    public function failed(\Throwable $e): void
    {
        Log::error('GenerateImageVariants failed', [
            'batch_file_id' => $this->batchFileId,
            'error'         => $e->getMessage(),
        ]);

        BatchFile::where('id', $this->batchFileId)
            ->update(['status' => 'failed']);
    }
}
