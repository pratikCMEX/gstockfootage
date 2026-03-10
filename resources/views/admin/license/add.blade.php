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
                                            <input type="text" name="description[]" class="form-control" 
                                                placeholder="Enter description point">
                                            <button type="button" class="btn btn-sm btn-secondary ms-2" id="add-description-btn" style="width: 120px;">
                                                <i class="fas fa-plus"></i> Add More
                                            </button>
                                        </div>
                                      
                                    </div>
                                  
                                </div>
                                    
                            </div>
                          <span id="description[]-error" class="text-danger"></span>

                            <button type="submit" class="btn btn-orange">Add</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>