<div class="body-wrapper-inner">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4">
                    <a class="card-title fw-semibold mb-4" href="javascript::void(0);">
                        {{ $about_us ? 'Edit About Us' : 'Add About Us' }}
                    </a>
                </h5>
                <div class="card">
                    <div class="card-body">
                        <form id="about_us_form" method="POST" enctype="multipart/form-data" action="{{ route('admin.about_us_save') }}">
                            @csrf
                            <input id="id" name="id" value="{{ isset($about_us->id) ? $about_us->id : '' }}" hidden />
                            <div class="mb-3">
                                <label for="title" class="form-label">Title</label>
                                <span class="text-danger">*</span>
                                <input type="text" name="title" class="form-control" id="title"
                                    value="{{ isset($about_us->title) ? $about_us->title : '' }}"
                                    placeholder="Please enter title">
                            </div>
                            <div class="mb-3">
                                <label for="sub_title" class="form-label">Sub Title</label>
                                <input type="text" name="sub_title" class="form-control" id="sub_title"
                                    value="{{ isset($about_us->sub_title) ? $about_us->sub_title : '' }}"
                                    placeholder="Please enter sub title">
                            </div>
                            <div class="mb-3">
                                <label for="heading" class="form-label">Heading</label><label
                                    class="text-danger">*</label>
                                <input type="text" name="heading" class="form-control" id="heading"
                                    value="{{ isset($about_us->heading) ? $about_us->heading : '' }}"
                                    placeholder="Please enter heading">
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label><label></label><label class="text-danger">*</label>
                                <textarea class="form-control ckeditor" name="description" id="description" rows="6"
                                    placeholder="Please enter description">{{ isset($about_us->description) ? $about_us->description : '' }}</textarea>
                            </div>
                           <label id="description-error" class="text-danger" for="description"></label>
                            <div class="mb-3">
                                <label for="image" class="form-label">Image</label><label class="text-danger">*</label>
                                <input type="file" name="image" class="form-control" id="image" accept="image/*">
                                @if(isset($about_us->image))
                                    <div class="mt-2">
                                        <p class="small text-muted mb-2">Current Image:</p>
                                        <img src="{{ asset('uploads/images/about_us/' . $about_us->image) }}"
                                             style="max-width: 200px; border-radius: 5px; border: 1px solid #ddd;" 
                                             alt="About Us Image">
                                    </div>
                                @endif
                            </div>
                            <button type="submit" class="btn btn-orange">{{ $about_us ? 'Update' : 'Add' }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>





