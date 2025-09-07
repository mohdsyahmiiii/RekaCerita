<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Email Verification</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #007bff; color: white; padding: 20px; text-align: center; }
        .content { padding: 20px; background: #f8f9fa; }
        .button { display: inline-block; padding: 12px 24px; background: #007bff; color: white; text-decoration: none; border-radius: 5px; }
        .footer { text-align: center; padding: 20px; color: #666; font-size: 14px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Email Verification</h1>
        </div>
        
        <div class="content">
            <h2>Hello {{ $user->name }}!</h2>
            
            <p>Thank you for registering with our blog system. To complete your registration, please click the button below to verify your email address:</p>
            
            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ url('/verify-email/' . $user->email_verification_token) }}" class="button">
                    Verify Email Address
                </a>
            </div>
            
            <p>If the button above doesn't work, you can copy and paste this link into your browser:</p>
            <p style="word-break: break-all; color: #007bff;">
                {{ url('/verify-email/' . $user->email_verification_token) }}
            </p>
            
            <p>This verification link will expire in 24 hours.</p>
            
            <p>If you didn't create an account, no further action is required.</p>
        </div>
        
        <div class="footer">
            <p>&copy; {{ date('Y') }} RekaCerita. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
