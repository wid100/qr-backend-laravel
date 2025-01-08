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
            background: #eee;
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

    </style>
</head>
<body>
    <div class="invoice-box">
        <table>
            <div class="logo-wrap">
                <img class="logo" src="https://smartcardgenerator.net/img/logo.png" alt="Logo">
            </div>
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="title">
                                Invoice
                            </td>
                            <td>
                                {{-- Invoice #: 53124<br> --}}
                                Date: {{ $order->created_at ?? '' }}
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
                                Maruf Billah<br>
                                Janata Housing<br>
                                House: 50/51, Road: 3, 1207 Ring Road, Dhaka 1207
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr class="heading">
                <td>
                    Package
                </td>
                <td>
                    Price
                </td>
            </tr>
            <tr class="item">
                <td>
                    {{ $order->package->name ?? '' }}
                </td>
                <td>
                    {{ $order->amount ?? '' }}
                </td>
            </tr>

        </table>
        <br><br>
        <table>
            <tr>
                <td>
                    <strong>Thank You For Your Business</strong><br>
                    <em>Terms & Conditions: Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text.</em><br><br>
                    <strong>Payment Info:</strong><br>
                    Payment Method: {{ $order->payment_method ?? '' }}<br>
                    Transaction Id: {{ $order->payment->transaction_id ?? '' }}<br>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
