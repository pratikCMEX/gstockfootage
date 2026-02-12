<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>New Contact Message</title>
</head>

<body style="font-family: Arial; background:#f4f4f4; padding:20px;">

    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center">

                <table width="600" style="background:#ffffff; border-radius:8px; padding:20px;">

                    <tr>
                        <td style="background:#ff7a00; color:white; padding:15px; border-radius:8px 8px 0 0;">
                            <h2>📩 New Contact Message</h2>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:20px;">
                            <p>You received a new message from the Contact Us form.</p>

                            <table width="100%" cellpadding="8" cellspacing="0" style="border-collapse:collapse;">
                                <tr>
                                    <td style="background:#f8f8f8;"><strong>Name</strong></td>
                                    <td>{{ $contact->name }}</td>
                                </tr>

                                <tr>
                                    <td style="background:#f8f8f8;"><strong>Email</strong></td>
                                    <td>{{ $contact->email }}</td>
                                </tr>

                                <tr>
                                    <td style="background:#f8f8f8;"><strong>Subject</strong></td>
                                    <td>{{ $contact->subject }}</td>
                                </tr>

                                <tr>
                                    <td style="background:#f8f8f8;"><strong>Message</strong></td>
                                    <td>{{ $contact->message }}</td>
                                </tr>
                            </table>

                            <br>

                            <p style="color:#888;font-size:13px;">
                                This email was sent from your website contact form.
                            </p>
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>

</html>
