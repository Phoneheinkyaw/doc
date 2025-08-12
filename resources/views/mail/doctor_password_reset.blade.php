<!DOCTYPE html>
<html>
<head>
    <title>Password Reset Request</title>
</head>
<body>
    <p>Hello,</p>
    <p>We received a request to reset the password for your account associated with {{ $email }}.</p>
    <p>You can reset your password by clicking the link below:</p>
    <p><a href="{{ $resetUrl }}">Reset Password</a></p>
    <p>If you did not request a password reset, please ignore this email.</p>
    <p>Thank you!</p>
</body>
</html>
