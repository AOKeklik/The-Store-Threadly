<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Password Reset</title>
</head>
<body style="font-family:Arial,sans-serif;background:#f5f5f5;padding:20px;margin:0;">
    <div style="max-width:600px;margin:0 auto;background:#fff;border:1px solid #e0e0e0;border-radius:8px;padding:30px;box-shadow:0 2px 10px rgba(0,0,0,0.05);">
        <h2 style="color:#d32f2f;margin-top:0;font-size:24px;">Password Reset Request</h2>
        
        <p>Hello,</p>
        
        <p>We received a request to reset your password. Click the button below to proceed:</p>
        
        <div style="text-align:center;margin:25px 0;">
            <a href="{{ $resetUrl }}" style="background:#d32f2f;color:#fff;text-decoration:none;padding:12px 24px;border-radius:4px;font-weight:bold;display:inline-block;">Reset Password</a>
        </div>
        
        <p style="color:#757575;">If you didn't request this, please ignore this email. The link expires in 60 minutes.</p>
        
        <hr style="border:none;border-top:1px solid #eee;margin:20px 0;">
        
        <p><strong>Email:</strong> <span style="color:#d32f2f;">{{ $email }}</span></p>
        <p style="word-break:break-all;"><strong>Link:</strong> <a href="{{ $resetUrl }}" style="color:#d32f2f;text-decoration:underline;">{{ $resetUrl }}</a></p>
        
        <p style="margin-top:25px;color:#9e9e9e;font-size:14px;">
            Best regards,<br>
            <strong style="color:#d32f2f;">{{ setting('site_name') }}</strong> Team
        </p>
    </div>
</body>
</html>