{{-- <html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Document</title>
</head>

<body>
    <form id="contactForm" action="{{ route('password.store') }}" method="POST">
        @csrf
        <input type="hidden" name="token" value="{{ request()->route('token') }}">
        <input type="hidden" name="email" value="{{ request()->email }}">
        <input type="text" name="password" id="password" placeholder="Password *">
        <input type="text" name="password_confirmation" id="password_confirmation" placeholder="Conform Password *">

        <button type="submit">Send Message</button>
    </form>

</body>

</html> --}}
<div class="auth-wrapper">

    <!-- Brand -->
    <div class="brand">
        <a href="{{ route('home') }}">
            <i class="bi bi-film"></i>
            <span>GStockFootage</span>
        </a>

    </div>

    <!-- Card -->
    <div class="auth-card text-center">

        <div class="icon-box">
            <i class="bi bi-envelope"></i>
        </div>

        <h4 class="mb-2">Change Password</h4>

        {{-- <p class="text-muted mb-4">
            Enter your email address and we’ll send you a link to reset your password
        </p> --}}

        <form id="change_forget_pass" class="auth-form active" method="POST" action="{{ route('password.store') }}">
            @csrf
            <input type="hidden" name="token" value="{{ request()->route('token') }}">
            <input type="hidden" name="email" value="{{ request()->email }}">
            {{-- <div class="mb-3 text-start">
                <label class="form-label ">Password</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Password *">
            </div> --}}
            <div class="mb-3 text-start">
                <label class="form-label">Password</label>
                <div class="password-field">
                    <input type="password" name="password" id="password" class="form-control" placeholder="••••••••">
                    <i class="bi bi-eye toggle-password"></i>
                </div>
                <label id="password-error" class="text-danger" for="password"></label>
            </div>
            <div class="mb-3 text-start">
                <label class="form-label">Confirm Password</label>
                <div class="password-field">
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control"
                        placeholder="••••••••">
                    <i class="bi bi-eye toggle-password"></i>
                </div>
                <label id="password_confirmation-error" class="text-danger" for="password_confirmation"></label>
            </div>


            <button type="submit" class="btn btn-orange auth-btn w-100" style="padding: 9px !important;">
                Change Password
            </button>
        </form>

        {{-- <a href="{{ route('login') }}" class="back-link">
            <i class="bi bi-arrow-left"></i>
            Back to Sign In
        </a> --}}

    </div>
</div>
