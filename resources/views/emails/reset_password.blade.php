<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=DM+Sans:wght@400;500&display=swap"
        rel="stylesheet" />

    <style>
        :root {
            --primary: #ff8000;
            --primary-light: #fff3e6;
            --primary-border: #ffcc80;
            --text: #121212;
            --second-text: #737373;
            --white: #fff;
            --bg: #f7f4f0;
            --card-bg: #ffffff;
            --rule: #e8e2d9;
            --copyright: #999;
            --help-text: linear-gradient(90deg, #ff8c00, #ff4500);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
    </style>
</head>

<body style="background: #f7f4f0;
      font-family: 'Jost', sans-serif;
      font-weight: 400;
      color: #121212;
      padding: 48px 16px 64px;
      -webkit-font-smoothing: antialiased;">
    <div class="wrapper" style=" max-width: 580px;
      margin: 0 auto;">
        <!-- Top Wordmark -->
        <div class="top-mark" style="text-align: center; margin-bottom: 36px;">
            <div class="wordmark" style="width: 170px; height: 90px; margin: auto;">
                <!-- <img src="{{  config('app.url') }}/assets/front/logo/header-logo.png" height="100%" width="100%" alt=""> -->
                <!-- <img src="{{ config('app.url') }}/assets/front/logo/header-logo.png" width="170" alt="Logo"> -->

                <img src="{{ url('/assets/front/logo/header-logo.png') }}" width="170">
            </div>
            <!-- <div class="tagline" style="font-size: 11px; font-weight: 500;
      color: #737373; letter-spacing: 3px; text-transform: uppercase;margin-top: 4px;">Official
                Communication</div>

        </div> -->
            <!-- Orange Stripe -->
            <div class="header-stripe" style=" height: 4px;
      background:  linear-gradient(90deg, #ff8c00, #ff4500)"></div>

            <!-- card -->
            <div class="card" style=" background: #ffffff;
      border-radius: 4px;
      overflow: hidden;
      box-shadow: 0 1px 4px rgba(0,0,0,0.06), 0 8px 32px rgba(0,0,0,0.05);">
                <div class="card-body" style="    padding: 44px 56px; text-align: left;">
                    <!-- CTA -->
                    <div class="cta-section">

                        <p class="cta-heading" style=" font-family: 'Cormorant Garamond', serif;
    font-size: 26px;
    font-weight: 600;
    color: #121212;
    margin-bottom: 8px; text-align: left;">Reset Your Password</p>
                        <p class="intro" style="    font-size: 16px;
    font-weight: 300;
    color: #737373;
    line-height: 1.85;
    margin-bottom: 30px; text-align: left;">
                            Hello , {{ $user->first_name . ' ' . $user->last_name }}<br>
                            You are reciving this email because we recived password reset request for your account.
                        </p>
                        <a href="{{ $url }}" class="cta-btn" style="display: inline-block;
      background: #ff8000;
      color: #fff;
      text-decoration: none;
      padding: 15px 40px;
      margin-bottom: 30px;
      border-radius: 2px;
      font-size: 13px;
      font-weight: 600;
      letter-spacing: 1.5px;
      text-transform: uppercase; text-align: left;">Reset Password</a>

                        <p class="intro" style="    font-size: 16px;
    font-weight: 300;
    color: #737373;
    line-height: 1.85;
    margin-bottom: 20px; text-align: left;">
                            This password reset link will expire in 60 minutes.
                            <br>
                            If you did not request a password reset , no further action is required.
                        </p>
                        <p class="intro" style="    font-size: 16px;
    font-weight: 300;
    color: #737373;
    line-height: 1.85;
    margin-bottom: 20px; text-align: left;">
                            Regards,
                            <br>
                            Laravel
                        </p>
                        <hr class="h-rule" style="border: none;
      border-top: 1px solid #e8e2d9;
      margin: 36px 0;" />

                        <p class="cta-link-fallback" style="  margin-top: 16px;
      font-size: 14px;
      font-weight: 300;
      color: #737373;
      line-height: 1.7; text-align: left;">
                            If you're having double clicking the "Reset Password" button , Copy and paste the URL below
                            into
                            your web browser:
                            <a href="{{ $url }}" style="   color: #ff8000;
      text-decoration: none;
      word-break: break-all;">{{ $url }}</a>
                        </p>
                    </div>

                </div>
            </div>

        </div>

</body>

</html>