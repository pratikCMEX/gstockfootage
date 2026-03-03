<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\ProcessBatchVideo;
use App\Models\Batch;
use App\Models\BatchFile;
use FFMpeg\FFProbe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Str;
use Intervention\Image\Encoders\WebpEncoder;
use Illuminate\Support\Facades\File;

class BatchController extends Controller
{
    public function index()
    {

        $title = 'Batches';
        $page = 'admin.batchs_img.add';
        $js = ['batch'];

        $batches = Batch::with(['batch_files'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        $batch_list = $batches->map(function ($batch) {
            return [
                'id'            => $batch->id,
                'batch_code'    => $batch->batch_code,
                'title'         => $batch->title,
                'submission_type' => $batch->submission_type,
                'brief_code'    => $batch->brief_code,
                'status'        => $batch->status,
                'total_files'   => $batch->batch_files->count(),
                'created_at'    => $batch->created_at->format('Y-m-d'),

                'batch_files' => $batch->batch_files->map(function ($file) {
                    return [
                        'id'              => $file->id,
                        'file_code'       => $file->file_code,
                        'original_name'   => $file->original_name,
                        'file_name'       => $file->file_name,
                        'file_path'       => asset($file->file_path),
                        'thumbnail_path'  => $file->thumbnail_path
                            ? asset($file->thumbnail_path)
                            : null,
                        'file_type'       => $file->file_type,
                        'file_size'       => $file->file_size,
                        'width'           => $file->width,
                        'height'          => $file->height,
                        'duration'        => $file->duration,
                        'status'          => $file->status,
                        'rejection_reason' => $file->rejection_reason,
                        'created_at'      => $file->created_at->format('Y-m-d H:i:s'),
                    ];
                })
            ];
        });

        // dd($batch_list); 

        return view('layouts.admin.layout', compact('title', 'page', 'js', 'batch_list'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'submission_type' => 'required|string|max:100',
            'batch_name'           => 'required|string|max:255',
            'brief_code'      => 'nullable|string|max:255',
        ]);

        try {

            DB::beginTransaction();
            $batchCode = '#' . mt_rand(10000000, 99999999);
            while (Batch::where('batch_code', $batchCode)->exists()) {
                $batchCode = '#' . mt_rand(10000000, 99999999);
            }

            $batch = Batch::create([
                'batch_code'     => $batchCode,
                'title'          => $request->batch_name,
                'submission_type' => $request->submission_type,
                'brief_code'     => $request->brief_code,
                'status'         => 'draft',
                'total_files'    => 0,
            ]);

            DB::commit();
            return redirect()->route('admin.batch')->with('msg_success', 'Batch Created Successfully !');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.batch')->with('msg_error', 'Batch Not Created Successfully !');
        }
    }
    public function add_new_img()
    {
        $title = 'Batches';
        $page = 'admin.batchs_img.add_new_img';
        $js = ['batch'];

        return view('layouts.admin.layout', compact('title', 'page', 'js'));
    }
    public function updateMetadata(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date_created' => 'nullable|date',
            'country' => 'nullable|string|max:100',
            'keywords' => 'nullable|string',
        ]);

        $file = BatchFile::where('id', $id)
            ->firstOrFail();

        $file->update([
            'title'        => $request->title,
            'description'  => $request->description,
            'date_created' => $request->date_created,
            'country'      => $request->country,
            'keywords'     => $request->keywords,
            'status'       => 'not_submitted', // or keep draft logic
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Metadata saved successfully'
        ]);
    }
    public function delete($id)
    {
        $file = BatchFile::where('id', $id)
            // ->where('user_id', auth()->id())
            ->firstOrFail();

        DB::beginTransaction();

        try {
            if ($file->file_path && Storage::exists($file->file_path)) {
                Storage::delete($file->file_path);
            }

            if ($file->thumbnail_path && Storage::exists($file->thumbnail_path)) {
                Storage::delete($file->thumbnail_path);
            }

            $batchId = $file->batch_id;

            $file->delete();

            Batch::where('id', $batchId)->decrement('total_files');

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'File deleted successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => 'Something went wrong'
            ], 500);
        }
    }
    public function deleteMultiple(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer'
        ]);

        DB::beginTransaction();

        try {

            $files = BatchFile::whereIn('id', $request->ids)
                // ->where('user_id', auth()->id())
                ->get();

            $deletedCount = 0;

            foreach ($files as $file) {

                if ($file->file_path && Storage::exists($file->file_path)) {
                    Storage::delete($file->file_path);
                }

                if ($file->thumbnail_path && Storage::exists($file->thumbnail_path)) {
                    Storage::delete($file->thumbnail_path);
                }

                $file->delete();
                $deletedCount++;
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => $deletedCount . ' files deleted successfully'
            ]);
        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => 'Something went wrong'
            ], 500);
        }
    }
    public function uploadMultipleOld(Request $request, String $batch_id)
    {
        $request->validate([
            'files' => 'required',
            'files.*' => 'image|max:10240' // 10MB each
        ]);

        DB::beginTransaction();

        try {

            $manager = new ImageManager(new Driver());

            $uploadDirHigh = public_path('uploads/batch/high/');
            $uploadDirLow  = public_path('uploads/batch/low/');

            foreach ([$uploadDirHigh, $uploadDirLow] as $dir) {
                if (!file_exists($dir)) {
                    mkdir($dir, 0755, true);
                }
            }

            foreach ($request->file('files') as $file) {

                $imageName = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();

                $img = $manager->read($file->getRealPath());

                $width = $img->width();
                $height = $img->height();
                $size = $file->getSize();

                $img->save($uploadDirHigh . $imageName, 90);

                $low = $manager->read($file->getRealPath());

                $watermarkPath = public_path('watermark.png');

                if (file_exists($watermarkPath)) {
                    $wm = $manager->read($watermarkPath);
                    $wm->scale(width: $low->width() * 0.1);
                    $low->place($wm, 'bottom-right', 10, 10);
                }

                $low->scale(width: 800)
                    ->save($uploadDirLow . 'low_' . $imageName, 60);

                // STORE IN DB
                BatchFile::create([
                    'batch_id'     => $batch_id,
                    // 'user_id'      => auth()->id(),
                    'file_code'    => mt_rand(1000000000, 9999999999),
                    'original_name' => $file->getClientOriginalName(),
                    'file_name'    => $imageName,
                    'file_path'    => 'uploads/batch/high/' . $imageName,
                    'thumbnail_path' => 'uploads/batch/low/low_' . $imageName,
                    'file_type'    => 'image',
                    'file_size'    => $size,
                    'width'        => $width,
                    'height'       => $height,
                    'status'       => 'not_submitted',
                ]);
            }
            $batch = Batch::where('id', $batch_id)->first();
            $fileCount = $request->hasFile('files')
                ? count($request->file('files'))
                : 0;

            if ($fileCount > 0) {
                $batch->increment('total_files', $fileCount);
            }

            DB::commit();


            dd(1);
            return redirect()->route('admin.batch')->with('msg_success', 'Batch Images uploaded successfully!');
        } catch (\Exception $e) {
            dd(2, $e);
            return redirect()->route('admin.batch')->with('msg_error', 'Batch Images not uploaded successfully!');
        }
    }

    // public function uploadMultiple(Request $request, String $batch_id)
    // {
    //     $request->validate([
    //         'files' => 'required',
    //         'files.*' => 'required|file|mimes:jpg,jpeg,png,webp,zip|max:51200'
    //     ]);

    //     // DB::beginTransaction();

    //     try {

    //         $manager = new ImageManager(new Driver());
    //         foreach ($request->file('files') as $file) {
    //             $extension = $file->getClientOriginalExtension();
    //             if ($extension === 'zip') {
    //                 $zip = new \ZipArchive;
    //                 $zipPath = $file->getRealPath();
    //                 if ($zip->open($zipPath) === TRUE) {
    //                     $extractPath = storage_path('app/temp/' . uniqid());
    //                     mkdir($extractPath, 0777, true);
    //                     $zip->extractTo($extractPath);
    //                     $zip->close();
    //                     // $images = glob($extractPath . '/*.{jpg,jpeg,png,webp}', GLOB_BRACE);
    //                     $images = glob($extractPath . '/*.{jpg,jpeg,png,webp,JPG,JPEG,PNG,WEBP}', GLOB_BRACE);
    //                     dd($images);
    //                     foreach ($images as $imagePath) {
    //                         $this->processImage($imagePath, $batch_id);
    //                     }

    //                     // Clean temp folder
    //                     File::deleteDirectory($extractPath);
    //                 }
    //             } else {
    //                 // ✅ Normal image
    //                 $this->processImage($file->getRealPath(), $batch_id, $file);
    //             }
    //         }

    //         // DB::commit();

    //         return back()->with('success', 'Images uploaded to S3 successfully');
    //     } catch (\Exception $e) {
    //         dd($e);
    //         // DB::rollBack();
    //         return back()->with('error', $e->getMessage());
    //     }
    // }
    // private function processImage($path, $batch_id, $fileObj = null)
    // {
    //     try {

    //         $manager = new ImageManager(new Driver());

    //         $imageName = uniqid() . '.webp';

    //         $img = $manager->read($path);

    //         $width  = $img->width();
    //         $height = $img->height();
    //         $size   = $fileObj ? $fileObj->getSize() : filesize($path);

    //         // HIGH
    //         Storage::disk('s3')->put(
    //             "batch/high/$imageName",
    //             $img->encode(new WebpEncoder(quality: 85))->toString(),
    //             'public'
    //         );

    //         // LOW
    //         $low = $img->scale(width: 800);

    //         Storage::disk('s3')->put(
    //             "batch/low/low_$imageName",
    //             $low->encode(new WebpEncoder(quality: 75))->toString(),
    //             'public'
    //         );

    //         BatchFile::create([
    //             'batch_id'       => $batch_id,
    //             'file_code'      => mt_rand(1000000000, 9999999999),
    //             'original_name'  => $fileObj ? $fileObj->getClientOriginalName() : basename($path),
    //             'file_name'      => $imageName,
    //             'file_path'      => "batch/high/$imageName",
    //             'thumbnail_path' => "batch/low/low_$imageName",
    //             'file_type'      => 'image',
    //             'file_size'      => $size,
    //             'width'          => $width,
    //             'height'         => $height,
    //             'status'         => 'not_submitted',
    //         ]);

    //         // 🔥 FREE MEMORY
    //         $img = null;
    //         unset($img);
    //         gc_collect_cycles();
    //     } catch (\Throwable $e) {
    //         \Log::error($e->getMessage());
    //     }
    // }
    public function uploadZip(Request $request, $batch_id)
    {
        $request->validate([
            'files' => 'required',
            'files.*' => 'required|file|mimes:jpg,jpeg,png,webp,zip|max:51200'
        ]);

        $file = $request->file('files');
        try {

            // Upload ZIP directly to S3
            $zipPath = Storage::disk('s3')->put('batch-zips', $file);

            // Update batch status
            Batch::where('id', $batch_id)->update([
                'status' => 'reviewing'
            ]);

            // Dispatch background job
            ProcessBatchVideo::dispatch($zipPath, $batch_id);

            return back()->with('msg_success', 'Zip uploaded. Processing started.');
        } catch (\Exception $e) {
            dd($e);
            // DB::rollBack();
            return back()->with('msg_error', $e->getMessage());
        }
    }

    public function uploadMultipleVideos(Request $request, String $batch_id)
    {
        // dd(Storage::disk('s3')->put('test.txt', 'Hello World'));
        // dd($request);
        $request->validate([
            'files' => 'required',
            'files.*' => 'mimes:mp4,mov,avi|max:512000'
        ]);

        DB::beginTransaction();

        try {

            foreach ($request->file('files') as $file) {

                $fileName = uniqid() . '.' . $file->getClientOriginalExtension();

                $path = Storage::disk('s3')->putFileAs(
                    'videos/high',
                    $file,
                    $fileName,
                    'public'
                );

                // dd($path);

                $batchFile = BatchFile::create([
                    'batch_id' => $batch_id,
                    'file_code' => mt_rand(1000000000, 9999999999),
                    'original_name' => $file->getClientOriginalName(),
                    'file_name' => $fileName,
                    'file_path' => (string)$path,
                    'file_type' => 'video',
                    'status' => 'accepted'
                ]);


                // ProcessBatchVideo::dispatch($batchFile->id);
                ProcessBatchVideo::dispatch($batchFile->id)->onQueue('videos');
            }

            DB::commit();
            return back()->with('success', 'Videos uploaded to S3 successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
            return back()->with('error', $e->getMessage());
        }
    }
    public function uploadMultipleVideosOld(Request $request, String $batch_id)
    {
        // dd($request);
        $request->validate([
            'files' => 'required',
            'files.*' => 'mimes:mp4,mov,avi|max:512000' // 500MB each
        ]);

        DB::beginTransaction();

        try {
            $highDir = public_path('uploads/videos/high/');
            if (!file_exists($highDir)) {
                mkdir($highDir, 0755, true);
            }
            foreach ($request->file('files') as $file) {
                // $originalFilename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
                $originalFilename = uniqid('', true) . '_' . Str::uuid() . '.' . $file->getClientOriginalExtension();
                $file->move($highDir, $originalFilename);
                $tempOriginalPath = $highDir . $originalFilename;

                $ffprobe = FFProbe::create([
                    'ffmpeg.binaries'  => env('FFMPEG_BINARY_PATH'),
                    'ffprobe.binaries' => env('FFPROBE_BINARY_PATH'),
                ]);

                $duration = $ffprobe
                    ->format($tempOriginalPath)
                    ->get('duration');

                $videoStream = $ffprobe
                    ->streams($tempOriginalPath)
                    ->videos()
                    ->first();

                $width  = $videoStream->get('width');
                $height = $videoStream->get('height');

                $frameRate = $videoStream->get('r_frame_rate');

                // Convert frame rate from "30/1" format
                if ($frameRate) {
                    $parts = explode('/', $frameRate);
                    $fps = isset($parts[1]) && $parts[1] != 0
                        ? round($parts[0] / $parts[1], 2)
                        : null;
                } else {
                    $fps = null;
                }
                $batchFile = BatchFile::create([
                    'batch_id'   => $batch_id,
                    // 'user_id'    => auth()->id(),
                    'file_code'  => mt_rand(1000000000, 9999999999),
                    'original_name' => $file->getClientOriginalName(),
                    'file_name'  => $originalFilename,
                    'file_path'  => 'uploads/videos/high/' . $originalFilename,
                    'file_type'  => 'video',
                    'status'     => 'submitted',

                    'width'         => $width,
                    'height'        => $height,
                    'duration'      => round($duration, 2),
                    'frame_rate'    => $fps,
                ]);

                // ProcessBatchVideo::dispatch($batchFile->id, $tempOriginalPath);
                ProcessBatchVideo::dispatch($batchFile->id);
            }

            $batch = Batch::where('id', $batch_id)->first();
            $fileCount = $request->hasFile('files')
                ? count($request->file('files'))
                : 0;

            if ($fileCount > 0) {
                $batch->increment('total_files', $fileCount);
            }
            DB::commit();
            dd(1);
            return redirect()->back()->with('success', 'Videos uploaded successfully');
        } catch (\Exception $e) {

            DB::rollBack();
            dd(2, $e);
            return redirect()->back()->with('error', 'Upload failed');
        }
    }
}
