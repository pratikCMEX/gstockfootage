<div class="body-wrapper-inner">
    <div class="container-fluid">

        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4">
                    <a href="{{ route('admin.product') }}" style="color: var(--primary);">Product List</a> / Add Product
                </h5>

                <div class="card">
                    <div class="card-body">

                        <form method="POST" id="add_product_form" action="{{ route('admin.product_store') }}"
                            enctype="multipart/form-data">
                            @csrf

                            {{-- ================= PRODUCT TYPE ================= --}}
                            <div class="mb-4">
                                <label class="form-label fw-bold">Product Type</label><br>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="type" value="image" checked
                                        onchange="changeType('image')">
                                    <label class="form-check-label">Image</label>
                                </div>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="type" value="video"
                                        onchange="changeType('video')">
                                    <label class="form-check-label">Video</label>
                                </div>
                            </div>

                            {{-- ================= CATEGORY ================= --}}
                            <div class="mb-3">
                                <label class="form-label">Category</label>
                                <select class="form-select" name="category" id="category">
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
                                <label class="form-label">Collection</label>
                                <select class="form-select" name="collection" id="collection">
                                    <option value="">Choose Collection...</option>
                                    @foreach ($collections as $coll)
                                    <option value="{{ $coll->id }}">{{ $coll->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- ================= NAME ================= --}}
                            <div class="mb-3">
                                <label class="form-label">Product Name</label>
                                <input type="text" name="name" class="form-control"
                                    placeholder="Enter product name">
                            </div>

                            {{-- ================= PRICE ================= --}}
                            <div class="mb-3">
                                <label class="form-label">Price</label>
                                <input type="text" name="price" class="form-control"
                                    oninput="this.value=this.value.replace(/[^0-9]/g,'');">
                            </div>

                            {{-- ================= TAGS ================= --}}
                            <div class="mb-3">
                                <label class="form-label">Tags</label>
                                <input type="text" name="tags" class="form-control" data-role="tagsinput">
                            </div>

                            {{-- ================= DESCRIPTION ================= --}}
                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control" rows="3"></textarea>
                            </div>

                            {{-- ================= FILE INPUT ================= --}}
                            <div class="mb-3">
                                <label class="form-label">Upload File</label>
                                <input class="form-control" type="file" name="file" id="fileInput">
                            </div>

                            <div class="mt-2">
                                <img id="preview_image" class="img-fluid rounded"
                                    style="max-height:200px;display:none;">
                                <video id="preview_video" width="300" controls style="display:none;"></video>
                            </div>

                            <button type="submit" class="btn btn-orange">Save Product</button>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>