<?php

namespace App\Jobs;

use App\Models\BatchFile;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use FFMpeg\FFMpeg;
use FFMpeg\Format\Video\X264;
use FFMpeg\Coordinate\Dimension;

class ProcessBatchVideo implements ShouldQueue
{
    // use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    // protected $batchFileId;

    // public $timeout = 7200; // 2 hours
    // public $tries = 1;
    // public $maxExceptions = 1;

    // public function __construct($batchFileId)
    // {
    //     $this->batchFileId = $batchFileId;
    // }

    // public function handle()
    // {
    //     $video = BatchFile::find($this->batchFileId);

    //     if (!$video) {
    //         Log::error("Video not found", ['id' => $this->batchFileId]);
    //         return;
    //     }

    //     try {

    //         Log::info("🎬 Processing Started", ['video_id' => $video->id]);

    //         /*
    //     |--------------------------------------------------------------------------
    //     | 1. Check Original Exists Locally
    //     |--------------------------------------------------------------------------
    //     */

    //         $originalPath = public_path($video->file_path);

    //         if (!file_exists($originalPath)) {
    //             throw new \Exception("Original video not found");
    //         }

    //         /*
    //     |--------------------------------------------------------------------------
    //     | 2. Temp Directory
    //     |--------------------------------------------------------------------------
    //     */

    //         $tempDir = storage_path('app/temp');

    //         if (!file_exists($tempDir)) {
    //             mkdir($tempDir, 0755, true);
    //         }

    //         $tempOriginalPath = $tempDir . '/' . $video->file_name;

    //         copy($originalPath, $tempOriginalPath);

    //         /*
    //     |--------------------------------------------------------------------------
    //     | 3. Thumbnail Generation
    //     |--------------------------------------------------------------------------
    //     */

    //         $thumbnailName = pathinfo($video->file_name, PATHINFO_FILENAME) . '_thumb.jpg';
    //         $tempThumbnailPath = $tempDir . '/' . $thumbnailName;

    //         $ffmpegPath = env('FFMPEG_BINARY_PATH');

    //         $command = "{$ffmpegPath} -ss 00:00:01 -i {$tempOriginalPath} -vframes 1 -q:v 2 {$tempThumbnailPath}";
    //         exec($command);

    //         /*
    //     |--------------------------------------------------------------------------
    //     | 4. Move Thumbnail To Public Folder
    //     |--------------------------------------------------------------------------
    //     */

    //         $thumbnailFolder = public_path('uploads/batch/videos/thumbnails');

    //         if (!file_exists($thumbnailFolder)) {
    //             mkdir($thumbnailFolder, 0777, true);
    //         }

    //         rename($tempThumbnailPath, $thumbnailFolder . '/' . $thumbnailName);

    //         /*
    //     |--------------------------------------------------------------------------
    //     | 5. Generate Low Quality Video
    //     |--------------------------------------------------------------------------
    //     */

    //         $lowFileName = 'low_' . $video->file_name;
    //         $tempLowPath = $tempDir . '/' . $lowFileName;

    //         $ffmpeg = FFMpeg::create([
    //             'ffmpeg.binaries'  => env('FFMPEG_BINARY_PATH'),
    //             'ffprobe.binaries' => env('FFPROBE_BINARY_PATH'),
    //             'timeout'          => 7200,
    //         ]);



    //         $ffprobe = \FFMpeg\FFProbe::create([
    //             'ffprobe.binaries' => env('FFPROBE_BINARY_PATH'),
    //         ]);

    //         $streams = $ffprobe->streams($tempOriginalPath)->videos()->first();

    //         $format = $ffprobe->format($tempOriginalPath);

    //         $fileSize = filesize($tempOriginalPath);
    //         $duration = $format->get('duration');

    //         $width = $streams->get('width');
    //         $height = $streams->get('height');

    //         $frameRate = $streams->get('r_frame_rate'); // example: 30000/1001

    //         if ($frameRate) {
    //             list($num, $den) = explode('/', $frameRate);
    //             $frameRate = $den != 0 ? round($num / $den, 2) : 0;
    //         }

    //         Log::info("🎬 Video Processing Started", [
    //             'video_id' => $video->id,
    //             'file_name' => $video->file_name,
    //             'file_size' => formatFileSize($fileSize),
    //             'duration' => gmdate('H:i:s', $duration),
    //             'width' => $width,
    //             'height' => $height,
    //             'frame_rate' => $frameRate
    //         ]);
    //         $videoFFMpeg = $ffmpeg->open($tempOriginalPath);

    //         $format = new X264('aac', 'libx264');
    //         $format->setKiloBitrate(500);
    //         $format->setAudioKiloBitrate(96);

    //         $videoFFMpeg->filters()
    //             ->resize(new Dimension(640, 360))
    //             ->synchronize();

    //         $videoFFMpeg->save($format, $tempLowPath);

    //         /*
    //     |--------------------------------------------------------------------------
    //     | 6. Move Low Video To Public Folder
    //     |--------------------------------------------------------------------------
    //     */

    //         $lowFolder = public_path('uploads/batch/videos/low');

    //         if (!file_exists($lowFolder)) {
    //             mkdir($lowFolder, 0777, true);
    //         }

    //         rename($tempLowPath, $lowFolder . '/' . $lowFileName);

    //         /*
    //     |--------------------------------------------------------------------------
    //     | 7. Update Database
    //     |--------------------------------------------------------------------------
    //     */

    //         Log::info("✅ NAmes", ['thumbnail_path' => $thumbnailName]);

    //         $video->thumbnail_path = $thumbnailName;
    //         $video->low_path = $lowFileName;
    //         $video->file_size = $fileSize;
    //         $video->width = $width;
    //         $video->height = $height;
    //         $video->duration = $duration;
    //         $video->frame_rate = $frameRate;
    //         $video->status = 'submitted';
    //         $video->save();

    //         /*
    //     |--------------------------------------------------------------------------
    //     | 8. Cleanup Temp Files
    //     |--------------------------------------------------------------------------
    //     */

    //         @unlink($tempOriginalPath);

    //         Log::info("✅ Processing Completed", ['video_id' => $video->id]);
    //     } catch (\Exception $e) {

    //         Log::error("🔥 Processing Failed", [
    //             'video_id' => $video->id,
    //             'error' => $e->getMessage()
    //         ]);

    //         $video->status = 'rejected';
    //         $video->save();
    //     }
    // }
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $batchFileId;

    public $timeout    = 7200;
    public $tries      = 1;
    public $maxExceptions = 1;

    public function __construct($batchFileId)
    {
        $this->batchFileId = $batchFileId;
    }

    public function handle()
    {
        $video = BatchFile::find($this->batchFileId);

        if (!$video) {
            Log::error("Video not found", ['id' => $this->batchFileId]);
            return;
        }

        try {

            $watermarkPath = storage_path('app/watermark.png');

            $ffmpegBin  = '/usr/bin/ffmpeg';
            $ffprobeBin = "/usr/bin/ffprobe";


            /*
            |--------------------------------------------------------------------------
            | 1. Check Original Exists in S3
            |--------------------------------------------------------------------------
            */
            if (!Storage::disk('s3')->exists($video->file_path)) {
                throw new \Exception("Original video not found in S3: {$video->file_path}");
            }

            /*
            |--------------------------------------------------------------------------
            | 2. Create Temp Directory
            |--------------------------------------------------------------------------
            */
            $tempDir = storage_path('app/temp');
            if (!file_exists($tempDir)) {
                mkdir($tempDir, 0755, true);
            }

            $tempOriginalPath = $tempDir . '/' . $video->file_name;

            /*
            |--------------------------------------------------------------------------
            | 3. Download From S3
            |--------------------------------------------------------------------------
            */
            Log::info("⬇️ Downloading from S3", ['path' => $video->file_path]);

            $stream = Storage::disk('s3')->readStream($video->file_path);
            file_put_contents($tempOriginalPath, stream_get_contents($stream));
            fclose($stream);

            /*
            |--------------------------------------------------------------------------
            | 4. Get Video Metadata
            |--------------------------------------------------------------------------
            */
            $ffprobe = \FFMpeg\FFProbe::create([
                'ffprobe.binaries' => $ffprobeBin,
            ]);

            $streams   = $ffprobe->streams($tempOriginalPath)->videos()->first();
            $format    = $ffprobe->format($tempOriginalPath);
            $fileSize  = filesize($tempOriginalPath);
            $duration  = $format->get('duration');
            $width     = $streams->get('width');
            $height    = $streams->get('height');
            $frameRate = $streams->get('r_frame_rate');

            if ($frameRate) {
                [$num, $den] = explode('/', $frameRate);
                $frameRate = $den != 0 ? round($num / $den, 2) : 0;
            }
            /*
            |--------------------------------------------------------------------------
            | 5. Generate Thumbnail
            |--------------------------------------------------------------------------
            */
            $thumbnailName     = pathinfo($video->file_name, PATHINFO_FILENAME) . '_thumb.jpg';
            $tempThumbnailPath = $tempDir . '/' . $thumbnailName;

            $command = escapeshellcmd($ffmpegBin)
                . ' -ss 00:00:01'
                . ' -i ' . escapeshellarg($tempOriginalPath)
                . ' -vframes 1'
                . ' -q:v 2 '
                . escapeshellarg($tempThumbnailPath)
                . ' 2>&1';

            exec($command, $thumbOutput, $thumbCode);

            if ($thumbCode !== 0 || !file_exists($tempThumbnailPath)) {
                Log::warning("⚠️ Thumbnail generation failed", [
                    'output' => implode("\n", $thumbOutput),
                ]);
            } else {
                Log::info("✅ Thumbnail generated");
            }

            Storage::disk('s3')->putFileAs(
                'batch/videos/thumbnails',
                new \Illuminate\Http\File($tempThumbnailPath),
                $thumbnailName,
                ['visibility' => 'public']
            );

            Log::info("✅ Thumbnail uploaded to S3");

            /*
            |--------------------------------------------------------------------------
            | 6. Init FFMpeg
            |--------------------------------------------------------------------------
            */
            $ffmpeg = FFMpeg::create([
                'ffmpeg.binaries'  => $ffmpegBin,
                'ffprobe.binaries' => $ffprobeBin,
                'timeout'          => 7200,
            ]);

            /*
            |--------------------------------------------------------------------------
            | 7. Generate MID Quality — 720p max, 2500kbps
            |--------------------------------------------------------------------------
            */
            $midFileName = 'mid_' . $video->file_name;
            $tempMidPath = $tempDir . '/' . $midFileName;

            // Log your intent and logic (already good in your code)


            $midVideo  = $ffmpeg->open($tempOriginalPath);
            $midFormat = new X264('aac', 'libx264');
            $midFormat->setKiloBitrate(2500);
            $midFormat->setAudioKiloBitrate(128);

            if ($height > 720 || $width > 1280) {
                $midVideo->filters()
                    ->resize(new Dimension(1280, 720))
                    ->synchronize();
            }
            $midVideo->filters()->custom(
                "movie={$watermarkPath},scale=200:-1 [watermark]; [in][watermark] overlay=(main_w-overlay_w)/2:(main_h-overlay_h)/2 [out]"
            );

            $midVideo->save($midFormat, $tempMidPath);



            if (!file_exists($tempMidPath)) {
                // Log::error("🔥 MID video was NOT created at: {$tempMidPath}");
            } else {
                // Log::info("✅ MID video generated", [
                //     'path' => $tempMidPath,
                //     'size' => filesize($tempMidPath),
                // ]);

                Storage::disk('s3')->putFileAs(
                    'batch/videos/mid',
                    new \Illuminate\Http\File($tempMidPath),
                    $midFileName,
                    ['visibility' => 'public']
                );

                // Log::info("✅ MID video uploaded to S3");
            }


            /*
            |--------------------------------------------------------------------------
            | 8. Generate LOW Quality — same resolution, 500kbps (quality reduction only)
            |--------------------------------------------------------------------------
            */
            $lowFileName = 'low_' . $video->file_name;
            $tempLowPath = $tempDir . '/' . $lowFileName;

            // Log::info("🎞️ Generating LOW video");

            $lowVideo  = $ffmpeg->open($tempOriginalPath);
            $lowFormat = new X264('aac', 'libx264');
            $lowFormat->setKiloBitrate(500);
            $lowFormat->setAudioKiloBitrate(96);

            $lowVideo->filters()->custom(
                "movie={$watermarkPath},scale=200:-1 [watermark]; [in][watermark] overlay=(main_w-overlay_w)/2:(main_h-overlay_h)/2 [out]"
            );

            // NO resize — keep original dimensions, only reduce bitrate/quality
            $lowVideo->save($lowFormat, $tempLowPath);

            Storage::disk('s3')->putFileAs(
                'batch/videos/low',
                new \Illuminate\Http\File($tempLowPath),
                $lowFileName,
                ['visibility' => 'public']
            );

            Log::info("✅ LOW video uploaded to S3");


            if ($duration >= 10) {
                $previewFileName = 'preview_' . $video->file_name;
                $tempPreviewPath = $tempDir . '/' . $previewFileName;

                // Pick a random start time, ensuring 6s clip fits within the video
                $maxStart   = max(0, floor($duration - 6));
                $startTime  = rand(0, $maxStart);

                Log::info("🎞️ Generating Preview video", [
                    'duration'   => $duration,
                    'start_time' => $startTime,
                ]);

                $previewCommand = escapeshellcmd($ffmpegBin)
                    . ' -ss ' . escapeshellarg($startTime)
                    . ' -i '  . escapeshellarg($tempOriginalPath)
                    . ' -t 6'
                    . ' -vf ' . escapeshellarg(
                        "movie={$watermarkPath},scale=200:-1 [watermark]; [in][watermark] overlay=(main_w-overlay_w)/2:(main_h-overlay_h)/2 [out]"
                    )
                    . ' -c:v libx264 -crf 23 -preset fast'
                    . ' -c:a aac -b:a 96k'
                    . ' -movflags +faststart'
                    . ' -y '  . escapeshellarg($tempPreviewPath)
                    . ' 2>&1';

                exec($previewCommand, $previewOutput, $previewCode);

                if ($previewCode !== 0 || !file_exists($tempPreviewPath)) {
                    Log::warning("⚠️ Preview video generation failed", [
                        'output' => implode("\n", $previewOutput),
                    ]);
                } else {
                    Storage::disk('s3')->putFileAs(
                        'batch/videos/preview',
                        new \Illuminate\Http\File($tempPreviewPath),
                        $previewFileName,
                        ['visibility' => 'public']
                    );

                    $video->preview_path = 'batch/videos/preview/' . $previewFileName;

                    Log::info("✅ Preview video uploaded to S3");
                }

                @unlink($tempPreviewPath);
            }




            /*
            |--------------------------------------------------------------------------
            | 9. Update Database
            |--------------------------------------------------------------------------
            */
            $video->width          = $width;
            $video->height         = $height;
            $video->duration       = $duration;
            $video->file_size      = $fileSize;
            $video->frame_rate     = $frameRate;
            $video->thumbnail_path = 'batch/videos/thumbnails/' . $thumbnailName;
            $video->mid_path       = 'batch/videos/mid/' . $midFileName;
            $video->low_path       = 'batch/videos/low/' . $lowFileName;
            $video->status         = 'submitted';
            $video->save();

            Log::info("✅ Database updated");

            /*
            |--------------------------------------------------------------------------
            | 10. Cleanup Temp Files
            |--------------------------------------------------------------------------
            */
            @unlink($tempOriginalPath);
            @unlink($tempMidPath);
            @unlink($tempLowPath);
            @unlink($tempThumbnailPath);

            Log::info("✅ Processing Completed Successfully", ['video_id' => $video->id]);
        } catch (\Exception $e) {

            Log::error("🔥 Processing Failed", [
                'video_id' => $video->id,
                'error'    => $e->getMessage(),
                'trace'    => $e->getTraceAsString(),
            ]);

            // Cleanup temp files on failure too
            @unlink($tempOriginalPath ?? '');
            @unlink($tempMidPath ?? '');
            @unlink($tempLowPath ?? '');
            @unlink($tempThumbnailPath ?? '');

            $video->status = 'rejected';
            $video->save();
        }
    }
}
