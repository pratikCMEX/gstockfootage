<div class="body-wrapper-inner">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4"><a class="card-title fw-semibold mb-4"
                        href="{{ route('admin.license') }}">License list</a>/Add License</h5>

                <div class="card">
                    <div class="card-body">
                        <form id="license_form" method="POST" action="{{ route('admin.store_license') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">License Name</label>
                                <input type="text" name="name" class="form-control" id="name"
                                    aria-describedby="emailHelp" placeholder="Please enter license name">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Title</label>
                                <input type="text" name="title" class="form-control" id="title"
                                    aria-describedby="emailHelp" placeholder="Please enter title">
                            </div>
                            <div class="mb-3">
                                <label for="product_quality" class="form-label">Product Quantity</label>
                                <select class="form-select mr-sm-2" name="product_quality_id" id="product_quality_id">
                                    <option value="">Choose Product Quality...</option>
                                    @foreach ($qualities as $quality)
                                        <option value="{{ $quality->id }}">{{ $quality->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Quality</label>
                                <input type="text" name="quality" class="form-control" id="quality"
                                    aria-describedby="emailHelp" placeholder="Please enter quality">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Price</label>
                                <input type="text" name="price" class="form-control" id="price"
                                    aria-describedby="emailHelp" placeholder="Please enter price"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '');">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Plan Price</label>
                                <input type="text" name="plan_price" class="form-control" id="plan_price"
                                    aria-describedby="emailHelp" placeholder="Please enter Plan price"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '');">
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <div id="description-container">
                                    <div class="description-item mb-2">
                                        <div class="d-flex">
                                            <input type="text" name="description[]"
                                                class="form-control  description-field "
                                                placeholder="Enter description point">
                                            <button type="button" class="btn btn-sm btn-secondary ms-2" id="add"
                                                style="width: 120px;">
                                                <i class="fas fa-plus"></i> Add More
                                            </button>
                                        </div>
                                        <span for="name" class="help-inline customeMessage text-danger"></span>

                                    </div>

                                </div>

                            </div>

                            <div id="addHtml"></div>
                            <button type="submit" class="btn btn-orange">Add</button>
                        </form>

                        <div class="newRow" style="display: none;">
                            <div class="newhtml row align-items-center">
                                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-6 mb-3">
                                    <div class="form-group ">
                                        <label class="control-label">Description
                                            <span class="required"> * </span>
                                        </label>
                                        <input type="text" class="form-control description-field" name="description[]"
                                            value="" placeholder="Enter description " />
                                        {{-- <input type="hidden" class="form-control edit_id" name="edit_id"
                                            value="" /> --}}

                                    </div>
                                </div>
                                <div class="col-xl-8 col-lg-8 col-md-6 col-sm-6 mb-3 button_group">
                                    <button type="button" class="remove btn btn-danger">Close</button>
                                </div>
                                <span for="name" class="help-inline customeMessage text-danger"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>