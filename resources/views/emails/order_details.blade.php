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
            background: #e8e2d9;
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
                <img src="{{ url('/assets/front/logo/header-logo.png') }}" width="170" alt="">
            </div>
            <!-- <img src="{{ $message->embed(public_path('assets/front/logo/header-logo.png')) }}" width="170" alt=""> -->
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
    text-transform: uppercase;">Order Confirmed</span>
                </div>
                <h1 style="    font-family: 'Cormorant Garamond', serif;
    font-size: 38px;
    font-weight: 600;
    color: #121212;
    line-height: 1.15;
    letter-spacing: -0.3px;
    margin-bottom: 14px;">Thank you for
                    <br />your order!
                </h1>
                <p style="font-size: 14px;
    font-weight: 300;
    color: #737373;
    line-height: 1.7;
    max-width: 380px;
    margin: 0 auto;">Your order has been received and is now being processed. Please review the details below
                    carefully.
                </p>
            </div>
            <div class="card-body" style="padding: 44px 56px;">
                <p class="greeting" style="font-family: 'Cormorant Garamond', serif;
    font-size: 20px;
    font-weight: 500;
    color: #121212;
    margin-bottom: 12px;">Dear<strong> @if(isset($order->user) && !empty(isset($order->user)))
        {{ $order->user->first_name . ' ' . $order->user->last_name }}
    @else
                            {{ $order->email }}
                        @endif
                        ,</strong>
                </p>
                <p class="intro" style="    font-size: 14px;
    font-weight: 300;
    color: #737373;
    line-height: 1.85;
    margin-bottom: 40px;">
                    Thank you for shopping with <strong style="color: #121212;
    font-weight: 600;">Gstockfootage</strong>. We are pleased to confirm that
                    your order has been successfully placed. Your order details and estimated delivery information are
                    provided below.
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
    color: #737373;">order information</span>
                </div>
                <table class="info-table" style="width: 100%;
    border-collapse: collapse;
    border: 1px solid #e8e2d9;">
                    <tr style="    border-bottom: 1px solid #e8e2d9;">
                        <td class="td-label" style="    padding: 13px 16px;
    vertical-align: middle;
                        font-size: 10.5px;
    font-weight: 500;
    letter-spacing: 0.8px;
    text-transform: uppercase;
    color: #737373;
    width: 110px;
    border-right: 1px solid #e8e2d9;
    background-color: #f7f4f0;">Order No</td>
                        <td style="    padding: 13px 16px;
                        font-size: 13px;
    vertical-align: middle;    color: #121212;
    font-weight: 500;" class="td-value">{{ $order->order_number }} </td>
                    </tr>
                    <tr style="    border-bottom: 1px solid #e8e2d9;">
                        <td class="td-label" style="    padding: 13px 16px;
    vertical-align: middle;
                        font-size: 10.5px;
    font-weight: 500;
    letter-spacing: 0.8px;
    text-transform: uppercase;
    color: #737373;
    width: 110px;
    border-right: 1px solid #e8e2d9;
    background: #f7f4f0;">Date</td>
                        <td style="    padding: 13px 16px;
                        font-size: 13px;
    vertical-align: middle;    color: #121212;
    font-weight: 500;" class="td-value">{{ $order->created_at->format('F j, Y') }}</td>
                    </tr>
                    <tr style="    border-bottom: 1px solid #e8e2d9;">
                        <td class="td-label" style="    padding: 13px 16px;
    vertical-align: middle;
                        font-size: 10.5px;
    font-weight: 500;
    letter-spacing: 0.8px;
    text-transform: uppercase;
    color: #737373;
    width: 110px;
    border-right: 1px solid #e8e2d9;
    background: #f7f4f0;">Payment</td>
                        <td style="    padding: 13px 16px;
                        font-size: 13px;
    vertical-align: middle;    color: #121212;
    font-weight: 500;" class="td-value">Visa •••• 4242 </td>
                    </tr>
                    <tr style="border-bottom: 1px solid #e8e2d9;">
                        <td class="td-label" style="    padding: 13px 16px;
    vertical-align: middle;
                        font-size: 10.5px;
    font-weight: 500;
    letter-spacing: 0.8px;
    text-transform: uppercase;
    color: #737373;
    width: 110px;
    border-right: 1px solid #e8e2d9;
    background: #f7f4f0;">Ship To</td>
                        <td style="    padding: 13px 16px;
                        font-size: 13px;
    vertical-align: middle;    color: #121212;
    font-weight: 500;" class="td-value">340 Pine Street, Suite 800,<br />San Francisco, CA 94104</td>
                    </tr>
                    <tr style="    border-bottom: 1px solid #e8e2d9;">
                        <td class="td-label" style="    padding: 13px 16px;
    vertical-align: middle;
                        font-size: 10.5px;
    font-weight: 500;
    letter-spacing: 0.8px;
    text-transform: uppercase;
    color: #737373;
    width: 110px;
    border-right: 1px solid #e8e2d9;
    background: #f7f4f0;">Delivery</td>
                        <td style="    padding: 13px 16px;
                        font-size: 13px;
    vertical-align: middle;    color: #121212;
    font-weight: 500;" class="td-value">Mar 10 – 12, 2026 (Standard)</td>
                    </tr>
                </table>
                <div class="notice-box" style="display: flex;
    gap: 10px;
    align-items: flex-start;
    background: #fff3e6;
    border: 1px solid #ffcc80;
    border-left: 3px solid #ff8000;
    padding: 12px 16px;
    margin-top: 16px;">
                    <svg viewBox="0 0 24 24" style="width: 14px;
    height: 14px;
    stroke: #ff8000;
    fill: none;
    stroke-width: 2;
    stroke-linecap: round;
    stroke-linejoin: round;
    flex-shrink: 0;
    margin-top: 1px;">
                        <circle cx="12" cy="12" r="10" />
                        <line x1="12" y1="8" x2="12" y2="12" />
                        <line x1="12" y1="16" x2="12.01" y2="16" />
                    </svg>
                    <p style="    font-size: 12.5px;
    color: #737373;
    line-height: 1.55;">You will receive a shipping confirmation email with your tracking number once your order has
                        been
                        dispatched.</p>
                </div>
                <table width="100%" cellpadding="0" cellspacing="0"
                    style="border-bottom:1px solid #e8e2d9;padding:14px 0;">
                    <!-- Items -->
                    <div class="items-section">
                        <div class="section-label" style="display: flex;
    align-items: center;
    gap: 12px;
    font-size: 10px;
    font-weight: 500;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    color: #737373;
    margin: 28px 0 16px;">Items Ordered</div>
                        @foreach ($order->order_details as $details)
                            <tr>
                                <td width="60" valign="middle">
                                    @if ($details->product->type == '0')
                                        <img src="{{ asset('uploads/images/low/' . $details->product->low_path) }}" width="46"
                                            height="46" style="border:1px solid #e8e2d9;background:#f7f4f0;">
                                    @else
                                        <img src="{{ asset('uploads/videos/thumbnails/' . $details->product->thumbnail_path) }}"
                                            width="46" height="46" style="border:1px solid #e8e2d9;background:#f7f4f0;">
                                    @endif
                                </td>

                                <td valign="middle"
                                    style="font-size:13.5px;font-weight:500;color:#121212;padding-left:10px;">
                                    {{ $details->product->name }}
                                </td>

                                <td valign="middle" align="right" width="80"
                                    style="font-size:14px;font-weight:600;color:#121212;">
                                    ${{ $details->product->price }}
                                </td>
                            </tr>
                        @endforeach


                        <!-- <div class="item-row" style="display: flex;
    align-items: center;
    gap: 14px;
    padding: 14px 0;
    border-bottom: 1px solid #e8e2d9;">
                        <div class="item-thumb" style="    width: 46px;
    height: 46px;
    background: #f7f4f0;
    border: 1px solid #e8e2d9;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;">
                            <img style="object-fit: contain;" src="imgs/header-logo.png" height="100%" width="100%"
                                alt="">
                        </div>
                        <div class="item-details" style="flex: 1;">
                            <p style="    font-size: 13.5px;
    font-weight: 500;
    color: #121212;
    margin-bottom: 2px;" class="item-name">product name</p>
                        </div>
                        <p style="font-size: 14px;
    font-weight: 600;
    color: #121212;
    text-align: right;
    white-space: nowrap;" class="item-price">$54.00</p>
                    </div>

                    <div class="item-row" style="display: flex;
    align-items: center;
    gap: 14px;
    padding: 14px 0;
    ">
                        <div class="item-thumb" style="    width: 46px;
    height: 46px;
    background: #f7f4f0;
    border: 1px solid #e8e2d9;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;">
                            <img style="object-fit: contain;" src="imgs/header-logo.png" height="100%" width="100%"
                                alt="">
                        </div>

                        <div class="item-details" style="flex: 1;">
                            <p style="    font-size: 13.5px;
    font-weight: 500;
    color: #121212;
    margin-bottom: 2px;" class="item-name">product name</p>
                        </div>
                        <p style="font-size: 14px;
    font-weight: 600;
    color: #121212;
    text-align: right;
    white-space: nowrap;" class="item-price">$19.00</p>
                    </div> -->
                    </div>
                </table>
                <!-- Summary -->
                <div class="summary-section" style="padding-bottom: 36px;">
                    <table width="100%" cellpadding="0" cellspacing="0" style="padding-bottom:36px;">

                        <tr>
                            <td colspan="2"
                                style="font-size:10px;font-weight:500;letter-spacing:1.5px;text-transform:uppercase;color:#737373;padding:28px 0 16px;">
                                Order Summary
                            </td>
                        </tr>

                        <tr>
                            <td style="font-size:13.5px;color:#737373;padding:7px 0;">
                                Subtotal
                            </td>
                            <td align="right" style="font-size:13.5px;color:#121212;padding:7px 0;">
                                ${{ $order->total_amount }}
                            </td>
                        </tr>

                        <tr>
                            <td style="font-size:13.5px;color:#737373;padding:7px 0;">
                                Shipping
                            </td>
                            <td align="right" style="font-size:13.5px;color:#121212;padding:7px 0;">
                                Free
                            </td>
                        </tr>

                        <tr>
                            <td style="font-size:13.5px;color:#737373;padding:7px 0;">
                                Tax (0%)
                            </td>
                            <td align="right" style="font-size:13.5px;color:#121212;padding:7px 0;">
                                $0.00
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2">
                                <div style="height:1px;background:#e8e2d9;margin:8px 0;"></div>
                            </td>
                        </tr>

                        <tr>
                            <td style="font-size:14px;font-weight:500;color:#121212;padding-top:8px;">
                                Total Charged
                            </td>
                            <td align="right" style="font-size:20px;font-weight:700;color:#ff8000;padding-top:8px;">
                                ${{ $order->total_amount }}
                            </td>
                        </tr>

                    </table>
                </div>
                <div class="cta-section">
                    <h2 style="    font-family: 'Playfair Display', serif;
    font-size: 20px;
    font-weight: 700;
    color: #121212;
    margin-bottom: 8px;">Track your shipment</h2>
                    <p style="    font-size: 13.5px;
    color: #737373;
    line-height: 1.65;
    margin-bottom: 22px;">Your order is being prepared. Once shipped, you can track your package in real time.
                        Estimated
                        delivery: <strong style="    color: #ff8000;
    font-weight: 500;">Mar 10 – 12, 2026</strong>.</p>
                    <a href="#" class="cta-btn" style="    display: inline-block;
    background: #ff8000;
    color: #fff;
    text-decoration: none;
    padding: 15px 40px;
    border-radius: 2px;
    font-size: 13px;
    font-weight: 600;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    column-gap: 5px;">

                        Track My Order
                        <svg viewBox="0 0 24 24" style="    width: 14px;
    height: 14px;
    stroke: #fff;
    fill: none;
    stroke-width: 2.2;
    stroke-linecap: round;
    stroke-linejoin: round;">
                            <line x1="5" y1="12" x2="19" y2="12" />
                            <polyline points="12 5 19 12 12 19" />
                        </svg>
                    </a>
                    <p style="    font-size: 13.5px;
                        margin-top: 14px;
    color: #737373;
    line-height: 1.65;
    margin-bottom: 22px;" class="fallback-link">
                        If the button doesn't work, copy and paste this link: <a href="#" style="color: #ff8000;
    font-weight: 500;">[TRACKING_LINK]</a>
                    </p>
                </div>
                <!-- Disclaimer -->
                <div class="disclaimer" style="padding-bottom: 30px;">
                    <p style="    font-size: 13px;
    color: #737373;
    line-height: 1.7;">
                        If you did not place this order, please disregard this email. No action will be taken without
                        your confirmation. Should you have any questions, please contact our support team at <a
                            href="mailto:support@example.com" style="color: #ff8000;
    font-weight: 500;">[support@example.com]</a>.
                    </p>
                </div>
                <!-- Sign-off -->
                <div class="signoff">
                    <p style="    font-size: 13px;
    color: #737373;
    margin-bottom: 6px;">Yours sincerely,</p>
                    <p class="name" style="    font-family: 'Playfair Display', serif;
    font-size: 20px;
    font-weight: 700;
    color: #121212;
    margin-bottom: 4px;">Gstockfootage Support Team</p>
                    <p class="sub" style="    font-size: 12px;
    color: #737373;">Gstockfootage</p>
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