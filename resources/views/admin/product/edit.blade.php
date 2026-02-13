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
                                    <input class="form-check-input" type="radio" name="type" value="0"
                                        {{ $product->type == '0' ? 'checked' : 'disabled' }}>
                                    <label class="form-check-label">Image</label>
                                </div>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="type" value="1"
                                        {{ $product->type == '1' ? 'checked' : 'disabled' }}>
                                    <label class="form-check-label">Video</label>
                                </div>
                            </div>

                            {{-- ================= CATEGORY ================= --}}
                            <div class="mb-3">
                                <label class="form-label">Category</label>
                                <select class="form-select" name="category" id="category">
                                    <option value="">Choose Category...</option>
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
                                <select class="form-select" name="subcategory" id="subcategory">
                                    <option value="">Choose SubCategory...</option>
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
                                <select class="form-select" name="collection">
                                    <option value="">Choose Collection...</option>
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
                                <label class="form-label">Product Name</label>
                                <input type="text" name="name" class="form-control" value="{{ $product->name }}">
                            </div>

                            {{-- ================= PRICE ================= --}}
                            <div class="mb-3">
                                <label class="form-label">Price</label>
                                <input type="text" name="price" class="form-control" value="{{ $product->price }}"
                                    oninput="this.value=this.value.replace(/[^0-9]/g,'');">
                            </div>

                            {{-- ================= TAGS ================= --}}
                            <div class="mb-3">
                                <label class="form-label">Tags</label>
                                <input type="text" name="tags" class="form-control" value="{{ $product->tags }}"
                                    data-role="tagsinput">
                            </div>

                            {{-- ================= DESCRIPTION ================= --}}
                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control" rows="3">{{ $product->description }}</textarea>
                            </div>

                            {{-- ================= CURRENT FILE PREVIEW ================= --}}
                            <div class="mb-4">
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

                            </div>

                            {{-- ================= REPLACE FILE ================= --}}
                            <div class="mb-3">
                                <label class="form-label">Replace File (Optional)</label>
                                <input class="form-control" type="file" name="file" id="fileInput">
                            </div>

                            <button type="submit" class="btn btn-primary">
                                Update Product
                            </button>

                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
