<div class="body-wrapper-inner">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4"><a class="card-title fw-semibold mb-4"
                        href="{{ route('admin.testimonials') }}">Testimonial list</a>/Add Testimonials</h5>

                <div class="card">
                    <div class="card-body">
                        <form id="add_testimonials_form" method="POST" action="{{ route('admin.testimonials_store') }}"
                            enctype="multipart/form-data">
                            @csrf
                            
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Name</label><label class="text-danger">*</label>
                                <input type="text" name="name" class="form-control" id="exampleInputEmail1"
                                    aria-describedby="emailHelp" placeholder="Please enter  name">
                            </div>
                             <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Designation</label>
                                <input type="text" name="designation" class="form-control" id="exampleInputEmail1"
                                    aria-describedby="emailHelp" placeholder="Please enter Designation ">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Message</label><label class="text-danger">*</label>
                                <input type="text" name="message" class="form-control" id="exampleInputEmail1"
                                    aria-describedby="emailHelp" placeholder="Please enter Message">
                            </div>
                            <div class="mb-3">
                                <label for="image" class="form-label">Upload User Image</label>
                                <input class="form-control" type="file" name="image" id="image"  accept="image/*" 
                                    onchange="loadFile(event)">


                                <div class="mt-2 row">
                                    <div class="col-sm-4">
                                        <img src="" id="preview_image" alt=""
                                            class="img-fluid rounded-4 mb-2 mb-sm-0">
                                    </div>

                                </div>

                            </div>
                            <button type="submit" class="btn btn-orange">Add</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
