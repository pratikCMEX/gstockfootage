<div class="body-wrapper-inner">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4"><a class="card-title fw-semibold mb-4"
                        href="{{ route('admin.image') }}">Image list</a>/Edit Image</h5>
                <div class="card">
                    <div class="card-body">
                        <form id="edit_image_form" method="POST"
                            action="{{ route('admin.image_update', encrypt($getImageDetail->id)) }}"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="category_id"
                                value="{{ encrypt($getImageDetail->category_id) }}" />
                            <div class="mb-3">
                                <label for="category" class="form-label">Category</label>
                                <select class="form-select mr-sm-2" name="category" id="category">
                                    @foreach ($category as $cat)
                                        <option value="{{ $cat->id }}"
                                            {{ $getImageDetail->category_id == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->category_name }}</option>
                                    @endforeach

                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">SubCategory</label>
                                <select class="form-select" name="subcategory" id="subcategory">
                                    {{-- <option value="">Choose SubCategory...</option> --}}

                                    @foreach ($subcategories as $sub)
                                        <option value="{{ $sub->id }}"
                                            {{ $getImageDetail->subcategory_id == $sub->id ? 'selected' : '' }}>
                                            {{ $sub->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="category" class="form-label">Collection</label>
                                <select class="form-select" name="collection" id="collection">
                                    @foreach ($collections as $coll)
                                        <option value="{{ $coll->id }}"
                                            {{ $getImageDetail->collection_id == $coll->id ? 'selected' : '' }}>
                                            {{ $coll->name }}
                                        </option>
                                    @endforeach
                                </select>

                            </div>
                            <div class="mb-3">
                                <label for="image_name" class="form-label">Image Name</label>
                                <input type="text" name="image_name" class="form-control" id="image_name"
                                    value="{{ $getImageDetail->image_name }}" aria-describedby="emailHelp"
                                    placeholder="Please enter image name">
                            </div>
                            <div class="mb-3">
                                <label for="image_price" class="form-label">Image Price</label>
                                <input type="text" name="image_price" class="form-control" id="image_price"
                                    aria-describedby="emailHelp" placeholder="Please enter image price"
                                    value="{{ $getImageDetail->image_price }}"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                            </div>
                            <div class="mb-3">
                                <label for="image_description" class="form-label">Image Description</label>
                                <textarea class="form-control" name="image_description" id="image_description"rows="3">{{ $getImageDetail->image_description }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="tags" class="form-label">Tags</label>
                                <input type="text" id="tags" name="tags" class="form-control"
                                    value="{{ $getImageDetail->tags }}" data-role="tagsinput" />
                            </div>
                            <div class="mb-3">
                                <label for="image" class="form-label">Upload Image</label>
                                <input class="form-control" type="file" name="image" id="image"
                                    onchange="loadFile(event)">


                                <div class="mt-2 row">
                                    <div class="col-sm-4">
                                        <img src="{{ asset('uploads/images/low/' . $getImageDetail->low_path) }}"
                                            id="preview_image" alt="" class="img-fluid rounded-4 mb-2 mb-sm-0">
                                    </div>
                                    {{-- <div class="col-sm-6">
                                                <img src="../assets/images/products/s4.jpg" alt="modernize-img"
                                                    class="img-fluid rounded-4">
                                            </div> --}}
                                </div>

                            </div>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
