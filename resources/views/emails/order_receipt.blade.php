<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Order Confirmation</title>
</head>

<body style="margin:0; padding:0; background:#f4f6f9; font-family:Arial, Helvetica, sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" style="padding:30px 0;">
        <tr>
            <td align="center">

                <table width="600" cellpadding="0" cellspacing="0"
                    style="background:#ffffff; border-radius:10px; overflow:hidden; box-shadow:0 4px 15px rgba(0,0,0,0.05);">

                    <!-- Header -->
                    <tr>
                        <td
                            style="background:linear-gradient(135deg,#ff7a00,#ff9f43); padding:25px; text-align:center; color:#ffffff;">
                            <h2 style="margin:0;">🎉 Payment Successful!</h2>
                            <p style="margin:8px 0 0 0; font-size:14px;">
                                Thank you for your purchase
                            </p>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding:30px;">

                            <p style="font-size:15px; color:#333;">
                                Hi <strong>{{ $order->email }}</strong>,
                            </p>

                            <p style="font-size:14px; color:#555; line-height:1.6;">
                                Your order has been successfully processed. Below are your order details.
                            </p>

                            <!-- Order Info Box -->
                            <table width="100%" cellpadding="10" cellspacing="0"
                                style="background:#f8f9fb; border-radius:6px; margin:20px 0;">
                                <tr>
                                    <td><strong>Order Number:</strong></td>
                                    <td align="right">{{ $order->order_number }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Total Paid:</strong></td>
                                    <td align="right">${{ number_format($order->total_amount, 2) }}</td>
                                </tr>
                            </table>

                            <!-- Order Items -->
                            <h3 style="margin-bottom:10px; color:#333;">Order Items</h3>

                            <table width="100%" cellpadding="8" cellspacing="0"
                                style="border-collapse:collapse; font-size:14px;">
                                <thead>
                                    <tr style="background:#ff7a00; color:#ffffff;">
                                        <th align="left">Product</th>
                                        <th align="center">Qty</th>
                                        <th align="right">Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order->order_details as $item)
                                        <tr style="border-bottom:1px solid #eee;">
                                            <td>{{ $item->product->name ?? 'Product' }}</td>
                                            <td align="center">{{ $item->qty }}</td>
                                            <td align="right">${{ number_format($item->price, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <!-- CTA Button -->
                            <div style="text-align:center; margin:30px 0;">
                                <a href="{{ url('/') }}"
                                    style="background:#ff7a00; color:#ffffff; padding:12px 25px; text-decoration:none; border-radius:5px; font-size:14px;">
                                    Go to Website
                                </a>
                            </div>

                            <p style="font-size:13px; color:#888; text-align:center;">
                                If you have any questions, feel free to contact us anytime.
                            </p>

                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background:#f4f6f9; padding:20px; text-align:center; font-size:12px; color:#999;">
                            © {{ date('Y') }} Your Website Name. All rights reserved.
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>

</html>
