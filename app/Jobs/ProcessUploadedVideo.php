<?php

namespace App\Jobs;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use FFMpeg\FFMpeg;
use FFMpeg\Format\Video\X264;
use FFMpeg\Coordinate\Dimension;
use FFMpeg\Coordinate\TimeCode;

class ProcessUploadedVideo implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var \App\Models\Video $video The model instance is now passed directly.
     */
    protected $product;
    protected $tempOriginalPath;

    /**
     * Create a new job instance.
     *
     * @param Video $video The newly created Video model instance.
     * @param string $tempOriginalPath The temporary full path where the file was first stored.
     */
    public function __construct(Product $product, string $tempOriginalPath)
    {
        $this->product = $product;
        $this->tempOriginalPath = $tempOriginalPath;
    }
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $video = $this->product;

        if (!file_exists($this->tempOriginalPath)) {
            $video->status = 'failed';
            $video->save();
            logger()->error("Video Processing Failed: Original file not found at path: " . $this->tempOriginalPath);
            $this->fail(new \Exception("Original video file not found."));
            return;
        }

        $originalFilename = $video->high_path;
        $baseDir = public_path('uploads/videos/');
        $lowDir  = $baseDir . 'low/';
        $thumbDir = $baseDir . 'thumbnails/';
        if (!file_exists($lowDir)) {
            mkdir($lowDir, 0755, true);
        }
        if (!file_exists($thumbDir)) {
            mkdir($thumbDir, 0755, true);
        }

        $lowPath = $lowDir . 'low_' . $originalFilename;

        $thumbnailName = pathinfo($originalFilename, PATHINFO_FILENAME) . '_thumb.jpg';
        $thumbnailPath = $thumbDir . $thumbnailName;

        try {
            DB::beginTransaction();

            $ffmpeg = \FFMpeg\FFMpeg::create([
                'ffmpeg.binaries'  => env('FFMPEG_BINARY_PATH'),
                'ffprobe.binaries' => env('FFPROBE_BINARY_PATH'),
                'timeout'          => 3600,
            ]);

            $videoFFMpeg = $ffmpeg->open($this->tempOriginalPath);

            $formatLow = new \FFMpeg\Format\Video\X264('aac', 'libx264');
            $formatLow->setKiloBitrate(500);
            $formatLow->setAudioKiloBitrate(96);

            $formatLow->setAdditionalParameters([
                '-movflags',
                '+faststart'
            ]);

            $videoFFMpeg->filters()
                ->resize(new \FFMpeg\Coordinate\Dimension(640, 360))
                ->synchronize();
            $videoFFMpeg->save($formatLow, $lowPath);

            $videoFFMpeg->frame(\FFMpeg\Coordinate\TimeCode::fromSeconds(2))
                ->save($thumbnailPath);

            $video->low_path =  'low_' . $originalFilename;
            $video->thumbnail_path = $thumbnailName;
            // $video->status = 'ready';
            $video->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            if ($video->id) {
                // $video->status = 'failed';
                $video->save();
            }

            logger()->error("Video Processing Failed for ID: " . $video->id . " Error: " . $e->getMessage());
            $this->fail($e);
        }
    }
}
