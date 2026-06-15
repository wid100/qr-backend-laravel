<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body style="font-family: sans-serif; line-height: 1.6; color: #333;">
    <p>Hello {{ $user->name ?? 'there' }},</p>

    <p>
        Thank you for signing up with {{ $appLabel }}.
        Use the verification code below to confirm your email address:
    </p>

    <p style="font-size: 32px; font-weight: bold; letter-spacing: 8px; margin: 24px 0;">
        {{ $code }}
    </p>

    <p>
        This code expires in <strong>{{ $expiresMinutes }} minutes</strong>.
        Enter it on the verification page in your app — no link click required.
    </p>

    <p style="font-size: 12px; color: #666;">
        If you did not create an account, you can ignore this email.
    </p>
</body>

</html>
