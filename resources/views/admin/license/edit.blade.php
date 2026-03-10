<div class="body-wrapper-inner">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4"><a class="card-title fw-semibold mb-4"
                        href="{{ route('admin.license') }}">License list</a>/Edit License</h5>

                <div class="card">
                    <div class="card-body">
                        <form id="license_form" method="POST" action="{{ route('admin.license_update') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <input type="hidden" name="license_id" id="license_id"
                                    value="{{ encrypt($getLicenseDetail->id) }}">
                                <label for="exampleInputEmail1" class="form-label">License Name</label>
                                <input type="text" name="name" class="form-control" id="name"
                                    value="{{ $getLicenseDetail->name }}" aria-describedby="emailHelp"
                                    placeholder="Please enter license name">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Title</label>
                                <input type="text" name="title" class="form-control" id="title"
                                    value="{{ $getLicenseDetail->title }}" aria-describedby="emailHelp"
                                    placeholder="Please enter title">
                            </div>
                            <div class="mb-3">
                                <label for="product_quality" class="form-label">Product Quantity</label>
                                <select class="form-select mr-sm-2" name="product_quality_id" id="product_quality_id">
                                    <option value="">Choose Product Quality...</option>
                                    @foreach ($qualities as $quality)
                                        <option value="{{ $quality->id }}" {{ $getLicenseDetail->product_quality_id == $quality->id ? 'selected' : '' }}>
                                            {{ $quality->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Quality</label>
                                <input type="text" name="quality" class="form-control" id="quality"
                                    value="{{ $getLicenseDetail->quality }}" aria-describedby="emailHelp"
                                    placeholder="Please enter quality">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Price</label>
                                <input type="text" name="price" class="form-control" id="price"
                                    value="{{ $getLicenseDetail->price }}" aria-describedby="emailHelp"
                                    placeholder="Please enter price"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '');">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Plan Price</label>
                                <input type="text" name="plan_price" class="form-control" id="plan_price"
                                    aria-describedby="emailHelp" value="{{ $getLicenseDetail->plan_price }}"
                                    placeholder="Please enter Plan price"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '');">
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <div id="description-container">
                                    @php
                                        $descriptions = !empty($getLicenseDetail->description) ? explode(',', $getLicenseDetail->description) : [];
                                        if (empty($descriptions)) {
                                            $descriptions = [''];
                                        }
                                    @endphp
                                    @foreach ($descriptions as $index => $desc)
                                        <div class="description-item mb-2">
                                            <div class="d-flex">
                                                <input type="text" name="description[]" class="form-control" 
                                                    value="{{ trim($desc) }}" placeholder="Enter description point">
                                                @if ($index == 0)
                                                    <button type="button" class="btn btn-lg btn-secondary ms-2" id="add-description-btn" style="width: 120px;">
                                                        <i class="fas fa-plus"></i> Add More
                                                    </button>
                                                @else
                                                    <button type="button" class="btn btn-lg btn-danger ms-2" onclick="removeDescriptionField(this)" style="width: 120px;">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                @endif
                                            </div>
                                              <span id="description[]-error" class="text-danger"></span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <button type="submit" class="btn btn-orange">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>