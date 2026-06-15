<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body style="font-family: sans-serif; line-height: 1.6; color: #333;">
    <p>Hello {{ $user->name ?? 'there' }},</p>

    <p>
        We received a request to reset your {{ $appLabel }} password.
        Use the code below on the reset password page:
    </p>

    <p style="font-size: 32px; font-weight: bold; letter-spacing: 8px; margin: 24px 0;">
        {{ $code }}
    </p>

    <p>
        This code expires in <strong>{{ $expiresMinutes }} minutes</strong>.
        If you did not request a password reset, you can ignore this email.
    </p>
</body>

</html>
