<?php

namespace App\Jobs;

use App\Models\BatchFile;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Str;
use Intervention\Image\Encoders\WebpEncoder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

use Intervention\Image\Drivers\Gd\Driver as GdDriver;
// app/Jobs/ProcessImageJob.php

class ProcessImageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout    = 300;
    public $tries      = 2;

    public function __construct(
        public string $path,
        public int    $batchId,
        public string $originalName,
        public int    $fileSize,
    ) {}

    public function handle()
    {
        try {
            $manager = new ImageManager(new GdDriver());

            $imageName     = Str::uuid() . '.webp';
            $watermarkPath = storage_path('app/watermark.png');

            $img    = $manager->read($this->path);
            $width  = $img->width();
            $height = $img->height();

            // HIGH
            $highEncoded = $manager->read($this->path)
                ->encode(new WebpEncoder(quality: 100))->toString();
            Storage::disk('s3')->put("batch/image/high/$imageName", $highEncoded, ['visibility' => 'public']);
            unset($highEncoded);

            // Watermark size
            $megapixels = ($width * $height) / 1000000;
            $wmPercent  = match (true) {
                $megapixels >= 20 => 0.35,
                $megapixels >= 10 => 0.38,
                $megapixels >= 5  => 0.40,
                $megapixels >= 2  => 0.43,
                default           => 0.45,
            };
            $wmSize = (int)($width * $wmPercent);

            // MID
            $midImg = $manager->read($this->path);
            $wmMid  = $manager->read($watermarkPath);
            $wmMid->scale(width: $wmSize);
            $midImg->place($wmMid, 'bottom', 0, 30);
            $midEncoded = $midImg->encode(new WebpEncoder(quality: 80))->toString();
            Storage::disk('s3')->put("batch/image/mid/mid_$imageName", $midEncoded, ['visibility' => 'public']);
            unset($midImg, $wmMid, $midEncoded);

            // LOW
            $lowImg = $manager->read($this->path);
            $wmLow  = $manager->read($watermarkPath);
            $wmLow->scale(width: $wmSize);
            $lowImg->place($wmLow, 'bottom', 0, 30);
            $lowEncoded = $lowImg->encode(new WebpEncoder(quality: 60))->toString();
            Storage::disk('s3')->put("batch/image/low/low_$imageName", $lowEncoded, ['visibility' => 'public']);
            unset($lowImg, $wmLow, $lowEncoded);

            // Save to DB
            BatchFile::create([
                'batch_id'       => $this->batchId,
                'file_code'      => mt_rand(1000000000, 9999999999),
                'original_name'  => $this->originalName,
                'title'          => pathinfo($this->originalName, PATHINFO_FILENAME),
                'file_name'      => $imageName,
                'file_path'      => "batch/image/high/$imageName",
                'mid_path'       => "batch/image/mid/mid_$imageName",
                'low_path'       => "batch/image/low/low_$imageName",
                'thumbnail_path' => '',
                'file_type'      => 'image',
                'type'           => 'image',
                'date_created'   => Carbon::now()->toDateString(),
                'file_size'      => $this->fileSize,
                'width'          => $width,
                'height'         => $height,
                'status'         => 'not_submitted',
            ]);

            Log::info("✅ Image processed", ['image' => $imageName, 'batch' => $this->batchId]);
        } catch (\Throwable $e) {
            Log::error("🔥 ProcessImageJob failed: " . $e->getMessage());
            throw $e;
        } finally {
            // Delete temp file after processing
            @unlink($this->path);
            gc_collect_cycles();
        }
    }
}
