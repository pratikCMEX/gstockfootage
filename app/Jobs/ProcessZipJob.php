<?php

namespace App\Jobs;

use App\Models\Batch;
use App\Models\BatchFile;

use Exception;
use ZipArchive;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\WebpEncoder;

class ProcessZipJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $zipPath;
    protected $batch_id;

    public function __construct($zipPath, $batch_id)
    {
        $this->zipPath = $zipPath;
        $this->batch_id = $batch_id;
    }

    public function handle()
    {
        set_time_limit(0);

        $localZipPath = storage_path('app/temp/' . uniqid() . '.zip');
        $extractPath  = storage_path('app/temp/' . uniqid());

        // Create temp directory
        if (!file_exists(dirname($localZipPath))) {
            mkdir(dirname($localZipPath), 0777, true);
        }

        /*
        |--------------------------------------------------------------------------
        | 1. Download ZIP From S3 (STREAM SAFE)
        |--------------------------------------------------------------------------
        */

        $stream = Storage::disk('s3')->readStream($this->zipPath);
        file_put_contents($localZipPath, stream_get_contents($stream));
        fclose($stream);

        /*
        |--------------------------------------------------------------------------
        | 2. Extract ZIP
        |--------------------------------------------------------------------------
        */

        $zip = new \ZipArchive;

        if ($zip->open($localZipPath) === TRUE) {

            mkdir($extractPath, 0777, true);
            $zip->extractTo($extractPath);
            $zip->close();
        }

        /*
        |--------------------------------------------------------------------------
        | 3. Scan Images Recursively
        |--------------------------------------------------------------------------
        */

        $images = [];
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($extractPath, RecursiveDirectoryIterator::SKIP_DOTS)
        );

        foreach ($iterator as $fileInfo) {
            if ($fileInfo->isFile()) {
                $ext = strtolower($fileInfo->getExtension());
                if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp'])) {
                    $images[] = $fileInfo->getPathname();
                }
            }
        }

        // Update total count
        Batch::where('id', $this->batch_id)
            ->update(['total_files' => count($images)]);

        /*
        |--------------------------------------------------------------------------
        | 4. Process One By One (Memory Safe)
        |--------------------------------------------------------------------------
        */

        foreach ($images as $imagePath) {

            $this->processImage($imagePath);

            Batch::where('id', $this->batch_id)
                ->increment('processed_files');
        }

        /*
        |--------------------------------------------------------------------------
        | 5. Cleanup
        |--------------------------------------------------------------------------
        */

        File::deleteDirectory($extractPath);
        unlink($localZipPath);
        Storage::disk('s3')->delete($this->zipPath);

        Batch::where('id', $this->batch_id)
            ->update(['processing_status' => 'completed']);
    }

    private function processImage($path)
    {
        $manager = new ImageManager(new Driver());
        $imageName = uniqid() . '.webp';

        $img = $manager->read($path);

        $width  = $img->width();
        $height = $img->height();
        $size   = filesize($path);

        // HIGH
        Storage::disk('s3')->put(
            "batch/high/$imageName",
            $img->encode(new WebpEncoder(85))->toString(),
            'public'
        );

        // LOW
        $low = $img->scale(width: 800);

        Storage::disk('s3')->put(
            "batch/low/low_$imageName",
            $low->encode(new WebpEncoder(75))->toString(),
            'public'
        );

        BatchFile::create([
            'batch_id'       => $this->batch_id,
            'file_code'      => mt_rand(1000000000, 9999999999),
            'original_name'  => basename($path),
            'file_name'      => $imageName,
            'file_path'      => "batch/high/$imageName",
            'thumbnail_path' => "batch/low/low_$imageName",
            'file_type'      => 'image',
            'file_size'      => $size,
            'width'          => $width,
            'height'         => $height,
            'status'         => 'not_submitted',
        ]);

        // Free memory
        unset($img);
        gc_collect_cycles();
    }
}
