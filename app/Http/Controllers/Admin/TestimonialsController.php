<?php

namespace App\Http\Controllers\admin;

use App\DataTables\TestimonialsDataTable;
use App\Http\Controllers\Controller;
use App\Models\Testimonials;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TestimonialsController extends Controller
{
    public function index(TestimonialsDataTable $DataTable)
    {
        $title = 'Testimonials';
        $page = 'admin.testimonials.list';
        $js = ['testimonials'];
        return $DataTable->render('layouts.admin.layout', compact('title', 'page', 'js'));
    }
    public function add()
    {
        $title = 'Add Testimonials';
        $page = 'admin.testimonials.add';
        $js = ['testimonials'];

        return view("layouts.admin.layout", compact(
            'title',
            'page',
            'js'
        ));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'message' => 'required',
                'designation' => 'nullable|string|max:255',
                'image' => 'nullable|file|mimes:jpg,jpeg,png,webp'
            ]);
            DB::beginTransaction();
            $imageName = null;

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . Str::slug($request->name) . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/images/testimonials'), $imageName);
            }

            Testimonials::create([
                'name' => $request->name,
                'designation' => $request->designation ?? '',
                'message' => $request->message ?? '',
                'profile_image' => $imageName,
            ]);
            DB::commit();
            return redirect()->route('admin.testimonials')->with('msg_success', 'Testimonial Add successfully !');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->route('admin.testimonials_add')->with('msg_error', 'Testimonial not added' . $e->getMessage());
        }
    }
    public function edit(string $id)
    {
        $testimonial_id = decrypt($id);

        $title = 'Edit Testimonials';
        $page = 'admin.testimonials.edit';
        $js = ['testimonials'];

        $testimonialId = $id;
        $getTestimonialDetail = Testimonials::where('id', $testimonial_id)->first();

        return view('layouts.admin.layout', compact('title', 'page', 'js', 'getTestimonialDetail', 'testimonialId'));
    }
    public function update(Request $request)
    {

        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'message' => 'required',
                'designation' => 'nullable|string|max:255',
                'image' => 'nullable|file|mimes:jpg,jpeg,png,webp'
            ]);
            DB::beginTransaction();
            $testimonial_id = decrypt($request->id);
            
            $getData = Testimonials::where('id', $testimonial_id)->first();
            if ($request->hasFile('image')) {

                $oldPath = public_path('uploads/images/testimonials/' . $getData->image);

                if (!empty($getData->image) && file_exists($oldPath)) {
                    @unlink($oldPath);
                }

                $image = $request->file('image');
                $imageName = time() . '_' . Str::slug($request->name) . '.' . $image->getClientOriginalExtension();

                $image->move(public_path('uploads/images/testimonials'), $imageName);

                $getData->profile_image = $imageName;
            }
            $getData->name = $request->name;
            $getData->designation = $request->designation;
            $getData->message = $request->message;
            // $getData->image = $request->sub_category_name;
            $getData->save();
            DB::commit();
            return redirect()->route('admin.testimonials')->with('msg_success', 'Testimonial Updated successfully !');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->route('admin.testimonials_edit', encrypt($testimonial_id))->with('msg_error', 'Testimonial not updated' . $e->getMessage());
        }
    }

      public function delete(Request $request)
    {
        try {
            DB::beginTransaction();
            $id = decrypt($request->id);
            $testimonials = Testimonials::findOrFail($id);

           

           
                $imagePath = public_path('uploads/images/testimonials/' . $testimonials->profile_image);

                if (!empty($testimonials->profile_image) && file_exists($imagePath)) {
                    @unlink($imagePath);
                }

                $testimonials->delete();
                DB::commit();

                return response()->json([
                    'success' => true,
                    'message' => 'Testimonial deleted successfully'
                ]);
          
        } catch (QueryException $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Testimonial not deleted'
            ]);
        }
    }

}
