<div class="body-wrapper-inner">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4"><a class="card-title fw-semibold mb-4"
                        href="{{ route('admin.sub_category') }}">Subcategories</a> / Edit SubCategory</h5>
                <div class="card">
                    <div class="card-body">
                        <form id="edit_sub_category_form" method="POST"
                            action="{{ route('admin.sub_category_update') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label for="category" class="form-label">Category</label><label class="text-danger">*</label>
                                <select class="form-select mr-sm-2 searchable" name="category" id="category">
                                      <option value="">Choose Category...</option>
                                    @foreach ($category as $cat)
                                        <option value="{{ $cat->id }}"
                                            {{ $getSubCategoryDetail->category_id == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->category_name }}</option>
                                    @endforeach

                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="category_name" class="form-label">Subcategory Name</label><label class="text-danger">*</label>
                                <input type="hidden" name="subcategory_id" id="subcategory_id"
                                    value="{{ encrypt($getSubCategoryDetail->id) }}" />
                                <input type="text" name="name" class="form-control" id="name"
                                    placeholder="enter subcategory name"
                                    value="{{ $getSubCategoryDetail->name }}">
                            </div>
                            <!-- <div class="mb-3">
                                <label for="category_name" class="form-label">SubCategory Name</label><label class="text-danger">*</label>
                                <input type="hidden" name="subcategory_id" id="subcategory_id"
                                    value="{{ encrypt($getSubCategoryDetail->id) }}" />
                                <input type="text" name="name" class="form-control" id="name"
                                    placeholder="enter subcategory name"
                                    value="{{ $getSubCategoryDetail->name }}">
                            </div> -->
                            <div class="mb-3">
                                <label for="image" class="form-label">Upload Image</label><label class="text-danger">*</label>
                                <input class="form-control" type="file" name="image" id="image"
                                    onchange="loadFile(event)">


                                <div class="mt-2 row">
                                    <div class="col-sm-4">
                                        <img src="{{ asset('uploads/images/sub_category/' . $getSubCategoryDetail->image) }}"
                                            id="preview_image" alt="" class="img-fluid rounded-4 mb-2 mb-sm-0">
                                    </div>
                                    {{-- <div class="col-sm-6">
                                                <img src="../assets/images/products/s4.jpg" alt="modernize-img"
                                                    class="img-fluid rounded-4">
                                            </div> --}}
                                </div>

                            </div>
                            <button type="submit" class="btn btn-orange">Edit Subcategory</button>
                            <a href="{{ route('admin.sub_category') }}" class="btn btn-orange">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
