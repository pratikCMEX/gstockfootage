{{-- <html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Document</title>
</head>

<body>
    <form id="contactForm" action="{{ route('password.email') }}" method="POST">
        @csrf

        <input type="text" name="email" id="email" placeholder="Subject *">

        <button type="submit">Send Message</button>
    </form>

</body>

</html> --}}

<div class="auth-wrapper">

    <!-- Brand -->
    <div class="brand">
        <i class="bi bi-film"></i>
        <span>GStockFootage</span>
    </div>

    <!-- Card -->
    <div class="auth-card text-center">

        <div class="icon-box">
            <i class="bi bi-envelope"></i>
        </div>

        <h4 class="mb-2">Reset Password</h4>

        <p class="text-muted mb-4">
            Enter your email address and we’ll send you a link to reset your password
        </p>

        <form>
            <div class="mb-3 text-start">
                <label class="form-label ">Email</label>
                <input type="email" name="email" id="email" class="form-control" placeholder="you@example.com"
                    required>
            </div>

            <button type="submit" class="btn btn-orange auth-btn w-100" style="padding: 9px !important;">
                Send Reset Link
            </button>
        </form>

        <a href="log_in.html" class="back-link">
            <i class="bi bi-arrow-left"></i>
            Back to Sign In
        </a>

    </div>
</div>
