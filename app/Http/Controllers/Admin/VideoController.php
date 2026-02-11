<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\VideosDataTable;
use App\Models\Video;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Jobs\ProcessUploadedVideo; // <-- Import the new job
use FFMpeg\FFMpeg;
use FFMpeg\Format\Video\X264;
use FFMpeg\Coordinate\TimeCode;
use FFMpeg\Coordinate\Dimension;


class VideoController extends Controller
{
    public function index(VideosDataTable $DataTable)
    {
        $title = 'Videos';
        $page = 'admin.videos.list';
        $js = ['videos'];
        return $DataTable->render('layouts.admin.layout', compact('title', 'page', 'js'));
    }
    public function addvideo(Request $request)
    {
        $title = 'Add Video';
        $page = 'admin.videos.add';
        $js = ['videos'];
        $category = Category::all();

        return view("layouts.admin.layout", compact(
            'title',
            'page',
            'js',
            'category'
        ));
    }

    public function store(Request $request)
    {

        try {
            DB::beginTransaction();

            $validatedData = $request->validate([
                'category' => 'required|exists:categories,id',
                'video_name' => 'required|string|max:255',
                'video_price' => 'required|numeric',
                'video_description' => 'nullable|string',
                'video' => 'required|file|mimes:mp4,mov,avi,wmv', // Example: Max 200MB
                // 'video' => 'required|file|mimes:mp4,mov,avi,wmv|max:204800/', // Example: Max 200MB
            ]);

            // 1. Prepare Directories
            $baseDir = public_path('uploads/videos/');
            $highDir = $baseDir . 'high/';
            if (!file_exists($highDir)) {
                mkdir($highDir, 0755, true);
            }

            // 2. Store the original video file and get the temporary path
            $videoFile = $request->file('video');
            $originalFilename = time() . '_' . uniqid() . '.' . $videoFile->getClientOriginalExtension();

            // Move the original file to the 'high' directory
            $videoFile->move($highDir, $originalFilename);
            $tempOriginalPath = $highDir . $originalFilename; // Full path to the original file

            // 3. Create a database entry with 'processing' status
            $video = new Video();
            $video->category_id = $validatedData['category'];
            $video->video_name = $validatedData['video_name'];
            $video->video_price = $validatedData['video_price'];
            $video->video_description = $validatedData['video_description'];
            $video->tags = $request->input('tags');
            $video->high_path = $originalFilename;
            $video->save(); // Model now has the ID (e.g., $video->id)

            DB::commit();

            // 4. Dispatch the Job, passing the Video model instance directly
            // Laravel automatically serializes the model and finds it in the handle method.
            ProcessUploadedVideo::dispatch($video, $tempOriginalPath);

            return redirect()
                ->route('admin.video')
                ->with('msg_success', 'Video uploaded successfully and is now processing.');
        } catch (\Exception $e) {
            DB::rollBack();
            // Optional: Clean up the file if the database transaction fails
            if (isset($tempOriginalPath) && file_exists($tempOriginalPath)) {
                unlink($tempOriginalPath);
            }

            return redirect()
                ->back()
                ->with('msg_error', 'Error uploading video: ' . $e->getMessage());
        }
    }

    public function edit(string $id)
    {
        $image_id =  decrypt($id);

        $title = 'Edit Video';
        $page = 'admin.videos.edit';
        $js = ['videos'];

        $videoId = $id;
        $getVideoDetail = Video::where('id', $image_id)->first();
        $category = Category::all();

        return view('layouts.admin.layout', compact('title', 'page', 'js', 'getVideoDetail', 'category', 'videoId'));
    }
    public function update(Request $request, $id)
    {
        $tempOriginalPath = null;
        $jobNeedsDispatch = false;
        try {
            DB::beginTransaction();

            $validatedData = $request->validate([
                'category' => 'required|exists:categories,id',
                'video_name' => 'required|string|max:255',
                'video_price' => 'required|numeric',
                'video_description' => 'nullable|string',
                'video' => 'nullable|file|mimes:mp4,mov,avi,wmv',
            ]);

            $decryptedId = decrypt($id);
            $video = Video::findOrFail($decryptedId);

            $baseDir = public_path('uploads/videos/');
            $highDir = $baseDir . 'high/';
            $lowDir  = $baseDir . 'low/';
            $thumbDir = $baseDir . 'thumbnails/';

            foreach ([$highDir, $lowDir, $thumbDir] as $dir) {
                if (!file_exists($dir)) {
                    mkdir($dir, 0755, true);
                }
            }

            if ($request->hasFile('video')) {
                $videoFile = $request->file('video');
                $filename = time() . '.' . $videoFile->getClientOriginalExtension();

                if ($video->high_path && file_exists($highDir . $video->high_path)) {
                    @unlink($highDir . $video->high_path);
                }
                if ($video->low_path && file_exists($lowDir . 'low_' . $video->low_path)) {
                    @unlink($lowDir . 'low_' . $video->low_path);
                }
                if ($video->thumbnail_path && file_exists($thumbDir . $video->thumbnail_path)) {
                    @unlink($thumbDir . $video->thumbnail_path);
                }


                $videoFile = $request->file('video');
                $originalFilename = time() . '_' . uniqid() . '.' . $videoFile->getClientOriginalExtension();
                $videoFile->move($highDir, $originalFilename);
                $tempOriginalPath = $highDir . $originalFilename;

                $video->high_path = $originalFilename;
                $video->low_path = null;
                $video->thumbnail_path = null;
                // $video->status = 'processing'; // Mark as processing
                $jobNeedsDispatch = true;
            }

            $video->category_id = $validatedData['category'];
            $video->video_name = $validatedData['video_name'];
            $video->video_price = $validatedData['video_price'];
            $video->video_description = $validatedData['video_description'];
            $video->tags = $request->input('tags');

            $video->save();

            DB::commit();

            if ($jobNeedsDispatch) {
                ProcessUploadedVideo::dispatch($video, $tempOriginalPath);
            }

            return redirect()
                ->route('admin.video')
                ->with('msg_success', 'Video updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->back()
                ->with('msg_error', 'Error updating video: ' . $e->getMessage());
        }
    }
    public function delete(string $id)
    {
        try {
            DB::beginTransaction();
            $id = decrypt($id);

            $video = Video::findOrFail($id);

            $baseDir = public_path('uploads/videos/');
            $highDir = $baseDir . 'high/';
            $lowDir  = $baseDir . 'low/';
            $thumbDir = $baseDir . 'thumbnails/';

            if ($video->high_path && file_exists($highDir . $video->high_path)) {
                @unlink($highDir . $video->high_path);
            }

            if ($video->low_path && file_exists($lowDir . $video->low_path)) {
                @unlink($lowDir . $video->low_path);
            }

            if ($video->thumbnail_path && file_exists($thumbDir . $video->thumbnail_path)) {
                @unlink($thumbDir . $video->thumbnail_path);
            }

            $video->delete();

            DB::commit();

            return redirect()
                ->route('admin.video')
                ->with('msg_success', 'Video deleted successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->back()
                ->with('msg_error', 'Error updating video: ' . $e->getMessage());
        }
    }

    public function toggleDisplay(Request $request)
    {
        try {
            $images = Video::findOrFail($request->id);
            if ($images->is_display == "1") {
                $images->is_display = "0";
            } else {
                $images->is_display = "1";
            }
            $images->save();

            return response()->json([
                'success' => true,
                'status' => $images->is_display,
                'message' => 'Display status updated successfully.'
            ]);
        } catch (QueryException $e) {
            DB::rollBack();
            return response()->json(false);
        }
    }

    public function deleteMultiple(Request $request)
    {
        try {
            DB::beginTransaction();
            $ids = $request->ids;
            if (empty($ids)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No IDs provided.'
                ]);
            }
            $videos = Video::whereIn('id', $ids)->get();

            if ($videos->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No videos found.'
                ]);
            }

            $baseDir = public_path('uploads/videos/');
            $highDir = $baseDir . 'high/';
            $lowDir  = $baseDir . 'low/';
            $thumbDir = $baseDir . 'thumbnails/';
            foreach ($videos as $vid) {

                $highPath = $highDir . $vid->high_path;
                $lowPath  = $lowDir . $vid->low_path;
                $thumbDir  = $thumbDir . $vid->thumbnail_path;

                if (file_exists($highPath)) unlink($highPath);
                if (file_exists($lowPath)) unlink($lowPath);
                if (file_exists($thumbDir)) unlink($thumbDir);
            }
            Video::whereIn('id', $ids)->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Videos deleted successfully.'
            ]);
        } catch (QueryException $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error deleting videos.'
            ]);
        }
    }
}
