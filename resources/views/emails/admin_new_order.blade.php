<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>New Card Order</title>
</head>

<body style="margin: 0; padding: 0">
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tbody>
            <tr>
                <td width="100%" align="center" valign="top" bgcolor="#eeeeee" height="20"></td>
            </tr>
            <tr>
                <td bgcolor="#eeeeee" align="center" style="padding: 0px 15px 0px 15px">
                    <table border="0" bgcolor="#ffffff" cellpadding="0" cellspacing="0"
                        style="
                                max-width: 509px;
                                width: 100%;
                                border-radius: 5px;
                                padding: 30px 50px 50px 50px;
                            "
                        align="center">
                        <tr>
                            <td align="center" style="margin-bottom: 30px; width: 100%">
                                <div
                                    style="
                                            padding: 0px 20px 15px 20px;
                                            border-radius: 5px;
                                        ">
                                    <h1
                                        style="
                                                font-family: sans-serif;
                                                margin-top: 10px;
                                                margin-bottom: 5px;
                                                font-weight: 700;
                                                font-size: 20px;
                                                color: #ffb317;
                                            ">
                                        Congrats, you have a new Smart Card
                                        order!
                                    </h1>
                                </div>
                            </td>
                        </tr>
                        <!-- The 50% width on each cell -->
                        <tr>
                            <td>
                                <table style="width: 100%" border="0" cellpadding="0" cellspacing="0"
                                    width="100%">
                                    <tbody>
                                        <tr>
                                            <td
                                                style="
                                                        padding-bottom: 15px;
                                                        padding-top: 10px;
                                                    ">
                                                <p
                                                    style="
                                                            margin: 0;
                                                            font-size: 14px;
                                                            font-family: sans-serif;
                                                            color: #424040;
                                                            padding: 0;
                                                        ">
                                                    <strong>Order
                                                        Number:</strong>
                                                    {{ $order->order_number }}
                                                </p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding-bottom: 15px">
                                                <p
                                                    style="
                                                            margin: 0;
                                                            font-size: 14px;
                                                            font-family: sans-serif;
                                                            color: #424040;
                                                            padding: 0;
                                                        ">
                                                    <strong>Customer
                                                        Name:</strong>
                                                    {{ $order->name }}
                                                </p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding-bottom: 15px">
                                                <p
                                                    style="
                                                            margin: 0;
                                                            font-size: 14px;
                                                            font-family: sans-serif;
                                                            color: #424040;
                                                            padding: 0;
                                                        ">
                                                    <strong>Email:</strong>
                                                    {{ $order->email }}
                                                </p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding-bottom: 15px">
                                                <p
                                                    style="
                                                            margin: 0;
                                                            font-size: 14px;
                                                            font-family: sans-serif;
                                                            color: #424040;
                                                            padding: 0;
                                                        ">
                                                    <strong> Phone:</strong>
                                                    {{ $order->phone }}
                                                </p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding-bottom: 15px">
                                                <p
                                                    style="
                                                            margin: 0;
                                                            font-size: 14px;
                                                            font-family: sans-serif;
                                                            color: #424040;
                                                            padding: 0;
                                                        ">
                                                    <strong>Country:</strong>
                                                    {{ $order->country }}
                                                </p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding-bottom: 15px">
                                                <p
                                                    style="
                                                            margin: 0;
                                                            font-size: 14px;
                                                            font-family: sans-serif;
                                                            color: #424040;
                                                            padding: 0;
                                                        ">
                                                    <strong>Amount:</strong>
                                                    {{ number_format($order->total_price, 2) }}
                                                    {{ strtoupper($order->currency ?? 'USD') }}
                                                </p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding-bottom: 15px">
                                                <p
                                                    style="
                                                            margin: 0;
                                                            font-size: 14px;
                                                            font-family: sans-serif;
                                                            color: #424040;
                                                            padding: 0;
                                                        ">
                                                    <strong>Payment
                                                        Method:</strong>
                                                    {{ ucfirst($order->payment_method) }}
                                                </p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding-bottom: 15px">
                                                <p
                                                    style="
                                                            margin: 0;
                                                            font-size: 14px;
                                                            font-family: sans-serif;
                                                            color: #424040;
                                                            padding: 0;
                                                        ">
                                                    <strong>Status:</strong>
                                                    {{ ucfirst($order->status) }}
                                                </p>
                                            </td>
                                        </tr>
                                        <hr />
                                        <tr>
                                            <td style="padding-bottom: 10px">
                                                <p
                                                    style="
                                                            margin: 0;
                                                            font-size: 14px;
                                                            font-family: sans-serif;
                                                            color: #000000;
                                                            padding: 0;
                                                        ">
                                                    ✅ Please check your
                                                    admin dashboard for more
                                                    details.
                                                </p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td align="center">
                                <p
                                    style="
                                            margin-bottom: 10px;
                                            font-size: 14px;
                                            font-family: sans-serif;
                                            color: #898989;
                                            padding: 0;
                                            text-align: start;
                                        ">
                                    Message:
                                </p>
                                <p
                                    style="
                                            margin: 0;
                                            font-size: 14px;
                                            font-family: sans-serif;
                                            color: #555555;
                                            padding: 0;
                                        ">
                                    {{ $appointment->approval_message ??
                                        'No
                                                                            message' }}
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td align="center" style="padding-top: 40px">
                                <a href="https://smartcardgenerator.net/" style="width: 100px">
                                    <img style="width: 150px" src="https://smartcardgenerator.net/img/logo.png"
                                        alt="" />
                                </a>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td bgcolor="#eeeeee" align="center" style="padding: 20px 0px"></td>
            </tr>
        </tbody>
    </table>
</body>

</html>
