<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>New Quote Request</title>
</head>

<body style="font-family:Arial;background:#f4f4f4;padding:30px;">

    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center">
                <table width="650" style="background:#ffffff;border-radius:10px;overflow:hidden">
                    <tr>
                        <td style="background:#ff9800;color:#000;padding:18px;">
                            <h2>📩 New Quote Request Received</h2>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:25px">

                            <p>A new user has submitted a <strong>Request Quote</strong> form.</p>

                            <table width="100%" cellpadding="8" cellspacing="0" style="border-collapse:collapse">

                                <tr>
                                    <td width="40%" style="background:#f7f7f7"><strong>First Name</strong></td>
                                    <td>{{ $quote->first_name }}</td>
                                </tr>

                                <tr>
                                    <td style="background:#f7f7f7"><strong>Last Name</strong></td>
                                    <td>{{ $quote->last_name }}</td>
                                </tr>

                                <tr>
                                    <td style="background:#f7f7f7"><strong>Phone</strong></td>
                                    <td>{{ $quote->phone }}</td>
                                </tr>

                                <tr>
                                    <td style="background:#f7f7f7"><strong>Email</strong></td>
                                    <td>{{ $quote->email }}</td>
                                </tr>

                                <tr>
                                    <td style="background:#f7f7f7"><strong>Company</strong></td>
                                    <td>{{ $quote->company }}</td>
                                </tr>

                                <tr>
                                    <td style="background:#f7f7f7"><strong>Job Role</strong></td>
                                    <td>{{ $quote->job_role }}</td>
                                </tr>

                                <tr>
                                    <td style="background:#f7f7f7"><strong>Job Function</strong></td>
                                    <td>{{ $quote->job_function }}</td>
                                </tr>

                                <tr>
                                    <td style="background:#f7f7f7"><strong>Company Size</strong></td>
                                    <td>{{ $quote->company_size }}</td>
                                </tr>

                                <tr>
                                    <td style="background:#f7f7f7"><strong>Country</strong></td>
                                    <td>{{ $quote->country }}</td>
                                </tr>

                                <tr>
                                    <td style="background:#f7f7f7"><strong>State</strong></td>
                                    <td>{{ $quote->state ?? '-' }}</td>
                                </tr>

                                <tr>
                                    <td style="background:#f7f7f7"><strong>Product Interest</strong></td>
                                    <td>{{ $quote->product_interest }}</td>
                                </tr>

                                <tr>
                                    <td style="background:#f7f7f7"><strong>Newsletter</strong></td>
                                    <td>
                                        {{ $quote->newsletter ? 'Yes, subscribed' : 'No' }}
                                    </td>
                                </tr>

                            </table>

                            <br>

                            <p style="color:#888;font-size:13px">
                                This email was automatically generated from the website Request Quote form.
                            </p>

                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
