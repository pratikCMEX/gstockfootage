@php
    $banner = getBanner();
@endphp
<section class="login_page">
    {{-- <div class="auth-wrapper" style="background: "> --}}
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
                    <i class="bi bi-film"></i>
                    <h4>Welcome</h4>
                    <p class="text-muted">Sign in to access your account</p>
                </div>

                <!-- Tabs -->
                <div class="auth-tabs">
                    <button class="tab-btn active" data-tab="login">Sign In</button>
                    <button class="tab-btn" data-tab="signup">Sign Up</button>
                </div>

                <!-- Login Form -->
                <form id="login" class="auth-form active" method="POST" action="{{ route('check.login') }}">
                    @csrf
                    <div class="">
                        <label>Email *</label>
                        <input type="email" name="email" class="form-control" placeholder="you@example.com">
                        <label id="email-error" class="text-danger" for="email"></label>
                    </div>

                    <div>
                        <label>Password *</label>
                        <div class="password-field">
                            <input type="password" name="password" class="form-control" placeholder="••••••••">
                            <i class="bi bi-eye toggle-password"></i>
                        </div>
                        <label id="password-error" class="text-danger" for="password"></label>
                    </div>
                    <button type="submit" class="btn auth-btn btn-orange">Sign In</button>
                    <a href="{{ route('password.request') }}" class="forgot">Forgot your password?</a>
                </form>
                <!-- Resend Verification Section - Only show when login tab is active -->
                {{-- <div class="mt-3 text-center" id="resend-verification-section">
                        <p class="text-muted">Didn't receive verification email?</p>
                        <form name="resend_mail_varification" id="resend_mail_varification" method="POST"
                            action="{{ route('verification.resend') }}" class="d-inline">
                            @csrf
                            <div class="input-group mb-2" style="max-width: 300px; margin: 0 auto;">
                                <input type="email" name="email" class="form-control" placeholder="Enter your email"
                                    required>
                                <button type="submit"
                                    class="btn btn-sm btn-outline-primary bg-primary text-light rounded-start-0">Resend</button>

                            </div>
                            <label id="email-error" class="text-danger" for="email"></label>

                        </form>

                    </div> --}}


                <!-- Signup Form -->
                <form id="signup" name="signup" class="auth-form" method="POST" action="{{ route('register') }}">
                    @csrf
                    <div>
                        <label>First Name *</label>
                        <input type="text" name="first_name" class="form-control" placeholder="John">
                        <label id="first_name-error" class="text-danger" for="first_name"></label>

                    </div>
                    <div>
                        <label>Last Name *</label>
                        <input type="text" name="last_name" class="form-control" placeholder="Doe">
                        <label id="last_name-error" class="text-danger" for="last_name"></label>

                    </div>

                    <div>
                        <label>Email *</label>
                        <input type="email" name="email" class="form-control" placeholder="you@example.com">
                        <label id="email-error" class="text-danger" for="email"></label>

                    </div>
                    <div>
                        <label>Phone No</label>
                        <input type="text" name="phone" class="form-control" placeholder="Enter your phone number"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '')" maxlength="15">
                        <label id="phone-error" class="text-danger" for="phone"></label>

                    </div>
                    <div>
                        <label>Address</label>
                        <textarea name="address" class="" rows="3" cols="34" placeholder="" style="border-radius: 10px;"></textarea>
                        <label id="address-error" class="text-danger" for="address"></label>

                    </div>

                    <div>
                        <label>Password *</label>
                        <div class="password-field">
                            <input type="password" name="password" class="form-control" placeholder="••••••••">
                            <i class="bi bi-eye toggle-password"></i>
                        </div>
                        <label id="password-error" class="text-danger" for="password"></label>

                    </div>

                    <button type="submit" class="btn auth-btn btn-orange">Sign Up</button>
                    <!-- <a href="{{ route('password.request') }}" class="forgot">Forgot your password?</a> -->
                </form>

            </div>
        </div>
    </div>
</section>
