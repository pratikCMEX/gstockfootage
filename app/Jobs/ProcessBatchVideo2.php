<?php

namespace App\Jobs;

use App\Models\BatchFile;
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
use Illuminate\Support\Facades\Log;

class ProcessBatchVideo2 implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $batchFileId;
    // protected $tempOriginalPath;

    // public function __construct($batchFileId, string $tempOriginalPath)
    // {
    //     $this->batchFileId = $batchFileId;
    //     $this->tempOriginalPath = $tempOriginalPath;
    // }
    public function __construct($batchFileId)
    {
        $this->batchFileId = $batchFileId;
    }
    public function handle()
    {
        $video = BatchFile::find($this->batchFileId);

        if (!$video) {
            Log::error("Video record not found", ['id' => $this->batchFileId]);
            return;
        }

        $tempOriginalPath = public_path($video->file_path);

        Log::info("🎬 Video Processing Started", [
            'video_id' => $video->id,
            'file_name' => $video->file_name,
            'path' => $tempOriginalPath
        ]);

        if (!file_exists($tempOriginalPath)) {

            Log::error("❌ Original file not found", [
                'video_id' => $video->id,
                'path' => $tempOriginalPath
            ]);

            $video->status = 'rejected';
            $video->save();

            return;
        }

        $baseDir = public_path('uploads/videos/');
        $lowDir  = $baseDir . 'low/';
        $thumbDir = $baseDir . 'thumbnails/';

        foreach ([$lowDir, $thumbDir] as $dir) {
            if (!file_exists($dir)) {
                mkdir($dir, 0755, true);
                Log::info("📁 Created Directory", ['dir' => $dir]);
            }
        }

        $originalFilename = $video->file_name;
        $lowPath = $lowDir . 'low_' . $originalFilename;

        $thumbnailName = pathinfo($originalFilename, PATHINFO_FILENAME) . '_thumb.jpg';
        $thumbnailPath = $thumbDir . $thumbnailName;

        try {

            Log::info("⚙️ Initializing FFMpeg", [
                'ffmpeg_path' => env('FFMPEG_BINARY_PATH'),
                'ffprobe_path' => env('FFPROBE_BINARY_PATH')
            ]);

            $ffmpeg = \FFMpeg\FFMpeg::create([
                'ffmpeg.binaries'  => env('FFMPEG_BINARY_PATH'),
                'ffprobe.binaries' => env('FFPROBE_BINARY_PATH'),
                'timeout'          => 3600,
            ]);

            $videoFFMpeg = $ffmpeg->open($tempOriginalPath);

            Log::info("🎞️ Generating Low Quality Video", [
                'output_path' => $lowPath
            ]);

            $formatLow = new \FFMpeg\Format\Video\X264('aac', 'libx264');
            $formatLow->setKiloBitrate(500);
            $formatLow->setAudioKiloBitrate(96);

            $videoFFMpeg->filters()
                ->resize(new \FFMpeg\Coordinate\Dimension(640, 360))
                ->synchronize();

            $videoFFMpeg->save($formatLow, $lowPath);

            Log::info("🖼️ Generating Thumbnail", [
                'thumbnail_path' => $thumbnailPath
            ]);

            // $videoFFMpeg->frame(
            //     \FFMpeg\Coordinate\TimeCode::fromSeconds(2)
            // )->save($thumbnailPath);

            $videoForThumbnail = $ffmpeg->open($tempOriginalPath);

            $videoForThumbnail->frame(
                \FFMpeg\Coordinate\TimeCode::fromSeconds(2)
            )->save($thumbnailPath);

            // $video->low_path = 'low_' . $originalFilename;
            $video->thumbnail_path = $thumbnailName;
            $video->status = 'submitted';
            $video->save();

            Log::info("✅ Video Processing Completed Successfully", [
                'video_id' => $video->id,
                // 'low_path' => $video->low_path,
                'thumbnail' => $video->thumbnail_path
            ]);
        } catch (\Exception $e) {

            Log::error("🔥 Video Processing Failed", [
                'video_id' => $video->id,
                'error_message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            $video->status = 'rejected';
            $video->save();
        }

        Log::info("🏁 Job Finished", [
            'video_id' => $video->id
        ]);
    }
}
