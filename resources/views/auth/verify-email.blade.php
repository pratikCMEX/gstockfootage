@php
    $banner = getBanner();
@endphp
<section class="login_page">
    <div class="auth-wrapper"
        style="background: url('{{ $banner ? asset('uploads/banners/' . $banner->image) : asset('assets/front/img/banner.jpg') }}') 50% / cover no-repeat;">
        <div class="login-overlay"></div>
        <div class="card-wrapper">
            <!-- Logo -->
            <div class="brand">
                <a href="{{ route('home') }}">
                    <i class="bi bi-film"></i>
                    <span>GStockFootage</span>
                </a>
            </div>

            <!-- Card -->
            <div class="auth-card">
                <div class="text-center mb-4">
                    <i class="bi bi-envelope-check text-primary" style="font-size: 3rem;"></i>
                    <h4>Verify Your Email</h4>
                    <p class="text-muted">Please check your email for a verification link.</p>
                </div>

                @if(session('msg_success'))
                    <div class="alert alert-success">
                        {{ session('msg_success') }}
                    </div>
                @endif

                @if(session('msg_error'))
                    <div class="alert alert-danger">
                        {{ session('msg_error') }}
                    </div>
                @endif

                <div class="text-center">
                    <a href="{{ route('login') }}" class="btn btn-outline-secondary">
                        Back to Login
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
