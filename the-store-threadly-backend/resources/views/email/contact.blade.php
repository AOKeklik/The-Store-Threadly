<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Contact Message</title>
</head>
<body style="font-family: Arial, sans-serif; color: #333; line-height: 1.6; background-color: #f9f9f9; padding: 20px; margin: 0;">
    <div style="max-width: 600px; margin: 0 auto; background-color: #fff; border: 1px solid #e1e1e1; padding: 30px; border-radius: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
        <h2 style="color: #2c3e50; margin-top: 0; border-bottom: 1px solid #eee; padding-bottom: 10px;">New Contact Form Submission</h2>

        <p style="margin-bottom: 20px;">You have received a new message:</p>

        <table style="width: 100%; border-collapse: collapse; margin-bottom: 25px;">
            <tr>
                <td style="padding: 10px; border: 1px solid #eee; width: 30%;"><strong>Name:</strong></td>
                <td style="padding: 10px; border: 1px solid #eee;">{{ $formData['name'] ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td style="padding: 10px; border: 1px solid #eee;"><strong>Email:</strong></td>
                <td style="padding: 10px; border: 1px solid #eee;">{{ $formData['email'] ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td style="padding: 10px; border: 1px solid #eee;"><strong>Subject:</strong></td>
                <td style="padding: 10px; border: 1px solid #eee;">{{ $formData['subject'] ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td style="padding: 10px; border: 1px solid #eee; vertical-align: top;"><strong>Message:</strong></td>
                <td style="padding: 10px; border: 1px solid #eee;">{!! nl2br(e($formData['message'] ?? 'N/A')) !!}</td>
            </tr>
        </table>

        <div style="background-color: #f8f9fa; padding: 15px; border-radius: 4px; font-size: 14px; color: #666;">
            <p style="margin: 0;">This message was sent via the contact form on {{ date('Y-m-d H:i') }}.</p>
        </div>

        <p style="margin-top: 25px; color: #777; font-size: 14px;">
            Best regards,<br>
            <strong>{{ config('app.name') }}</strong> Team
        </p>
    </div>
</body>
</html>