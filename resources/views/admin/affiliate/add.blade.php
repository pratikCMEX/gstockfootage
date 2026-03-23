
<div class="body-wrapper-inner">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="card-title fw-semibold mb-0">Add Affiliate</h5>
                            <a href="{{ route('admin.affiliates.list') }}" class="btn btn-secondary btn-sm">
                                <i class="fa fa-arrow-left me-1"></i> Back
                            </a>
                        </div>

                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <form action="{{ route('admin.affiliates.store') }}" method="POST" id="affiliate_form">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">First Name <span class="text-danger">*</span></label>
                                <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror"
                                    placeholder="Enter first name" value="{{ old('first_name') }}">
                                @error('first_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Last Name <span class="text-danger">*</span></label>
                                <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror"
                                    placeholder="Enter last name" value="{{ old('last_name') }}">
                                @error('last_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                    placeholder="Enter email" value="{{ old('email') }}">
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Password <span class="text-danger">*</span></label>
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                                    placeholder="Enter password">
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                             <!-- <div class="mb-3">
                                <label class="form-label">Phone No <span class="text-danger">*</span></label>
                                <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                                    placeholder="Enter phone" value="{{ old('phone') }}">
                                @error('phone')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div> -->
                            <div>
                            <label>Phone No</label>
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

                             <div class="mb-3">
                                <label class="form-label">Address <span class="text-danger">*</span></label>
                                <textarea name="address" placeholder="Enter address" class="form-control @error('address') is-invalid @enderror">{{ old('address') }}</textarea>
                                @error('address')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                           

                            <button type="submit" class="btn btn-primary px-4">
                                <i class="fa fa-save me-1"></i> Save Affiliate
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


