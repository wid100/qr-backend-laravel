<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body style="font-family: sans-serif; line-height: 1.6; color: #333;">
    @php
        $user = $subscription->user;
        $end = \Carbon\Carbon::parse($subscription->end_date);
        $renewUrl = rtrim(config('app.frontend_url', config('app.url')), '/') . '/pricing';
        $days = (int) $daysRemaining;

        if ($days === 30) {
            $timePhrase = '1 month';
        } elseif ($days === 1) {
            $timePhrase = '1 day';
        } else {
            $timePhrase = $days . ' days';
        }
    @endphp

    <p>Hello {{ $user->name ?? 'there' }},</p>

    @if ($days <= 1)
        <p>
            Your Smart Visiting Card subscription will expire on
            <strong>{{ $end->format('F j, Y') }}</strong>
            @if ($days === 1)
                (tomorrow).
            @else
                (today).
            @endif
            Please renew now to keep your card active.
        </p>
    @else
        <p>
            This is a reminder that your Smart Visiting Card subscription will expire on
            <strong>{{ $end->format('F j, Y') }}</strong>.
            You have <strong>{{ $timePhrase }}</strong> left — please renew in advance to avoid interruption.
        </p>
    @endif

    <p>
        <a href="{{ $renewUrl }}" style="display:inline-block;padding:10px 18px;background:#2563eb;color:#fff;text-decoration:none;border-radius:6px;">
            Renew subscription
        </a>
    </p>

    <p style="font-size: 12px; color: #666;">
        If you already renewed, you can ignore this message.
    </p>
</body>

</html>
