<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: black;
        }
        .invoice{
            font-size: 30px;
            color: black;
        }
        .black{
            color: black;
        }
        .invoice-box {
            width: 650px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            font-size: 16px;
            line-height: 24px;
            color: #555;
        }
        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
        }
        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }
        .invoice-box table tr td:nth-child(2) {
            text-align: right;
        }
        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }
        .invoice-box table tr.top table td.title {
            font-size: 45px;
            line-height: 45px;
            color: #333;
        }
        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }
        .invoice-box table tr.heading td {
            color: white;
            background: #000000;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }
        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }
        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }
        .invoice-box table tr.item.last td {
            border-bottom: none;
        }
        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }
        .logo-wrap {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .logo {
            max-width: 100%;
            max-height: 100%;
        }
        .remove-default{
            margin: 0;
            padding: 0;
            font-weight: bold;
            font-size: 20px;
        }

    </style>
</head>
<body>
    <div class="invoice-box">
        <table>
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
                                <div class="logo-wrap">
                                    <img class="logo" src="https://smartcardgenerator.net/img/logo.png" alt="Logo">
                                </div>
                            </td>
                            <td>
                                {{-- Invoice #: 53124<br> --}}
                                <strong class="invoice">Invoice</strong>
                                <br>
                                {{ $order->created_at ?? '' }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
                                <strong class="remove-default black">Invoice To</strong>
                                <br>
                                <strong>Name:</strong> <strong>{{ $order->name ?? '' }}</strong> <br>
                                <strong>Phone:</strong> {{ $order->phone ?? '' }} <br>
                                <strong>Email:</strong> {{ $order->email ?? '' }} <br>
                                <strong>Address:</strong> {{ $order->address ?? '' }} <br>

                            </td>
                            <td>
                                <strong class="black">Smart Card LTD</strong>
                                <br>
                                smartcardgenerator@gmail.com
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr class="heading">
                <td>Package  </td>
                <td> Price </td>
            </tr>
            <tr class="item">
                <td>
                    {{ $order->package->name ?? '' }}
                </td>
                <td>
                    {{ $order->amount ?? '' }}
                </td>
            </tr>

            <tfoot>
                <tr class="total">
                    <td></td>
                    <td>
                        <strong class="black">Total Amount:  {{ $order->amount?? '' }}</strong>
                    </td>
                </tr>
            </tfoot>

        </table>
        <br><br>
        <table>
            <tr>
                <td>
                    <strong class="black">Payment Info:</strong><br>
                    Payment Method: {{ $order->payment_method ?? '' }}<br>
                    Transaction Id: {{ $order->payment->transaction_id ?? '' }}<br>
                </td>
            </tr>
            <tr>
                <td>
                    <strong class="black">Thank You For Your Business</strong><br>
                    <em>Thank you for your purchase! We appreciate your business and are thrilled to have you as a customer.
                    If you have any questions, feel free to contact us at
                     <a href="https://mail.google.com/mail/?view=cm&to=support@gmail.com" target="_blank">support@gmail.com</a>
                      or <strong>01642872846</strong>.
                    </em><br><br>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
