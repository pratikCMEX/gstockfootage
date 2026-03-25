<div class="body-wrapper-inner">
    <div class="container-fluid">
        <div class="row">
            <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                <div class="mb-3 mb-sm-0">
                    <h5 class="card-title fw-semibold">{{ $title }}</h5>
                </div>
                <div>
                    <a href="{{ route('admin.affiliates.create') }}" class="btn btn-orange">+ Add Affiliate </a>
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
