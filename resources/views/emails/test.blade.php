<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Email</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }

        .content {
            background: #f9f9f9;
            padding: 30px;
            border-radius: 0 0 10px 10px;
        }

        .message {
            background: white;
            padding: 20px;
            border-radius: 5px;
            margin: 20px 0;
            border-left: 4px solid #667eea;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            color: #666;
            font-size: 14px;
        }

        .success-icon {
            font-size: 48px;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="success-icon">✅</div>
        <h1>Email Configuration Test</h1>
        <p>HOM International</p>
    </div>

    <div class="content">
        <h2>Email Test Successful!</h2>

        <div class="message">
            <p><strong>Message:</strong></p>
            <p>{{ $testMessage }}</p>
        </div>

        <p>If you're reading this email, it means your mail configuration is working correctly!</p>

        <h3>Configuration Details:</h3>
        <ul>
            <li><strong>From:</strong> hr@hom-intl.com</li>
            <li><strong>Mail Server:</strong> mail.hom-intl.com</li>
            <li><strong>Port:</strong> 587 (TLS)</li>
            <li><strong>Time Sent:</strong> {{ now()->format('Y-m-d H:i:s') }}</li>
        </ul>

        <p>Your email system is now ready to send notifications to applicants and administrators.</p>
    </div>

    <div class="footer">
        <p>&copy; {{ date('Y') }} HOM International. All rights reserved.</p>
        <p>This is an automated test email.</p>
    </div>
</body>

</html>
