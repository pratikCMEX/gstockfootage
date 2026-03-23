<div class="body-wrapper-inner">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="card-title fw-semibold mb-0">Edit Affiliate</h5>
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

                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <form action="{{ route('admin.affiliates.update', $affiliate->id) }}" method="POST" id="affiliate_form">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label class="form-label">First Name <span class="text-danger">*</span></label>
                                <input type="text" name="first_name"
                                    class="form-control @error('first_name') is-invalid @enderror"
                                    placeholder="Enter first name"
                                    value="{{ old('first_name', $affiliate->affiliateUser->first_name) }}">
                                @error('first_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Last Name <span class="text-danger">*</span></label>
                                <input type="text" name="last_name"
                                    class="form-control @error('last_name') is-invalid @enderror"
                                    placeholder="Enter last name"
                                    value="{{ old('last_name', $affiliate->affiliateUser->last_name) }}">
                                @error('last_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    placeholder="Enter email"
                                    value="{{ old('email', $affiliate->affiliateUser->email) }}">
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- ✅ Hidden field to pass user id for unique email validation --}}
                            <input type="hidden" name="user_id" value="{{ $affiliate->affiliateUser->id }}">

                            <div class="mb-3">
                                <label class="form-label">Password
                                    <small class="text-muted">(Leave blank to keep current)</small>
                                </label>
                                <input type="password" name="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    placeholder="Enter new password">
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label>Phone No</label>
                                <div class="input-group phone-input">
                                    <input type="tel" id="phone" name="phone_number" class="form-control"
                                        placeholder="Enter your phone number"
                                        value="{{ old('phone_number', $affiliate->affiliateUser->phone_number ?? '') }}"
                                        oninput="this.value = this.value.replace(/[^0-9-]/g,'')">
                                </div>
                                <label id="phone-error" class="text-danger" for="phone"></label>

                                {{-- Hidden fields --}}
                                <input type="hidden" name="phone" id="full_phone"
                                    value="{{ old('phone', $affiliate->affiliateUser->phone ?? '') }}">
                                <input type="hidden" name="country_code" id="country_code"
                                    value="{{ old('country_code', $affiliate->affiliateUser->country_code ?? '') }}">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Address</label>
                                <textarea name="address"
                                    placeholder="Enter address"
                                    class="form-control @error('address') is-invalid @enderror">{{ old('address', $affiliate->affiliateUser->address ?? '') }}</textarea>
                                @error('address')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- ✅ Referral code display (read only) --}}
                            <div class="mb-4">
                                <label class="form-label">Referral Code</label>
                                <div class="input-group">
                                    <input type="text" class="form-control"
                                        value="{{ $affiliate->referral_code }}" readonly>
                                    <button type="button" class="btn btn-outline-secondary copy-btn"
                                        data-link="{{ url('/') }}?ref={{ $affiliate->referral_code }}">
                                        <i class="fa fa-copy"></i> Copy Link
                                    </button>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Status <span class="text-danger">*</span></label>
                                <select name="status" class="form-select @error('status') is-invalid @enderror">
                                    <option value="active" {{ old('status', $affiliate->status) === 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ old('status', $affiliate->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                                @error('status')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary px-4">
                                <i class="fa fa-save me-1"></i> Update Affiliate
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>