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
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $batchFileId;

    public $timeout = 7200; // 2 hours
    public $tries = 1;
    public $maxExceptions = 1;

    public function __construct($batchFileId)
    {
        $this->batchFileId = $batchFileId;
    }

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
    public function handle()
    {
        $video = BatchFile::find($this->batchFileId);

        if (!$video) {
            Log::error("Video not found", ['id' => $this->batchFileId]);
            return;
        }

        try {

            Log::info("🎬 Processing Started", ['video_id' => $video->id]);

            /*
            |--------------------------------------------------------------------------
            | 1. Check Original Exists in S3
            |--------------------------------------------------------------------------
            */
            if (!Storage::disk('s3')->exists($video->file_path)) {
                throw new \Exception("Original video not found in S3");
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
            | 3. Download From S3 (Stream Safe)
            |--------------------------------------------------------------------------
            */
            $stream = Storage::disk('s3')->readStream($video->file_path);
            file_put_contents($tempOriginalPath, stream_get_contents($stream));
            fclose($stream);

            /*
            |--------------------------------------------------------------------------
            | 4. FAST Thumbnail Generation (Very Fast Method)
            |--------------------------------------------------------------------------
            */
            $thumbnailName = pathinfo($video->file_name, PATHINFO_FILENAME) . '_thumb.jpg';
            $tempThumbnailPath = $tempDir . '/' . $thumbnailName;

            // Fast thumbnail using direct FFmpeg command
            $ffmpegPath = env('FFMPEG_BINARY_PATH');

            $command = "{$ffmpegPath} -ss 00:00:01 -i {$tempOriginalPath} -vframes 1 -q:v 2 {$tempThumbnailPath}";
            exec($command);

            /*
            |--------------------------------------------------------------------------
            | 5. Upload Thumbnail To S3 Immediately
            |--------------------------------------------------------------------------
            */
            Storage::disk('s3')->putFileAs(
                'batch/videos/thumbnails',
                new \Illuminate\Http\File($tempThumbnailPath),
                $thumbnailName,
                [
                    'visibility' => 'public'
                ]
            );

            /*
            |--------------------------------------------------------------------------
            | 6. Generate Low Quality Video
            |--------------------------------------------------------------------------
            */
            $lowFileName = 'low_' . $video->file_name;
            $tempLowPath = $tempDir . '/' . $lowFileName;

            $ffmpeg = FFMpeg::create([
                'ffmpeg.binaries'  => env('FFMPEG_BINARY_PATH'),
                'ffprobe.binaries' => env('FFPROBE_BINARY_PATH'),
                'timeout'          => 7200,
            ]);


            $ffprobe = \FFMpeg\FFProbe::create([
                'ffprobe.binaries' => env('FFPROBE_BINARY_PATH'),
            ]);

            $streams = $ffprobe->streams($tempOriginalPath)->videos()->first();

            $format = $ffprobe->format($tempOriginalPath);

            $fileSize = filesize($tempOriginalPath);
            $duration = $format->get('duration');

            $width = $streams->get('width');
            $height = $streams->get('height');

            $frameRate = $streams->get('r_frame_rate'); // example: 30000/1001

            if ($frameRate) {
                list($num, $den) = explode('/', $frameRate);
                $frameRate = $den != 0 ? round($num / $den, 2) : 0;
            }
            $videoFFMpeg = $ffmpeg->open($tempOriginalPath);

            $format = new X264('aac', 'libx264');
            $format->setKiloBitrate(500);
            $format->setAudioKiloBitrate(96);

            $videoFFMpeg->filters()
                ->resize(new Dimension(640, 360))
                ->synchronize();

            $videoFFMpeg->save($format, $tempLowPath);

            /*
            |--------------------------------------------------------------------------
            | 7. Upload Low Video To S3
            |--------------------------------------------------------------------------
            */
            Storage::disk('s3')->putFileAs(
                'batch/videos/low',
                new \Illuminate\Http\File($tempLowPath),
                $lowFileName,
                [
                    'visibility' => 'public'
                ]
            );

            /*
            |--------------------------------------------------------------------------
            | 8. Update Database
            |--------------------------------------------------------------------------
            */
            $video->height = $height;
            $video->width = $width;
            $video->duration = $duration;
            $video->file_size = $fileSize;
            $video->frame_rate = $frameRate;
            $video->thumbnail_path = 'batch/videos/thumbnails/' . $thumbnailName;
            $video->low_path = 'batch/videos/low/' . $lowFileName;
            $video->status = 'submitted';
            $video->save();

            /*
            |--------------------------------------------------------------------------
            | 9. Cleanup Temp Files
            |--------------------------------------------------------------------------
            */
            @unlink($tempOriginalPath);
            @unlink($tempLowPath);
            @unlink($tempThumbnailPath);

            Log::info("✅ Processing Completed", ['video_id' => $video->id]);
        } catch (\Exception $e) {

            Log::error("🔥 Processing Failed", [
                'video_id' => $video->id,
                'error' => $e->getMessage()
            ]);

            $video->status = 'rejected';
            $video->save();
        }
    }
}
