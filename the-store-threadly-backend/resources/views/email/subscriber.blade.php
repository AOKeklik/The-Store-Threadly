<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Subscriber Info</title>
</head>
<body style="font-family: Arial, sans-serif; color: #333; line-height: 1.6; background-color: #f9f9f9; padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto; background-color: #fff; border: 1px solid #ddd; padding: 30px; border-radius: 8px;">
        <h2 style="color: #2c3e50;">New Subscriber Notification</h2>

        <p>Hello Admin,</p>

        <p>You have a new subscriber. Below are the details:</p>

        <table style="width: 100%; margin: 20px 0; border-collapse: collapse;">
            <tr>
                <td style="padding: 8px; border: 1px solid #eee;"><strong>Email:</strong></td>
                <td style="padding: 8px; border: 1px solid #eee;">{{ $formData['email'] ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td style="padding: 8px; border: 1px solid #eee;"><strong>IP Address:</strong></td>
                <td style="padding: 8px; border: 1px solid #eee;">{{ $formData['ip'] ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td style="padding: 8px; border: 1px solid #eee;"><strong>Status:</strong></td>
                <td style="padding: 8px; border: 1px solid #eee;">{{ $formData['status'] ? 'Active' : 'Inactive' }}</td>
            </tr>
        </table>

        <p>This subscriber was added from your website. No further action is required unless follow-up is needed.</p>

        <hr style="margin: 30px 0;">

        <p style="margin-top: 30px;">Best regards,<br><strong>{{ setting('site_name') }}</strong> Team</p>
    </div>
</body>
</html>
