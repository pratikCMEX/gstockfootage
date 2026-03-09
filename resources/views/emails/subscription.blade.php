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
        <!-- Top Wordmark -->
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
    </div>

</body>

</html>