<div class="body-wrapper-inner">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4"><a class="card-title fw-semibold mb-4"
                        href="{{ route('admin.testimonials') }}">Testimonials</a> / Edit Testimonial</h5>
                <div class="card">
                    <div class="card-body">
                        <form id="edit_testimonials_form" method="POST"
                            action="{{ route('admin.testimonials_update') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="col-sm-6 col-12 mb-3">
                                    <label for="name" class="form-label"> Name</label><label
                                        class="text-danger">*</label>
                                    <input type="hidden" name="id" id="id"
                                        value="{{ encrypt($getTestimonialDetail->id) }}" />
                                    <input type="text" name="name" class="form-control" id="name"
                                        placeholder="Please enter  name" value="{{ $getTestimonialDetail->name }}">
                                </div>
                                <div class="col-sm-6 col-12 mb-3">
                                    <label for="designation" class="form-label">Designation</label>

                                    <input type="text" name="designation" class="form-control" id="designation"
                                        placeholder="Please enter Designation"
                                        value="{{ $getTestimonialDetail->designation }}">
                                </div>
                                <div class="col-sm-6 col-12 mb-3">
                                    <label for="category_name" class="form-label">Message</label><label
                                        class="text-danger">*</label>

                                    <input type="text" name="message" class="form-control" id="message"
                                        placeholder="Please enter message" value="{{ $getTestimonialDetail->message }}">
                                </div>
                                <div class="col-sm-6 col-12 mb-3">
                                    <label for="image" class="form-label">Upload Image</label>
                                    <input class="form-control" type="file" name="image" id="image"
                                        accept="image/*" onchange="loadFile(event)">


                                    <div class="mt-2 row">
                                        <div class="col-sm-4">
                                            <img src="{{ asset('uploads/images/testimonials/' . $getTestimonialDetail->profile_image) }}"
                                                id="preview_image" alt=""
                                                class="img-fluid rounded-4 mb-2 mb-sm-0">
                                        </div>
                                        {{-- <div class="col-sm-6">
                                                <img src="../assets/images/products/s4.jpg" alt="modernize-img"
                                                    class="img-fluid rounded-4">
                                            </div> --}}
                                    </div>

                                </div>
                            </div>
                            <button type="submit" class="btn btn-orange">Edit Testimonial</button>
                            <a href="{{ route('admin.testimonials') }}" class="btn btn-orange">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
