@php 
    $userName = $email_data['name'] ?? 'there';
    $appUrl = config('app.url');
    $token = $email_data['token'] ?? '';
    $resetUrl = $appUrl . 'password/reset/' . $token;
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset - TravaiQ</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, Helvetica, sans-serif; background-color: #f8f9fa;">
    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="background-color: #f8f9fa;">
        <tr>
            <td align="center" style="padding: 20px 0;">
                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="600" style="background-color: #ffffff; max-width: 600px;">
                    <tr>
                        <td align="center" style="background: linear-gradient(90deg, #4f46e5, #0ea5e9); padding: 40px 24px;">
                            <h1 style="color: #fff; font-size: 28px; margin: 16px 0 4px; font-weight: 700;">Hello {{ $userName }} 👋</h1>
                            <h3 style="color: #e0f2fe; font-size: 16px; margin: 0;">Password Reset Request</h3>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 30px;">
                            <p style="margin: 0 0 10px 0; color: #7c3aed; font-size: 16px;">We received a request to reset your password for your <strong>TravaiQ</strong> account.</p>
                            <p style="margin: 0 0 20px 0; font-size: 16px; color: #333333;">If you did not request a password reset, please ignore this email.</p>
                            <p style="margin: 0 0 30px 0; font-size: 16px; color: #333333;">To reset your password, click the button below:</p>
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin: 30px 0;">
                                <tr>
                                    <td align="center">
                                        <a href="{{ $resetUrl }}" style="display: inline-block; background: linear-gradient(ede9fe, #ede9fe 0%, #7c3aed 100%); background-color: #7c3aed; color: #ffffff; padding: 15px 30px; text-decoration: none; border-radius: 25px; font-size: 16px; font-weight: bold;">Reset Password</a>
                                    </td>
                                </tr>
                            </table>
                            <p style="margin: 0 0 10px 0; color: #666666; font-size: 14px;">If the button above does not work, copy and paste the following link into your browser:</p>
                            <p style="margin: 0 0 30px 0; color: #7c3aed; font-size: 14px; word-break: break-all;">{{ $resetUrl }}</p>
                            <p style="margin: 30px 0; color: #333333; line-height: 1.6;">Thank you for using <strong>TravaiQ</strong>!<br>Stay secure and travel smart.</p>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" style="padding: 24px; color: #888; font-size: 13px;">
                            &copy; {{ date('Y') }} TravaiQ, All rights reserved. <br>
                            <span style="color: #bbb;">Plan better. Explore smarter. Travel more.</span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html> 