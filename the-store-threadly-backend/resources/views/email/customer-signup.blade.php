<!DOCTYPE html>
<html>
<body style="font-family: Arial, sans-serif; background-color: #f8f9fa; padding: 20px; margin: 0;">
    <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border: 1px solid #dc3545; border-radius: 8px; padding: 25px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
        <h2 style="color: #dc3545; margin-top: 0; font-size: 24px;">Complete Your Registration</h2>
        
        <p style="margin-bottom: 20px;">Hello,</p>
        
        <p style="margin-bottom: 20px;">Thank you for signing up! Please verify your email address by clicking the button below:</p>
        
        <div style="text-align: center; margin: 25px 0;">
            <a href="{{ $confirmationUrl }}" style="background-color: #dc3545; color: white; text-decoration: none; padding: 12px 24px; border-radius: 4px; font-weight: bold; display: inline-block;">Verify Email</a>
        </div>
        
        <p style="margin-bottom: 20px; color: #6c757d;">If you didn't create this account, you can safely ignore this email.</p>
        
        <hr style="border: none; border-top: 1px solid #f5c2c7; margin: 25px 0;">
        
        <p style="margin-bottom: 5px;"><strong>Email:</strong> <span style="color: #dc3545;">{{ $email }}</span></p>
        <p style="word-break: break-all;"><strong>Link:</strong> <a href="{{ $confirmationUrl }}" style="color: #dc3545; text-decoration: underline;">{{ $confirmationUrl }}</a></p>
        
        <p style="margin-top: 25px; color: #6c757d; font-size: 14px;">
            Regards,<br>
            <strong style="color: #dc3545;">{{ config('app.name') }}</strong> Team
        </p>
    </div>
</body>
</html>
