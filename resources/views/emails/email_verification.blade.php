<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>email template</title>
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
                <!-- <img src="{{ asset('assets/front/logo/header-logo.png') }}" height="100%" width="100%" alt=""> -->
                <img src="{{ url('/assets/front/logo/header-logo.png') }}" width="170">
            </div>
            <!-- <div class="tagline" style="font-size: 11px; font-weight: 500;
      color: #737373; letter-spacing: 3px; text-transform: uppercase;margin-top: 4px;">Official
                Communication</div> -->
        </div>
        <!-- Orange Stripe -->
        <div class="header-stripe" style=" height: 4px;
      background: linear-gradient(90deg, #ff8c00, #ff4500)"></div>
        <!-- card -->
        <div class="card" style=" background: #ffffff;
      border-radius: 4px;
      overflow: hidden;
      box-shadow: 0 1px 4px rgba(0,0,0,0.06), 0 8px 32px rgba(0,0,0,0.05);">
            <div class="header" style="padding: 52px 56px 44px;
    border-bottom: 1px solid #e8e2d9;
    text-align: center;">
                <div class="status-badge" style="display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #fff3e6;
    border: 1px solid #ffcc80;
    border-radius: 2px;
    padding: 6px 16px;
    margin-bottom: 28px;">
                    <!-- <div class="status-dot" style="width: 7px;
    height: 7px;
    border-radius: 50%;
    background: #ff8000;"></div> -->
                    <span style="font-size: 11px;
    font-weight: 600;
    color: #ff8000;
    letter-spacing: 2px;
    text-transform: uppercase;">EMAIL VERIFICATION</span>
                </div>
                <h1 style="    font-family: 'Cormorant Garamond', serif;
    font-size: 38px;
    font-weight: 400;
    color: #121212;
    line-height: 1.15;
    letter-spacing: -0.3px;
    margin-bottom: 14px;">Welcome to<br />Gstockfootage</h1>
                <p style="font-size: 14px;
    font-weight: 300;
    color: #fff;
    line-height: 1.7;
    max-width: 380px;
    margin: 0 auto;">Your account has been created and is ready to use. Please review the information below carefully.
                </p>
            </div>
            <div class="card-body" style="    padding: 44px 56px;">
                <!-- CTA -->
                <div class="cta-section">

                    <p class="cta-heading" style=" font-family: 'Cormorant Garamond', serif;
    font-size: 18px;
    font-weight: 600;
    color: #121212;
    margin-bottom: 8px;">Confirm your account to get started</p>
                    <p class="cta-sub" style="font-size: 13px;
      font-weight: 300;
      color: #737373;
      margin-bottom: 24px;
      line-height: 1.6;">
                        Please verify your email address by clicking the button below.
                        This confirmation link will expire in <strong style="color: #cc4400; font-weight: 600;">24
                            hours</strong>.
                    </p>
                    <a href="{{ $url }}" class="cta-btn" style="display: inline-block;
      background: #ff8000;
      color: #fff;
      text-decoration: none;
      padding: 15px 40px;
      border-radius: 2px;
      font-size: 13px;
      font-weight: 600;
      letter-spacing: 1.5px;
      text-transform: uppercase;">Confirm My Account</a>
                    <p class="cta-link-fallback" style="  margin-top: 16px;
      font-size: 12px;
      font-weight: 300;
      color: #737373;
      line-height: 1.7;">
                        If the button above does not work, copy and paste this link into your browser:<br />
                        <a href="[CONFIRMATION_LINK]" style="   color: #ff8000;
      text-decoration: none;
      word-break: break-all;">{{ $url }}</a>
                    </p>
                </div>

            </div>
            <table width="100%" cellpadding="0" cellspacing="0"
                style="padding:28px 56px 36px;border-top:1px solid #e8e2d9;">
                <tr>
                    <td style="font-size:11px;color:#999;line-height:1.7;" align="left">
                        © 2026 <a href="#" style="color:#ff8000;text-decoration:none;">Gstockfootage</a>. All rights
                        reserved.<br>
                        [Company Address, City, Country]
                    </td>

                    <td align="right" style="font-size:11px;">
                        <a href="#" style="color:#999;text-decoration:none;margin-left:15px;">Privacy</a>
                        <a href="#" style="color:#999;text-decoration:none;margin-left:15px;">Terms</a>
                        <a href="#" style="color:#999;text-decoration:none;margin-left:15px;">Help</a>
                        <a href="#" style="color:#999;text-decoration:none;margin-left:15px;">Unsubscribe</a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>

</html>