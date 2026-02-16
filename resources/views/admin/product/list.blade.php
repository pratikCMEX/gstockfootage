<div class="body-wrapper-inner">
    <div class="container-fluid">
        <div class="row">
            <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                <div class="mb-3 mb-sm-0">
                    <h5 class="card-title fw-semibold">Product List</h5>
                </div>
                 <div class="d-flex align-items-center gap-2">
                    <div>

                        <select class="form-select mr-sm-2" name="category" id="category">
                            <option value="">All Category</option>
                            @foreach ($category as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->category_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>

                        <select class="form-select mr-sm-2" name="subcategory" id="subcategory">
                            <option value="">All Subcategory</option>
                            @foreach ($subcategory as $sub)
                                <option value="{{ $sub->id }}">{{ $sub->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>

                        <select class="form-select mr-sm-2" name="collections" id="collections">
                            <option value="">All Collections</option>
                            @foreach ($collections as $collection)
                                <option value="{{ $collection->id }}">{{ $collection->name }}</option>
                            @endforeach
                        </select>
                    </div>
                      <div>

                        <select class="form-select mr-sm-2" name="type" id="type">
                            <option value="">All Type</option>
                           
                                <option value="0">Images</option>
                                <option value="1">Videos</option>
                           
                        </select>
                    </div>
                <div>
                    <a href="{{ route('admin.product_add') }}" class="btn btn-primary">Add Product +</a>
                </div>
                </div>
            </div>
            <div class="col-lg-12 d-flex align-items-stretch">

                <div class="card w-100">
                    <div class="card-body">
                        <div class="table-responsive">
                            <button id="delete-selected" class="btn btn-danger mb-3" style="display:none;">
                                Delete Selected
                            </button>
                            {{ $dataTable->table() }}
                        </div>
                        {{ $dataTable->scripts(attributes: ['type' => 'module']) }}

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="imagePreviewModal" tabindex="-1" aria-labelledby="imagePreviewLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imagePreviewLabel">Image Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="previewImage" class="img-fluid rounded" />
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="videoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="videoModalLabel">Video Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <video id="modalVideo" width="100%" height="auto" controls controlsList="nodownload">
                    <source src="" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
        </div>
    </div>
</div>
