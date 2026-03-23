<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\GenerateImageVariants;
use App\Jobs\ProcessBatchVideo;
use App\Jobs\ProcessUploadedVideo;
use App\Models\Batch;
use App\Models\BatchFile;
use Carbon\Carbon;
use Exception;
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
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Client\ConnectionException;
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
        // if ($request->search) {
        //     // dd($request->search);
        //     $query->where(function ($q) use ($request) {
        //         $q->where('title', 'like', '%' . $request->search . '%')
        //             ->orWhere('batch_code', 'like', '%' . $request->search . '%');
        //     });
        // }

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
                    ->orWhere('created_at', 'like', '%' . $request->search . '%')
                    ->orWhere('batch_code', 'like', '%' . $request->search . '%');
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
                        'mid_path' => !empty($file->mid_path)
                            ? Storage::disk('s3')->url(ltrim($file->mid_path, '/'))
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


    private function processImageOld($path, $batch_id, $fileObj = null, $manager = null)
    {
        try {
            if (!$manager) {
                $manager = new ImageManager(new GdDriver());
            }
            $imageName    = Str::uuid() . '.webp';
            $img          = $manager->read($path);

            $width        = $img->width();
            $height       = $img->height();
            $size         = $fileObj ? $fileObj->getSize() : filesize($path);
            $originalName = $fileObj ? $fileObj->getClientOriginalName() : basename($path);

            $highImg = $manager->read($path);
            $HighEncoded = $highImg->encode(new WebpEncoder(quality: 100))->toString();
            Storage::disk('s3')->put(
                "batch/image/high/$imageName",
                $HighEncoded,
                ['visibility' => 'public']
            );


            $watermarkPath = storage_path('app/watermark.png');

            // ── Dynamic watermark size based on image megapixels ──────────────────
            // ── Dynamic watermark size based on image megapixels ─────────────────────
            $megapixels = ($width * $height) / 1000000;

            $wmPercent = match (true) {
                $megapixels >= 20 => 0.35,  // Very large  (20MP+)
                $megapixels >= 10 => 0.38,  // Large       (10-20MP)
                $megapixels >= 5  => 0.40,  // Medium      (5-10MP)
                $megapixels >= 2  => 0.43,  // Small-med   (2-5MP)
                default           => 0.45,  // Small       (<2MP)
            };


            $wmSize = (int)($width * $wmPercent);

            // ── MID — 80% quality, original size, WITH watermark ─────────────────
            $midImg  = clone $img;
            $wmMid  = $manager->read($watermarkPath);
            $wmMid->scale(width: $wmSize);

            // Getty style — bottom center with opacity
            $midImg->place($wmMid, 'bottom', 0, 30);

            $midEncoded = $midImg->encode(new WebpEncoder(quality: 80))->toString();
            Storage::disk('s3')->put(
                "batch/image/mid/mid_$imageName",
                $midEncoded,
                ['visibility' => 'public']
            );

            // ── LOW — 60% quality, original size, WITH watermark ─────────────────
            // $lowImg = $manager->read($path);
            // $wmLow  = $manager->read($watermarkPath);
            // $wmLow->scale(width: $wmSize);

            // // Getty style — bottom center with opacity
            // $lowImg->place($wmLow, 'bottom', 0, 30);

            // $lowEncoded = $lowImg->encode(new WebpEncoder(quality: 60))->toString();
            // Storage::disk('s3')->put(
            //     "batch/image/low/low_$imageName",
            //     $lowEncoded,
            //     ['visibility' => 'public']
            // );
            BatchFile::create([
                'batch_id'       => $batch_id,
                'file_code'      => mt_rand(1000000000, 9999999999),
                'original_name'  => $originalName,
                'title'          => pathinfo($originalName, PATHINFO_FILENAME),
                'file_name'      => $imageName,
                'file_path'      => "batch/image/high/$imageName",
                'mid_path'       => "batch/image/mid/mid_$imageName",
                'low_path'       => "batch/image/low/low_$imageName",
                'thumbnail_path' => "",
                'file_type'      => 'image',

                'date_created' => Carbon::now()->toDateString(),
                'type'           => 'image',
                'file_size'      => $size,
                'width'          => $width,
                'height'         => $height,
                'status'         => 'not_submitted',
            ]);
        } catch (\Throwable $e) {
            Log::error('processImage failed: ' . $e->getMessage());
        } finally {
            unset($img, $midImg, $lowImg, $highEncoded, $midEncoded, $lowEncoded, $wmMid, $wmLow);
            gc_collect_cycles();
        }
    }
    private function processImage($path, $batch_id, $fileObj = null, $manager = null)
    {
        try {
            $imageName    = Str::uuid() . '.' . ($fileObj ? $fileObj->getClientOriginalExtension() : pathinfo($path, PATHINFO_EXTENSION));
            $originalName = $fileObj ? $fileObj->getClientOriginalName() : basename($path);
            $size         = $fileObj ? $fileObj->getSize() : filesize($path);

            // Get dimensions only (fast, no encoding)
            if (!$manager) {
                $manager = new ImageManager(new GdDriver());
            }
            $img    = $manager->read($path);
            $width  = $img->width();
            $height = $img->height();
            unset($img);

            // Upload raw file directly to S3 — no encoding at all
            $highPath = "batch/image/high/$imageName";
            Storage::disk('s3')->put(
                $highPath,
                file_get_contents($path),
                ['visibility' => 'public']
            );
            $batchFile = BatchFile::create([
                'batch_id'       => $batch_id,
                'file_code'      => mt_rand(1000000000, 9999999999),
                'original_name'  => $originalName,
                'title'          => pathinfo($originalName, PATHINFO_FILENAME),
                'file_name'      => $imageName,
                'file_path'      => $highPath,
                'mid_path'       => null,   // filled by job
                'low_path'       => null,
                'thumbnail_path' => null,   // filled by job
                'file_type'      => 'image',
                'type'           => 'image',
                'date_created'   => Carbon::now()->toDateString(),
                'file_size'      => $size,
                'width'          => $width,
                'height'         => $height,
                // 'status'         => 'processing',
            ]);

            // Dispatch background job for mid (watermarked) + thumbnail
            GenerateImageVariants::dispatch($batchFile->id, $highPath)->onQueue('images');
        } catch (\Throwable $e) {
            Log::error('processImage failed: ' . $e->getMessage());
        } finally {
            unset($img, $highEncoded);
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

        return response()->json([
            'id'              => $file->id,
            'title'           => $file->title,
            'description'     => $file->description,
            'price'           => $file->price,
            'date_created'    => $file->date_created,
            'duration'        => $file->duration,
            'frame_rate'      => $file->frame_rate,
            'height'          => $file->height,
            'width'           => $file->width,
            'category_id'     => $file->category_id,
            'collection_id'   => $file->collection_id,
            'country'         => $file->country,
            'orientation'     => $file->orientation,
            'camera_movement' => $file->camera_movement,
            'license_type'    => $file->license_type,
            'subcategory_id'  => $file->subcategory_id,
            'keywords'        => $file->keywords,
            'content_filters' => $file->content_filters,

            // ── S3 full URL ──────────────────────────────
            'file_path'       => Storage::disk('s3')->url($file->file_path),
        ]);
    }
    public function saveFileMetadata(Request $request)
    {
        // dd($request->all());
        $file = BatchFile::findOrFail($request->file_id);

        $file->update([
            'category_id'    => $request->category_id,
            'title'          => $request->title,
            'description'    => $request->description,
            'date_created'   => $request->date_created,
            'keywords'       => $request->tags,
            'is_edited'      => '1',
            'price'          => $request->price,
            'country'        => $request->country,
            'subcategory_id' => $request->subcategory_id,
            'collection_id'  => $request->collection_id,

            // New filter fields
            'orientation'      => $request->orientation,
            'camera_movement'  => $request->camera_movement,
            'license_type'     => $request->license_type,

            // Checkboxes array — store as JSON (model $casts handles encoding automatically)
            // If no checkbox selected, store empty array []
            'content_filters'  => $request->input('content_filters', []),
        ]);

        return response()->json([
            'status'  => true,
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

    public function generateAiContent(Request $request)
    {
        $request->validate(['img_url' => 'required|url']);
        $geminiKey = 'AIzaSyAldQyhVM5jkdO_v7Wldv0qwyGkZvuBkJw';

        // This asks Google: "What models can I actually use?"
        $response = Http::get("https://generativelanguage.googleapis.com/v1beta/models?key={$geminiKey}");
        // $data = getModelList();
        // 1. USE YOUR ORIGINAL CLOUD KEY FOR VISION (The AIzaSyACDB... one)
        $visionKey = 'AIzaSyAldQyhVM5jkdO_v7Wldv0qwyGkZvuBkJw';

        // 2. USE YOUR AI STUDIO KEY FOR GEMINI (The AIzaSyB69Z... one from screenshot)

        // --- STEP 1: Get Vision Data ---
        $imageData = base64_encode(file_get_contents($request->img_url));
        $vResponse = Http::timeout(60) // Increase to 60 seconds
            ->withOptions([
                'curl' => [
                    CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4, // Force IPv4
                ],
            ])
            ->post("https://vision.googleapis.com/v1/images:annotate?key={$visionKey}", [
                'requests' => [
                    [
                        'image' => ['content' => $imageData],
                        'features' => [['type' => 'WEB_DETECTION'], ['type' => 'LABEL_DETECTION']]
                    ]
                ]
            ]);
        if ($vResponse->failed()) {
            return response()->json(['error' => 'Vision API Failed', 'details' => $vResponse->json()], 400);
        }

        $subject = data_get($vResponse->json(), 'responses.0.webDetection.bestGuessLabels.0.label', 'Atmospheric Scene');
        $labels = collect(data_get($vResponse->json(), 'responses.0.labelAnnotations', []))->pluck('description');

        // $response = Http::get("https://generativelanguage.googleapis.com/v1beta/models?key={$geminiKey}");

        // return $response->json();
        // --- STEP 2: Get Gemini Data (Proper Data Only) ---
        // We use v1beta and gemini-1.5-flash which is the standard for AI Studio
        // $geminiUrl = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key={$geminiKey}";


        $geminiUrl = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key={$geminiKey}";

        $gResponse = Http::timeout(60)
            ->retry(2, 100)
            ->post($geminiUrl, [
                'contents' => [[
                    'parts' => [
                        // ── Send actual image ─────────────────
                        [
                            'inline_data' => [
                                'mime_type' => 'image/jpeg',
                                'data'      => $imageData,
                            ]
                        ],
                        // ── Prompt ────────────────────────────
                        [
                            'text' => "Look at this image carefully and write a simple, clear, professional stock photo description.
                            1. title: A short, overall title (2-3 words max) that describes the WHOLE scene, not just one object. Like a newspaper headline for the image.
                            2. description: A simple, clear, professional stock photo description of exactly what is visible. 2-3 sentences, 50-60 words. No poetic language. Do NOT mention any watermark or logo.

                            Rules For Description:
                            - Describe ONLY what is actually visible in this image.
                            - Use simple, easy to understand words. No poetic or dramatic language.
                            - Mention the main subject, location, weather/sky, and mood.
                            - Length: 2-3 sentences max (around 50-60 words).
                            - Start directly. No intro like 'This image shows' or 'Here is'.
                            
                            
                            
                            Return ONLY raw JSON like:
                            {\"title\": \"...\", \"description\": \"...\"}
                            No markdown, no explanation, nothing else.
                            "


                        ]
                    ]
                ]],
                'generationConfig' => [
                    'temperature'     => 0.7, // ← lower = more factual, less creative
                    'maxOutputTokens' => 1500,
                    'topP'            => 0.95,
                    'topK'            => 40,
                ]
            ]);
        // dd($gResponse->json());
        // --- STEP 3: Handle the Result ---
        if ($gResponse->failed()) {
            // This will print the EXACT error from Google so we can stop guessing
            return response()->json([
                'error' => 'Gemini API still returning 404',
                'google_says' => $gResponse->json(),
                'url_attempted' => $geminiUrl
            ], 404);
        }

        // $aiDescription = data_get($gResponse->json(), 'candidates.0.content.parts.0.text');

        // return response()->json([
        //     'status' => true,
        //     'data' => [
        //         'title' => ucfirst($subject),
        //         'description' => trim($aiDescription),
        //         'tags' => $labels->take(10)->join(', ')
        //     ]
        // ]);

        $raw = data_get($gResponse->json(), 'candidates.0.content.parts.0.text', '');

        // ── Strip markdown fences if any ─────────────────────
        $clean = preg_replace('/```json|```/', '', $raw);
        $parsed = json_decode(trim($clean), true);

        return response()->json([
            'status' => true,
            'data'   => [
                'title'       => ucfirst($parsed['title']       ?? $subject),
                'description' => trim($parsed['description']    ?? $raw),
                'tags'        => $labels->take(10)->join(', '),
            ]
        ]);
    }
}
