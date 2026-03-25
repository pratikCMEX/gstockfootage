<div class="body-wrapper-inner">
    <div class="container-fluid">

        <div class="card">
            <div class="card-body">

                <h5 class="card-title fw-semibold mb-4">
                    <a href="{{ route('admin.product') }}">Product List</a> / Edit Product
                </h5>

                <div class="card">
                    <div class="card-body">

                        <form method="POST" id="edit_product_form" action="{{ route('admin.product_update', $id) }}"
                            enctype="multipart/form-data">

                            @csrf
                            {{-- ================= PRODUCT TYPE ================= --}}
                            <div class="mb-4">
                                <label class="form-label fw-bold">Product Type</label><br>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="type" value="image"
                                        {{ $product->type == 'image' ? 'checked' : 'disabled' }}>
                                    <label class="form-check-label">Image</label>
                                </div>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="type" value="video"
                                        {{ $product->type == 'video' ? 'checked' : 'disabled' }}>
                                    <label class="form-check-label">Video</label>
                                </div>
                            </div>

                            {{-- ================= CATEGORY ================= --}}
                            <div class="mb-3">
                                <label class="form-label">Category</label><label class="text-danger">*</label>
                                <select class="form-select searchable" name="category" id="category">
                                    <option value="" selected disabled>Choose Category...</option>
                                    @foreach ($categories as $cat)
                                        <option value="{{ $cat->id }}"
                                            {{ $product->category_id == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->category_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>


                            {{-- ================= SUBCATEGORY ================= --}}
                            <div class="mb-3">
                                <label class="form-label">SubCategory</label>
                                <select class="form-select searchable" name="subcategory" id="subcategory">
                                    <option value="" selected disabled>Choose SubCategory...</option>
                                    @foreach ($subcategories as $sub)
                                        <option value="{{ $sub->id }}"
                                            {{ $product->subcategory_id == $sub->id ? 'selected' : '' }}>
                                            {{ $sub->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- ================= COLLECTION ================= --}}
                            <div class="mb-3">
                                <label class="form-label">Collection</label>
                                <select class="form-select searchable" name="collection">
                                    <option value="" selected disabled>Choose Collection...</option>
                                    @foreach ($collections as $coll)
                                        <option value="{{ $coll->id }}"
                                            {{ $product->collection_id == $coll->id ? 'selected' : '' }}>
                                            {{ $coll->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- ================= NAME ================= --}}
                            <div class="mb-3">
                                <label class="form-label">Product Name</label><label class="text-danger">*</label>
                                <input type="text" name="name" class="form-control" placeholder="Enter product name"
                                    value="{{ $product->title }}">
                            </div>

                            {{-- ================= PRICE ================= --}}
                            <div class="mb-3">
                                <label class="form-label">Price ($) </label><label class="text-danger">*</label>
                                <input type="text" name="price" class="form-control" value="{{ $product->price }}"  placeholder="Enter product price"
                                    oninput="this.value=this.value.replace(/[^0-9]/g,'');">
                            </div>

                            {{-- ================= TAGS ================= --}}
                            <div class="mb-3">
                                <label class="form-label">Tags</label>
                                <input type="text" name="tags" class="form-control"  placeholder="Enter product tags"
                                    value="{{ $product->keywords }}" data-role="tagsinput">
                            </div>

                            {{-- ================= DESCRIPTION ================= --}}
                            <div class="mb-3">
                                <label class="form-label">Description</label><label class="text-danger">*</label>
                                <textarea name="description" class="form-control" rows="3"  placeholder="Enter product description">{{ $product->description }}</textarea>
                            </div>

                            {{-- ================= CURRENT FILE PREVIEW ================= --}}
                            {{-- <div class="mb-4">
                                <label class="form-label fw-bold">Current File</label><br>

                                @if ($product->type == '0')
                                    <img src="{{ asset('uploads/images/low/' . $product->low_path) }}"
                                        class="img-fluid rounded shadow" style="max-height:200px;">
                                @else
                                    <video width="300" controls class="rounded shadow">
                                        <source src="{{ asset('uploads/videos/low/' . $product->low_path) }}"
                                            type="video/mp4">
                                    </video>
                                @endif

                            </div> --}}

                            {{-- ================= REPLACE FILE ================= --}}
                            @if ($product->type == 'image')
                                <div class="mb-3 image_upload">
                                    <label class="form-label">Upload File</label><label class="text-danger">*</label>
                                    <input class="form-control" type="file" name="file" id="fileInput"
                                        accept="image/*" onchange="loadFile(event)">
                                    <div class="mt-2 row">
                                        <div class="col-sm-4">
                                            <img src="{{ Storage::disk('s3')->url($product->low_path) }}"
                                                id="preview_image" alt=""
                                                class="img-fluid rounded-4 mb-2 mb-sm-0">
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="mb-3 video_upload">
                                    <label class="form-label">Upload File</label><label class="text-danger">*</label>
                                    <input class="form-control" type="file" name="file" id="video"
                                        accept="video/mp4,video/x-m4v,video/*" onchange="previewVideo(event)">

                                    <div class="mt-2 row">
                                        <div class="col-sm-4">
                                            <video id="preview_video" width="100%" height="auto" controls
                                                class="rounded-4 mb-2 mb-sm-0">
                                                <source src="{{ Storage::disk('s3')->url($product->low_path) }}"
                                                    type="video/mp4">
                                                Your browser does not support the video tag.
                                            </video>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <button type="submit" class="btn btn-orange mt-4">Update Product</button>
                            <a href="{{ route('admin.product') }}" class="btn btn-orange mt-4">Cancel</a>

                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
