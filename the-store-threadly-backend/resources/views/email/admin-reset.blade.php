<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Password Reset</title>
</head>
<body style="font-family: Arial, sans-serif; color: #333; line-height: 1.6; background-color: #f9f9f9; padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto; background-color: #fff; border: 1px solid #ddd; padding: 30px; border-radius: 8px;">
        <h2 style="color: #2c3e50;">Password Reset Request</h2>

        <p>Hello Admin,</p>

        <p>We received a request to reset your account password. If you initiated this request, please click the button below to reset your password:</p>

        <p style="text-align: center; margin: 30px 0;">
            <a href="{{ $resetUrl }}" style="background-color: #3498db; color: white; padding: 12px 20px; text-decoration: none; border-radius: 4px;">Reset Password</a>
        </p>

        <p>If you did not request a password reset, you can safely ignore this email. This link will expire in 60 minutes.</p>

        <hr>

        <p><strong>Email:</strong> {{ $email }}</p>
        <p><strong>Reset Link:</strong> <a style="white-space: pre-wrap; word-break: break-all;" href="{{ $resetUrl }}">{!! $resetUrl !!}</a></p>

        <p style="margin-top: 30px;">Regards,<br><strong>{{ setting('site_name') }}</strong> Team</p>
    </div>
</body>
</html>