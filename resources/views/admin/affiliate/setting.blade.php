
<div class="body-wrapper-inner">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-4">
                            <h5 class="card-title fw-semibold">Affiliate Commission Setting</h5>
                            <p class="text-muted">Set the fixed commission amount that every affiliate user will earn per successful order.</p>
                        </div>

                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <form action="{{ route('admin.affiliate.setting.update') }}" method="POST" id="affiliate_setting_form">
                            @csrf

                            <div class="mb-4">
                                <label class="form-label fw-semibold">
                                    Commission Amount (USD) <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input 
                                        type="number" 
                                        name="commission_amount" 
                                        class="form-control @error('commission_amount') is-invalid @enderror"
                                        placeholder="Enter commission amount e.g. 20"
                                        value="{{ old('commission_amount', $setting->commission_amount ?? '') }}"
                                        step="0.01"
                                        min="0">
                                </div>
                                @error('commission_amount')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror

                                @if($setting)
                                    <small class="text-muted mt-1 d-block">
                                        Current commission: 
                                        <strong class="text-success">${{ number_format($setting->commission_amount, 2) }}</strong>
                                        — Last updated: {{ $setting->updated_at->format('d M Y, h:i A') }}
                                    </small>
                                @endif
                            </div>
                           
                          

                            <button type="submit" class="btn btn-primary px-4">
                                <i class="fa fa-save me-1"></i> Save Commission
                            </button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


