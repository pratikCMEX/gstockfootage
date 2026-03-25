<div class="body-wrapper-inner">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="card-title fw-semibold mb-4"><a class="card-title fw-semibold mb-4"
                                    href="{{ route('admin.affiliates.list') }}">Affiliate Users</a> / Add Affiliate User
                            </h5>

                            <!-- <a href="{{ route('admin.affiliates.list') }}" class="btn btn-secondary btn-sm">
                                <i class="fa fa-arrow-left me-1"></i> Back
                            </a> -->
                        </div>

                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <form action="{{ route('admin.affiliates.store') }}" method="POST" id="affiliate_form">
                            @csrf

                            <div class="affiliate-form-flex">
                                <div class="mb-3 w-100">
                                    <label class="form-label">First Name <label class="text-danger">*</label></label>
                                    <input type="text" name="first_name"
                                        class="form-control @error('first_name') is-invalid @enderror"
                                        placeholder="Enter first name" value="{{ old('first_name') }}">
                                    @error('first_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3 w-100">
                                    <label class="form-label">Last Name <label class="text-danger">*</label></label>
                                    <input type="text" name="last_name"
                                        class="form-control @error('last_name') is-invalid @enderror"
                                        placeholder="Enter last name" value="{{ old('last_name') }}">
                                    @error('last_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="affiliate-form-flex">

                                <div class="mb-3 w-100">
                                    <label class="form-label">Email <label class="text-danger">*</label></label>
                                    <input type="email" name="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        placeholder="Enter email" value="{{ old('email') }}">
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3 w-100">
                                    <label class="form-label">Password <label class="text-danger">*</label></label>
                                    <input type="password" name="password"
                                        class="form-control @error('password') is-invalid @enderror"
                                        placeholder="Enter password">
                                    @error('password')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="affiliate-form-flex">
                                <div class=" w-100">
                                    <label class="form-label">Phone No</label>
                                    <div class="input-group phone-input">
                                        <input type="tel" id="phone" name="phone_number" class="form-control"
                                            placeholder="Enter your phone number"
                                            oninput="this.value = this.value.replace(/[^0-9-]/g,'')">
                                    </div>

                                    <label id="phone-error" class="text-danger" for="phone"></label>

                                    {{-- Hidden fields --}}
                                    <input type="hidden" name="phone" id="full_phone">
                                    <input type="hidden" name="country_code" id="country_code">

                                </div>
                                <div class="mb-3 w-100">
                                    <label class="form-label">Commision Type <label class="text-danger">*</label></label>
                                    <select name="commission_type" id="commission_type" class="form-select"
                                        @error('commission_type') is-invalid @enderror>
                                        <option value="" selected disabled selected disabled>Select commission type</option>
                                        <option value="fixed">Fix</option>
                                        <option value="percentage">Percentage</option>
                                    </select>
                                    @error('commission_type')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="affiliate-form-flex">
                                <div class="mb-3 w-100">
                                    <label class="form-label">Commission Value <label
                                            class="text-danger">*</label></label>
                                    <input type="text" name="commission_value"
                                        class="form-control @error('commission_value') is-invalid @enderror"
                                        placeholder="Enter commission value" value="{{ old('last_name') }}" 
                                         oninput="this.value = this.value.replace(/[^0-9.]/g,'')">
                                    @error('commission_value')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3 w-100 ">
                                    <label class="form-label">Address</label>
                                    <textarea name="address" placeholder="Enter address" rows="4"
                                        class="form-control affiliate-textarea @error('address') is-invalid @enderror">{{ old('address') }}</textarea>
                                    @error('address')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary px-4">
                                Add Affiliate User
                            </button>
                            <a href="{{ route('admin.affiliates.list') }}" class="btn btn-primary px-4">
                                Cancel
                            </a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>