<div class="body-wrapper-inner">
    <div class="container-fluid">
        <div class="row">
            <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                <div class="mb-3 mb-sm-0">
                    <h5 class="card-title fw-semibold">Contact Us List</h5>
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
    <div class="modal fade" id="viewMessageModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">

            <!-- HEADER -->
            <div class="modal-header border-0">
                <h4 class="modal-title fw-bold">Message Details</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- BODY (SCROLLABLE) -->
            <div class="modal-body ">

                <!-- Name -->
                <div class="row mb-3">
                    <div class="col-4 fw-semibold text-muted">Name</div>
                    <div class="col-8" id="modalName"></div>
                </div>

                <!-- Email -->
                <div class="row mb-3">
                    <div class="col-4 fw-semibold text-muted">Email</div>
                    <div class="col-8" id="modalEmail"></div>
                </div>

                <!-- Subject -->
                <div class="row mb-3">
                    <div class="col-4 fw-semibold text-muted">Subject</div>
                    <div class="col-8" id="modalSubject"></div>
                </div>

                <hr>

                <!-- Message -->
                <div class="mb-2 fw-semibold text-muted">Message</div>
                <div id="modalMessage" class="p-3 border rounded bg-light custom-scroll"
                    style="white-space: pre-wrap;">
                </div>

            </div>

            <!-- FOOTER -->
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-orange px-4" data-bs-dismiss="modal">
                    Cancel
                </button>
            </div>

        </div>
    </div>
</div>

</div>