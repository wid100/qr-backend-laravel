<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>New Card Order</title>
</head>

<body>
    <h2>📬 You have a new Smart Card order!</h2>

    <p><strong>Order Number:</strong> {{ $order->order_number }}</p>
    <p><strong>Customer Name:</strong> {{ $order->name }}</p>
    <p><strong>Email:</strong> {{ $order->email }}</p>
    <p><strong>Phone:</strong> {{ $order->phone }}</p>
    <p><strong>Country:</strong> {{ $order->country }}</p>
    <p><strong>Amount:</strong> {{ number_format($order->total_price, 2) }} {{ strtoupper($order->currency ?? 'USD') }}
    </p>
    <p><strong>Payment Method:</strong> {{ ucfirst($order->payment_method) }}</p>
    <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>

    <hr>
    <p>✅ Please check your admin dashboard for more details.</p>
</body>

</html>
