<div class="body-wrapper-inner">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4"><a class="card-title fw-semibold mb-4"
                        href="{{ route('admin.image') }}">Image list</a>/Add Image</h5>
                <div class="card">
                    <div class="card-body">
                        <form id="add_image_form" method="POST" action="{{ route('admin.image_store') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="category" class="form-label">Category</label>
                                <select class="form-select mr-sm-2" name="category" id="category">
                                    <option value="">Choose Category...</option>
                                    @foreach ($category as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->category_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">SubCategory</label>
                                <select class="form-select" name="subcategory" id="subcategory">
                                    <option value="">Choose SubCategory...</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="category" class="form-label">Collection</label>
                                <select class="form-select mr-sm-2" name="collection" id="collection">
                                    <option value="">Choose Collection...</option>
                                    @foreach ($collections as $coll)
                                        <option value="{{ $coll->id }}">{{ $coll->name }}</option>
                                    @endforeach

                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="image_name" class="form-label">Image Name</label>
                                <input type="text" name="image_name" class="form-control" id="image_name"
                                    aria-describedby="emailHelp" placeholder="enter image name">
                            </div>
                            <div class="mb-3">
                                <label for="image_price" class="form-label">Image Price</label>
                                <input type="text" name="image_price" class="form-control" id="image_price"
                                    aria-describedby="emailHelp" placeholder="enter image price"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                            </div>
                            <div class="mb-3">
                                <label for="tags" class="form-label">Tags</label>
                                <input type="text" id="tags" name="tags" class="form-control" data-role="tagsinput" />
                            </div>
                            <div class="mb-3">
                                <label for="image_description" class="form-label">Image Description</label>
                                <textarea class="form-control" name="image_description" id="image_description"
                                    rows="3"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="image" class="form-label">Upload Image</label>
                                <input class="form-control" type="file" name="image" id="image" accept="image/*"
                                    onchange="loadFile(event)">


                                <div class="mt-2 row">
                                    <div class="col-sm-4">
                                        <img src="" id="preview_image" alt="" class="img-fluid rounded-4 mb-2 mb-sm-0">
                                    </div>
                                    {{-- <div class="col-sm-6">
                                        <img src="../assets/images/products/s4.jpg" alt="modernize-img"
                                            class="img-fluid rounded-4">
                                    </div> --}}
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