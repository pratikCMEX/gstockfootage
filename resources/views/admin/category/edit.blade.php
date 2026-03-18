{{-- {{ dd($getCategoryDetail) }} --}}
<div class="body-wrapper-inner">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4"><a class="card-title fw-semibold mb-4"
                        href="{{ route('admin.category') }}">Category list</a>/Edit Category</h5>
                <div class="card">
                    <div class="card-body">
                        <form id="edit_category_form" method="POST"
                            action="{{ route('admin.category_update') }}"enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="category_name" class="form-label">Category Name</label><label for="" class="text-danger">*</label>
                                <input type="hidden" name="category_id" id="category_id"
                                    value="{{ encrypt($getCategoryDetail->id) }}" />
                                <input type="text" name="category_name" class="form-control" id="category_name"
                                    placeholder="Please enter category name"
                                    value="{{ $getCategoryDetail->category_name }}">
                            </div>
                            <div class="mb-3">
                                <label for="image" class="form-label">Upload Image</label><label for="" class="text-danger">*</label>
                                <input class="form-control" type="file" name="image" id="image"
                                    onchange="loadFile(event)">


                                <div class="mt-2 row">
                                    <div class="col-sm-4">
                                        <img src="{{ asset('uploads/images/category/' . $getCategoryDetail->category_image) }}"
                                            id="preview_image" alt="" class="img-fluid rounded-4 mb-2 mb-sm-0">
                                    </div>
                                    {{-- <div class="col-sm-6">
                                                <img src="../assets/images/products/s4.jpg" alt="modernize-img"
                                                    class="img-fluid rounded-4">
                                            </div> --}}
                                </div>

                            </div>
                            <button type="submit" class="btn btn-orange">Save</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
