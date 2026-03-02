<section class="login_page">
    <div class="auth-wrapper">

        <div class="login-overlay"></div>
        <div class="card-wrapper">
            <!-- Logo -->
            <div class="brand">
                <i class="bi bi-film"></i>
                <span>GStockFootage</span>
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
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" placeholder="you@example.com">
                        <label id="email-error" class="text-danger" for="email"></label>
                    </div>


                    <div>
                        <label>Password</label>
                        <div class="password-field">
                            <input type="password" name="password" class="form-control" placeholder="••••••••">
                            <i class="bi bi-eye toggle-password"></i>
                        </div>
                        <label id="password-error" class="text-danger" for="password"></label>
                    </div>
                    <button type="submit" class="btn auth-btn btn-orange">Sign In</button>
                    {{-- <a href="{{ route('password.request') }}" class="forgot">Forgot your password?</a> --}}
                </form>

                <!-- Signup Form -->
                <form id="signup" class="auth-form" method="POST" action="{{ route('register') }}">
                    @csrf
                    <div>
                        <label>First Name</label>
                        <input type="text" name="first_name" class="form-control" placeholder="John">
                        <label id="first_name-error" class="text-danger" for="first_name"></label>

                    </div>
                    <div>
                        <label>Last Name</label>
                        <input type="text" name="last_name" class="form-control" placeholder="Doe">
                        <label id="last_name-error" class="text-danger" for="last_name"></label>

                    </div>

                    <div>
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" placeholder="you@example.com">
                        <label id="email-error" class="text-danger" for="email"></label>

                    </div>

                    <div>
                        <label>Password</label>
                        <div class="password-field">
                            <input type="password"name="password" class="form-control" placeholder="••••••••">
                            <i class="bi bi-eye toggle-password"></i>
                        </div>
                        <label id="password-error" class="text-danger" for="password"></label>

                    </div>

                    <button type="submit" class="btn auth-btn btn-orange">Sign Up</button>
                </form>

            </div>
        </div>
    </div>
</section>
