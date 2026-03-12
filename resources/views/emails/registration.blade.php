<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet"/>

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

        .section-label::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--rule);
        }
    </style>
</head>

<body style="background: var(--bg);
      font-family: 'Jost', sans-serif;
      font-weight: 400;
      color: var(--text);
      padding: 48px 16px 64px;
      -webkit-font-smoothing: antialiased;">
    <div class="wrapper" style=" max-width: 580px;
      margin: 0 auto;">
        <div class="top-mark" style="text-align: center; margin-bottom: 36px;">
            <div class="wordmark" style="width: 170px; height: 90px; margin: auto;">
                <img src="imgs/header-logo.png" height="100%" width="100%" alt="">
            </div>
            <div class="tagline" style="font-size: 11px; font-weight: 500;
      color: var(--second-text); letter-spacing: 3px; text-transform: uppercase;margin-top: 4px;">Official
                Communication</div>
        </div>
        <!-- Orange Stripe -->
        <div class="header-stripe" style=" height: 4px;
      background: var(--help-text)"></div>
        <!-- card -->
        <div class="card" style=" background: var(--card-bg);
      border-radius: 4px;
      overflow: hidden;
      box-shadow: 0 1px 4px rgba(0,0,0,0.06), 0 8px 32px rgba(0,0,0,0.05);">
            <div class="header" style="padding: 52px 56px 44px;
    border-bottom: 1px solid var(--rule);
    text-align: center;">
                <div class="status-badge" style="display: inline-flex;
    align-items: center;
    gap: 8px;
    background: var(--primary-light);
    border: 1px solid var(--primary-border);
    border-radius: 2px;
    padding: 6px 16px;
    margin-bottom: 28px;">
                    <div class="status-dot" style="width: 7px;
    height: 7px;
    border-radius: 50%;
    background: var(--primary);"></div>
                    <span style="font-size: 11px;
    font-weight: 600;
    color: var(--primary);
    letter-spacing: 2px;
    text-transform: uppercase;">Registration Successful</span>
                </div>
                <h1 style="    font-family: 'Cormorant Garamond', serif;
    font-size: 38px;
    font-weight: 400;
    color: var(--text);
    line-height: 1.15;
    letter-spacing: -0.3px;
    margin-bottom: 14px;">Welcome to<br />Gstockfootage</h1>
                <p style="font-size: 14px;
    font-weight: 300;
    color: var(--second-text);
    line-height: 1.7;
    max-width: 380px;
    margin: 0 auto;">Your account has been created and is ready to use. Please review the information below carefully.
                </p>
            </div>
            <div class="card-body" style="padding: 44px 56px;">
                <p class="greeting" style="font-family: 'Cormorant Garamond', serif;
    font-size: 20px;
    font-weight: 500;
    color: var(--text);
    margin-bottom: 12px;">Dear [User's Full Name],</p>
                <p class="intro" style="    font-size: 14px;
    font-weight: 300;
    color: var(--second-text);
    line-height: 1.85;
    margin-bottom: 40px;">
                    Thank you for registering with <strong style="    color: var(--text);
    font-weight: 600;">Gstockfootage</strong>. We are pleased to confirm that
                    your account has been successfully created. Your login credentials and account confirmation details
                    are provided below.
                </p>
                <!-- Credentials -->
                <div class="section-label" style="    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 16px;">
                    <span style="    font-size: 10px;
    font-weight: 600;
    letter-spacing: 2.5px;
    text-transform: uppercase;
    color: var(--second-text);">Login Credentials</span>
                </div>
                <div class="cred-table" style="width: 100%;
    border: 1px solid var(--rule);
    border-radius: 3px;
    overflow: hidden;
    margin-bottom: 14px;">
                    <div class="cred-row" style="    display: flex;
    border-bottom: 1px solid var(--rule);">
                        <div class="cred-key" style="    width: 130px;
    flex-shrink: 0;
    padding: 14px 18px;
    background: #faf8f5;
    border-right: 1px solid var(--rule);
    font-size: 11px;
    font-weight: 600;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    color: var(--second-text);
    display: flex;
    align-items: center;">Email</div>
                        <div class="cred-val" style="flex: 1;
    padding: 14px 20px;
    font-size: 14px;
    font-weight: 500;
    color: var(--text);
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;">
                            [user@example.com]
                        </div>
                    </div>

                </div>

            </div>
            <div class="footer" style="padding: 28px 56px 36px;
    border-top: 1px solid var(--rule);
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 16px;">
                <div class="footer-left" style="    font-size: 11px;
    color: var(--copyright);
    line-height: 1.7;">
                    © 2026 <a href="#" style="color: var(--primary);
    text-decoration: none;">Gstockfootage</a>. All rights reserved.<br />
                    [Company Address, City, Country]
                </div>
                <div class="footer-links" style="display: flex;
    gap: 20px;">
                    <a href="#" style="    font-size: 11px;
    color: var(--copyright);
    text-decoration: none;
    letter-spacing: 0.3px;">Privacy</a>
                    <a href="#" style="    font-size: 11px;
    color: var(--copyright);
    text-decoration: none;
    letter-spacing: 0.3px;">Terms</a>
                    <a href="#" style="    font-size: 11px;
    color: var(--copyright);
    text-decoration: none;
    letter-spacing: 0.3px;">Help</a>
                    <a href="#" style="    font-size: 11px;
    color: var(--copyright);
    text-decoration: none;
    letter-spacing: 0.3px;">Unsubscribe</a>
                </div>
            </div>
        </div>
    </div>

</body>

</html>