<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\ProcessBatchVideo;
use App\Jobs\ProcessUploadedVideo;
use App\Models\Batch;
use App\Models\BatchFile;
use Carbon\Carbon;
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
use Illuminate\Support\Facades\Log;

use Intervention\Image\Drivers\Gd\Driver as GdDriver;
// use Intervention\Image\ImageManager;

class BatchController extends Controller
{
    // public function index()
    // {

    //     $title = 'Batches';
    //     $page = 'admin.batchs_img.add';
    //     $js = ['batch'];

    //     $batches = Batch::with(['batch_files'])
    //         ->where('user_id', Auth::id())
    //         ->latest()
    //         ->paginate(6); // number per page

    //     // $batch_list = $batches->map(function ($batch) {
    //     //     return [
    //     //         'id'            => $batch->id,
    //     //         'batch_code'    => $batch->batch_code,
    //     //         'title'         => $batch->title,
    //     //         'submission_type' => $batch->submission_type,
    //     //         'brief_code'    => $batch->brief_code,
    //     //         'status'        => $batch->status,
    //     //         'total_files'   => $batch->batch_files->count(),
    //     //         'created_at'    => $batch->created_at->format('Y-m-d'),

    //     //         'batch_files' => $batch->batch_files->map(function ($file) {
    //     //             return [
    //     //                 'id'              => $file->id,
    //     //                 'file_code'       => $file->file_code,
    //     //                 'original_name'   => $file->original_name,
    //     //                 'file_name'       => $file->file_name,
    //     //                 'type'            => $file->type,
    //     //                 'file_path'       => asset('uploads/videos/high/' . $file->original_name),
    //     //                 'thumbnail_path'  => !empty($file->thumbnail_path)
    //     //                     ? asset('uploads/batch/videos/thumbnails/' . $file->thumbnail_path)
    //     //                     : null,
    //     //                 'low_path'  => !empty($file->thumbnail_path)
    //     //                     ? asset('uploads/batch/images/low/' . $file->low_path)
    //     //                     : null,
    //     //                 'file_type'       => $file->file_type,
    //     //                 'file_size'       => $file->file_size,
    //     //                 'width'           => $file->width,
    //     //                 'height'          => $file->height,
    //     //                 'duration'        => $file->duration,
    //     //                 'status'          => $file->status,
    //     //                 'rejection_reason' => $file->rejection_reason,
    //     //                 'created_at'      => $file->created_at->format('Y-m-d H:i:s'),
    //     //             ];
    //     //         })
    //     //     ];
    //     // });
    //     $batch_list = $batches->through(function ($batch) {

    //         return [
    //             'id' => $batch->id,
    //             'batch_code' => $batch->batch_code,
    //             'title' => $batch->title,
    //             'submission_type' => $batch->submission_type,
    //             'brief_code' => $batch->brief_code,
    //             'status' => $batch->status,
    //             'total_files' => $batch->batch_files->count(),
    //             'created_at' => $batch->created_at->format('Y-m-d'),

    //             'batch_files' => $batch->batch_files->map(function ($file) {

    //                 return [
    //                     'id' => $file->id,
    //                     'file_code' => $file->file_code,
    //                     'original_name' => $file->original_name,
    //                     'file_name' => $file->file_name,
    //                     'type' => $file->type,
    //                     'file_path' => asset('uploads/videos/high/' . $file->original_name),

    //                     'thumbnail_path' => !empty($file->thumbnail_path)
    //                         ? asset('uploads/batch/videos/thumbnails/' . $file->thumbnail_path)
    //                         : null,

    //                     'low_path' => !empty($file->low_path)
    //                         ? asset('uploads/batch/images/low/' . $file->low_path)
    //                         : null,

    //                     'file_type' => $file->file_type,
    //                     'file_size' => $file->file_size,
    //                     'width' => $file->width,
    //                     'height' => $file->height,
    //                     'duration' => $file->duration,
    //                     'status' => $file->status,
    //                     'rejection_reason' => $file->rejection_reason,
    //                     'created_at' => $file->created_at->format('Y-m-d H:i:s'),
    //                 ];
    //             })
    //         ];
    //     });

    //     return view('layouts.admin.layout', compact('title', 'page', 'js', 'batch_list', 'batches'));
    // }

    public function index(Request $request)
    {



        $title = 'Batches';
        $page = 'admin.batchs_img.add';
        $js = ['batch'];

        // dd($request->submission_type);
        $query = Batch::with(['batch_files']);
        // ->where('user_id', Auth::id());

        // 🔎 Search
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('batch_code', 'like', '%' . $request->search . '%');
            });
        }

        // 📷 Submission Type
        if ($request->submission_type) {
            $query->whereIn('submission_type', $request->submission_type);
        }

        // 📊 Status
        if ($request->has('status') && !empty($request->status)) {
            // dd(1);
            $query->where(function ($q) use ($request) {

                // Active batches (any image not edited)
                if (in_array('1', $request->status)) {

                    $q->orWhereHas('batch_files', function ($f) {
                        $f->where('is_edited', '0');
                    });
                }

                // Close batches (all images not edited)
                if (in_array('0', $request->status)) {

                    $q->orWhereHas('batch_files', function ($f) {
                        $f->where('is_edited', '1');
                    });
                }
            });
        }
        // 📅 Date Range

        if ($request->start_date && $request->end_date) {
            $query->whereBetween('created_at', [
                Carbon::parse($request->start_date)->startOfDay(),
                Carbon::parse($request->end_date)->endOfDay()
            ]);
        }
        $sortColumn = $request->select_field ?? 'id';
        $sortDirection = $request->direction ?? 'desc';

        $allowedColumns = ['id', 'title', 'created_at'];

        if (in_array($sortColumn, $allowedColumns)) {
            $query->orderBy($sortColumn, $sortDirection);
        }

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('created_at', 'like', '%' . $request->search . '%');
            });
        }
        // $batches = $query->latest()->paginate(6);
        $batches = $query->latest()->paginate(6)->withQueryString();
        // dd($batches);
        $batch_list = $batches->through(function ($batch) {

            return [
                'id' => $batch->id,
                'batch_code' => $batch->batch_code,
                'title' => $batch->title,
                'submission_type' => $batch->submission_type,
                'brief_code' => $batch->brief_code,
                'status' => $batch->status,
                'total_files' => $batch->batch_files->count(),
                'created_at' => $batch->created_at->format('Y-m-d'),
                'updated_at' => $batch->created_at->format('Y-m-d'),

                'batch_files' => $batch->batch_files->map(function ($file) {

                    return [
                        'id' => $file->id,
                        'file_code' => $file->file_code,
                        'original_name' => $file->original_name,
                        'title' => $file->title,
                        'file_name' => $file->file_name,
                        'type' => $file->type,
                        // 'file_path' => asset('uploads/videos/high/' . $file->original_name),

                        // 'thumbnail_path' => !empty($file->thumbnail_path)
                        //     ? asset('uploads/batch/videos/thumbnails/' . $file->thumbnail_path)
                        //     : null,

                        // 'low_path' => !empty($file->low_path)
                        //     ? asset('uploads/batch/images/low/' . $file->low_path)
                        //     : null,
                        'file_path' => Storage::disk('s3')->url($file->file_path),
                        'thumbnail_path' => !empty($file->thumbnail_path)
                            ? Storage::disk('s3')->url(ltrim($file->thumbnail_path, '/'))
                            : asset('assets/admin/images/demo_thumbnail.png'),

                        'low_path' => !empty($file->low_path)
                            ? Storage::disk('s3')->url(ltrim($file->low_path, '/'))
                            : null,
                        'file_type' => $file->file_type,
                        'file_size' => $file->file_size,
                        'width' => $file->width,
                        'height' => $file->height,
                        'duration' => $file->duration,
                        'status' => $file->status,
                        'rejection_reason' => $file->rejection_reason,
                        'created_at' => $file->created_at->format('Y-m-d H:i:s'),
                    ];
                })
            ];
        });

        // dd($batch_list);
        // ✅ AJAX response
        if ($request->ajax()) {
            return view('admin.batchs_img.batch_card', compact('batch_list', 'batches'))->render();
        }

        return view('layouts.admin.layout', compact('title', 'page', 'js', 'batch_list', 'batches'));
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

    public function add_new_img(String $batch_id)
    {
        $title = 'Batches';
        $page = 'admin.batchs_img.add_new_img';
        $js = ['batch'];
        $batch_id = decrypt($batch_id);
        $batch_data = BatchFile::where('batch_id', $batch_id)->get();
        $batch = Batch::where('id', $batch_id)->first();
        // dd($batch_id);
        return view('layouts.admin.layout', compact('title', 'page', 'js', 'batch_data', 'batch_id', 'batch'));
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

            if ($files->isEmpty()) {
                return response()->json([
                    'status' => false,
                    'message' => 'No files found'
                ]);
            }

            $deletedCount = 0;
            foreach ($files as $file) {
                if ($file->file_path && Storage::disk('s3')->exists($file->file_path)) {
                    Storage::disk('s3')->delete($file->file_path);
                }

                // THUMBNAIL
                if ($file->thumbnail_path && Storage::disk('s3')->exists($file->thumbnail_path)) {
                    Storage::disk('s3')->delete($file->thumbnail_path);
                }

                // LOW FILE
                if ($file->low_path && Storage::disk('s3')->exists($file->low_path)) {
                    Storage::disk('s3')->delete($file->low_path);
                }

                $batchId = $file->batch_id;
                $file->delete();
                Batch::where('id', $batchId)->decrement('total_files');
                $deletedCount++;
            }
            $totalRemaining = BatchFile::where('batch_id', $batchId)->count();
            DB::commit();
            return response()->json([
                'status' => true,
                'total' => $totalRemaining,
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

    // private function processImage($path, $batch_id, $fileObj = null, $manager)
    // {
    //     try {

    //         $imageName = Str::uuid() . '.webp';

    //         $img = $manager->read($path);

    //         $width  = $img->width();
    //         $height = $img->height();
    //         $size   = $fileObj ? $fileObj->getSize() : filesize($path);

    //         $originalName = $fileObj
    //             ? $fileObj->getClientOriginalName()
    //             : basename($path);

    //         // HIGH IMAGE
    //         Storage::disk('s3')->put(
    //             "batch/image/high/$imageName",
    //             $img->encode(new WebpEncoder(quality: 85))->toString(),
    //             ['visibility' => 'public']
    //         );

    //         // LOW IMAGE
    //         $low = $img->scale(width: 800);

    //         Storage::disk('s3')->put(
    //             "batch/image/low/low_$imageName",
    //             $low->encode(new WebpEncoder(quality: 75))->toString(),
    //             ['visibility' => 'public']
    //         );

    //         BatchFile::create([
    //             'batch_id'       => $batch_id,
    //             'file_code'      => mt_rand(1000000000, 9999999999),
    //             'original_name'  => $originalName,
    //             'title'          => pathinfo($originalName, PATHINFO_FILENAME),
    //             'file_name'      => $imageName,
    //             'file_path'      => "batch/image/high/$imageName",
    //             'thumbnail_path' => "",
    //             'low_path'       => "batch/image/low/low_$imageName",
    //             'file_type'      => 'image',
    //             'type'           => 'image',
    //             'file_size'      => $size,
    //             'width'          => $width,
    //             'height'         => $height,
    //             'status'         => 'not_submitted',
    //         ]);

    //         // free memory
    //         $img = null;
    //         $low = null;

    //         unset($img, $low);

    //         gc_collect_cycles();
    //     } catch (\Throwable $e) {

    //         Log::error($e->getMessage());
    //     }
    // }

    private function processVideo($file, $batch_id)
    {
        set_time_limit(300);

        $fileName = Str::uuid() . '.mp4';
        if (is_string($file)) {

            // file path (extracted from ZIP)
            $path = Storage::disk('s3')->put(
                'batch/videos/high/' . $fileName,
                fopen($file, 'r'),
                ['visibility' => 'public']
            );

            $originalName = basename($file);
        } else {

            // uploaded file
            $path = Storage::disk('s3')->putFileAs(
                'batch/videos/high',
                $file,
                $fileName,
                ['visibility' => 'public']
            );

            $originalName = $file->getClientOriginalName();
        }

        $originalNameOnly = pathinfo($originalName, PATHINFO_FILENAME);

        // $videoPath = public_path('uploads/batch/videos/high/');

        // // create directory if not exists
        // if (!file_exists($videoPath)) {
        //     mkdir($videoPath, 0777, true);
        // }

        // if (is_string($file)) {
        //     // file coming from extracted ZIP
        //     copy($file, $videoPath . $fileName);

        //     $path = "uploads/batch/videos/high/" . $fileName;
        //     $originalName = basename($file);
        // } else {
        //     // uploaded directly from form
        //     $file->move($videoPath, $fileName);

        //     $path = "uploads/batch/videos/high/" . $fileName;
        //     $originalName = $file->getClientOriginalName();
        // }

        $batchFile = new BatchFile();
        $batchFile->batch_id = $batch_id;
        $batchFile->file_code = Str::random(9);
        $batchFile->original_name = $originalName;
        $batchFile->file_name = $fileName;
        $batchFile->file_path = $path;
        $batchFile->file_type = 'video';
        $batchFile->type = 'video';
        $batchFile->title = $originalNameOnly;
        $batchFile->date_created = Carbon::now()->toDateString();
        $batchFile->status = 'accepted';
        $batchFile->save();

        ProcessBatchVideo::dispatch($batchFile->id)->onQueue('videos');
    }


    // public function uploadFiles(Request $request, $batch_id)
    // {
    //     set_time_limit(600);
    //     $request->validate([
    //         'files' => 'required',
    //         'files.*' => 'file|mimes:jpg,jpeg,png,webp,mp4,mov,avi,zip|max:512000'
    //     ]);
    //     DB::beginTransaction();

    //     try {
    //         $extractPath = null;
    //         foreach ($request->file('files') as $file) {
    //             $extension = strtolower($file->getClientOriginalExtension());
    //             if ($extension === 'zip') {
    //                 $zip = new \ZipArchive;
    //                 $zipPath = $file->getRealPath();

    //                 if ($zip->open($zipPath) === TRUE) {

    //                     $extractPath = storage_path('app/temp/' . uniqid());
    //                     mkdir($extractPath, 0777, true);

    //                     $zip->extractTo($extractPath);
    //                     $zip->close();

    //                     $files = glob($extractPath . '/*.{jpg,jpeg,png,webp,mp4,mov,avi}', GLOB_BRACE);
    //                     $files = File::allFiles($extractPath);

    //                     foreach ($files as $zipFile) {

    //                         $ext = strtolower($zipFile->getExtension());

    //                         if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'mp4', 'mov', 'avi'])) {

    //                             $path = $zipFile->getPathname();

    //                             if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp']) && $request->batch_type == 'image') {
    //                                 $this->processImage($path, $batch_id);
    //                             }

    //                             if (in_array($ext, ['mp4', 'mov', 'avi']) && $request->batch_type == 'video') {
    //                                 $this->processVideo($path, $batch_id);
    //                             }
    //                         }
    //                     }
    //                     File::deleteDirectory($extractPath);
    //                 }
    //             } elseif (in_array($extension, ['jpg', 'jpeg', 'png', 'webp'])) {
    //                 $this->processImage($file->getRealPath(), $batch_id, $file);
    //             } elseif (in_array($extension, ['mp4', 'mov', 'avi'])) {
    //                 $this->processVideo($file, $batch_id);
    //             }
    //         }
    //         DB::commit();
    //         return response()->json([
    //             'status' => 'success',
    //             'message' => 'Files uploaded successfully'
    //         ]);
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => $e->getMessage()
    //         ], 500);
    //     } finally {
    //         if ($extractPath && File::exists($extractPath)) {
    //             File::deleteDirectory($extractPath);
    //         }
    //     }
    // }

    public function uploadFiles(Request $request, $batch_id)
    {
        Log::info('Files received: ' . count($request->file('files') ?? []));

        set_time_limit(600);
        $request->validate([
            'files' => 'required',
            'files.*' => 'file|mimes:jpg,jpeg,png,webp,mp4,mov,avi,zip|max:512000'
        ]);

        // Initialize manager ONCE here, reuse across all images
        $manager = new ImageManager(new GdDriver());

        DB::beginTransaction();

        try {
            $extractPath = null;
            foreach ($request->file('files') as $file) {
                $extension = strtolower($file->getClientOriginalExtension());

                if ($extension === 'zip') {
                    $zip = new \ZipArchive;
                    $zipPath = $file->getRealPath();

                    if ($zip->open($zipPath) === TRUE) {
                        $extractPath = storage_path('app/temp/' . uniqid());
                        mkdir($extractPath, 0777, true);
                        $zip->extractTo($extractPath);
                        $zip->close();

                        $files = File::allFiles($extractPath);

                        foreach ($files as $zipFile) {
                            $ext = strtolower($zipFile->getExtension());

                            if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp']) && $request->batch_type == 'image') {
                                // Pass $manager as 4th argument — this was the bug!
                                $this->processImage($zipFile->getPathname(), $batch_id, null, $manager);
                            }

                            if (in_array($ext, ['mp4', 'mov', 'avi']) && $request->batch_type == 'video') {
                                $this->processVideo($zipFile->getPathname(), $batch_id);
                            }
                        }

                        File::deleteDirectory($extractPath);
                        $extractPath = null;
                    }
                } elseif (in_array($extension, ['jpg', 'jpeg', 'png', 'webp'])) {
                    // Pass $manager as 4th argument — this was the bug!
                    $this->processImage($file->getRealPath(), $batch_id, $file, $manager);
                } elseif (in_array($extension, ['mp4', 'mov', 'avi'])) {
                    $this->processVideo($file, $batch_id);
                }
            }

            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'Files uploaded successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        } finally {
            if ($extractPath && File::exists($extractPath)) {
                File::deleteDirectory($extractPath);
            }
        }
    }


    private function processImage($path, $batch_id, $fileObj = null, $manager = null)
    {
        try {
            // Fallback if manager not passed (defensive)
            if (!$manager) {
                $manager = new ImageManager(new GdDriver());
            }

            $imageName = Str::uuid() . '.webp';
            $img = $manager->read($path);

            $width        = $img->width();
            $height       = $img->height();
            $size         = $fileObj ? $fileObj->getSize() : filesize($path);
            $originalName = $fileObj ? $fileObj->getClientOriginalName() : basename($path);

            // Encode HIGH quality once, reuse the string
            $highEncoded = $img->encode(new WebpEncoder(quality: 85))->toString();

            Storage::disk('s3')->put(
                "batch/image/high/$imageName",
                $highEncoded,
                ['visibility' => 'public']
            );

            // Scale down for LOW version
            $lowEncoded = $img->scale(width: 800)->encode(new WebpEncoder(quality: 75))->toString();

            Storage::disk('s3')->put(
                "batch/image/low/low_$imageName",
                $lowEncoded,
                ['visibility' => 'public']
            );

            BatchFile::create([
                'batch_id'       => $batch_id,
                'file_code'      => mt_rand(1000000000, 9999999999),
                'original_name'  => $originalName,
                'title'          => pathinfo($originalName, PATHINFO_FILENAME),
                'file_name'      => $imageName,
                'file_path'      => "batch/image/high/$imageName",
                'thumbnail_path' => "",
                'low_path'       => "batch/image/low/low_$imageName",
                'file_type'      => 'image',
                'type'           => 'image',
                'file_size'      => $size,
                'width'          => $width,
                'height'         => $height,
                'status'         => 'not_submitted',
            ]);
        } catch (\Throwable $e) {
            Log::error('processImage failed: ' . $e->getMessage());
        } finally {
            // Always free memory
            unset($img, $lowEncoded, $highEncoded);
            gc_collect_cycles();
        }
    }
    public function checkBriefCode(Request $request)
    {
        // dd(1);
        $exists = Batch::where('brief_code', $request->brief_code)->exists();

        if ($exists) {
            return response()->json(false); // invalid (already exists)
        }

        return response()->json(true); // valid (unique)
    }

    public function getFileMetadata(Request $request)
    {
        $file = BatchFile::find($request->file_id);

        return response()->json($file);
    }

    public function saveFileMetadata(Request $request)
    {
        // dd($request);
        $file = BatchFile::findOrFail($request->file_id);

        $file->update([
            'category_id' => $request->category_id,
            'title' => $request->title,
            'description' => $request->description,
            'date_created' => $request->date_created,
            'keywords' => $request->tags,
            'is_edited' => '1',
            'price' => $request->price,
            'country' => $request->country,
            'subcategory_id' => $request->subcategory_id,
            'collection_id' => $request->collection_id
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Metadata saved'
        ]);
    }

    public function UpdateBatchName(Request $request)
    {
        $batch = Batch::find($request->batch_id);
        $batch->title = $request->branch_name;
        $batch->save();
        return response()->json([
            'status' => 1,
            'message' => 'Batch name updated'
        ]);
    }

    public function DeleteBatch(Request $request)
    {
        $batch = Batch::find($request->batch_id);
        $batch->delete();
        return response()->json([
            'status' => 1,
            'message' => 'Batch deleted'
        ]);
    }
}
