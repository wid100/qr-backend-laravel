<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Appointment Declined</title>

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
                        style="max-width: 600px; width: 100%; border-radius: 5px; padding: 30px 50px 50px 50px;"
                        align="center">
                        <tr>
                            <td align="center" style="margin-bottom: 30px; width: 100%">
                                <div>

                                    <img src="https://i.postimg.cc/5twkrtKp/decline.png"
                                        style="width: 70px; margin-bottom: 0px;" alt="">
                                    <h1
                                        style="
                        font-family: sans-serif;
                        margin-top: 10px;
                        margin-bottom: 5px;
                        font-weight: 700;
                        font-size: 20px;
                        color: #FFB317;
                      ">
                                        Appointment Declined
                                    </h1>
                                    <p
                                        style="
                        color: #FFB317;
                        font-size: 12px;
                        font-weight: 500;
                        line-height: 150%;
                        font-family: sans-serif;
                      ">
                                        We regret to inform you that your appointment with ID #{{ $appointmentId }} has
                                        been declined.</p>

                                    @if ($declineMessage)
                                        <p>Message: {{ $declineMessage }}</p>
                                    @endif

                                    <p>Thank you for your understanding.</p>


                                </div>
                            </td>
                        </tr>
                        <!-- The 50% width on each cell -->

                        <tr>
                            <td align="center">
                                <a href="https://smartcardgenerator.net/"
                                    style="width: 100px; background: #FFB317; text-decoration: none; padding: 7px; border-radius: 3px; border: none; color: white; font-family: sans-serif; font-weight: 700;">Back</a>
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
