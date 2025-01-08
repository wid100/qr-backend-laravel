<!DOCTYPE html>
<html>
<head>
    <title>Your Invoice</title>
</head>
<body>
    <p>Dear <strong>{{ $order->name ?? '' }}</strong>,</p>
    <p>Thank you for choosing WID and purchasing your package <strong>{{ $order->package->name ?? '' }}</strong>. We appreciate your trust in our products and are committed to providing you with the best experience.</p>

    <p>If you have any queries, feel free to reach out. We’re always happy to help!</p>

    <p>Best regards,</p>
    <strong>Women in digital</strong>
</body>
</html>
