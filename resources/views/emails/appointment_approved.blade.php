<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Appointment Approved</title>
</head>

<body>
    <h1>Appointment Approved</h1>
    <p>Dear {{ $appointment->first_name }} {{ $appointment->last_name }},</p>

    <p>Your appointment has been approved. Here are the details:</p>
    <ul>
        <li><strong>Appointment ID:</strong> {{ $appointment->id }}</li>
        <li><strong>Date:</strong> {{ $appointment->date }}</li>
        <li><strong>Time:</strong> {{ implode(', ', json_decode($appointment->time_slot)) }}</li>
        <li><strong>Location:</strong> {{ $appointment->location ?? 'N/A' }}</li>
        <li><strong>Meeting Link:</strong> {{ $appointment->meeting_link ?? 'N/A' }}</li>
        <li><strong>Message:</strong> {{ $appointment->approval_message ?? 'No message' }}</li>
    </ul>

    <p>Thank you!</p>
</body>

</html>
