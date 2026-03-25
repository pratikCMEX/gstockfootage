<div class="body-wrapper-inner">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4"><a class="card-title fw-semibold mb-4"
                        href="{{ route('admin.sub_category') }}">SubCategory list</a> / Add SubCategory</h5>

                <div class="card">
                    <div class="card-body">
                        <form id="add_sub_category_form" method="POST" action="{{ route('admin.sub_category_store') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="category" class="form-label">Category</label><label class="text-danger">*</label>
                                <select class="form-select searchable mr-sm-2" name="category" id="category">
                                    <option value="">Choose Category...</option>
                                    @foreach ($category as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->category_name }}</option>
                                    @endforeach
                                </select>
                            </div>  
                          
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Subcategory Name</label><label class="text-danger">*</label>
                                <input type="text" name="name" class="form-control" id="exampleInputEmail1"
                                    aria-describedby="emailHelp" placeholder="Please enter subcategory name">
                            </div>
                            <div class="mb-3">
                                <label for="image" class="form-label">Upload Image</label><label class="text-danger">*</label>
                                <input class="form-control" type="file" name="image" id="image"  accept="image/*" 
                                    onchange="loadFile(event)">


                                <div class="mt-2 row">
                                    <div class="col-sm-4">
                                        <img src="" id="preview_image" alt=""
                                            class="img-fluid rounded-4 mb-2 mb-sm-0">
                                    </div>

                                </div>

                            </div>
                            <button type="submit" class="btn btn-orange">Add Subcategory</button>
                            <a href="{{ route('admin.sub_category') }}" class="btn btn-orange">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
