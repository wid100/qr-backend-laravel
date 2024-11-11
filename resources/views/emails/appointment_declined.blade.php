<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Declined</title>
</head>

<body>
    <h1>Appointment Declined</h1>
    <p>We regret to inform you that your appointment with ID #{{ $appointmentId }} has been declined.</p>

    @if ($declineMessage)
        <p>Message: {{ $declineMessage }}</p>
    @endif

    <p>Thank you for your understanding.</p>
</body>

</html>
