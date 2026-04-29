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
    @endphp

    <p>Hello {{ $user->name ?? 'there' }},</p>

    @if ($variant === 'urgent')
        <p>
            Your Smart Visiting Card subscription will expire on <strong>{{ $end->format('F j, Y') }}</strong>
            ({{ $end->format('g:i A') }}).
            Please renew to keep your card active.
        </p>
    @else
        <p>
            This is a reminder that your Smart Visiting Card subscription will expire on
            <strong>{{ $end->format('F j, Y') }}</strong>.
            You still have a few days — please renew in advance to avoid interruption.
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
