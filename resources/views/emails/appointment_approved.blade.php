

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Appointment Approved</title>

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
                        style="max-width: 509px; width: 100%; border-radius: 5px; padding: 30px 50px 50px 50px;"
                        align="center">
                        <tr>
                            <td align="center" style="margin-bottom: 30px; width: 100%">
                                <div style="padding: 20px 40px 30px 40px; border-radius: 5px">
                                    <img style="text-align: center; width: 80px"
                                        src="https://i.postimg.cc/TwqpqP6h/image-81.png" alt="Bits of Dev" />
                                    <h1
                                        style="
                        font-family: sans-serif;
                        margin-top: 10px;
                        margin-bottom: 5px;
                        font-weight: 700;
                        font-size: 20px;
                        color: #FFB317;
                      ">
                                        Congratulations
                                    </h1>
                                    <span
                                        style="
                        color: #FFB317;
                        font-size: 12px;
                        font-weight: 500;
                        font-family: sans-serif;
                      ">Appointment
                                        ID: {{ $appointment->id }}</span>
                                </div>
                            </td>
                        </tr>
                        <!-- The 50% width on each cell -->
                        <tr>
                            <td>
                                <table
                                    style="width: 100%; margin-bottom: 25px; border-bottom: 1px solid #D9D9D9; padding-bottom: 20px;"
                                    border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <tbody>
                                        <tr>
                                            <td style="padding-bottom: 10px;">
                                                <p
                                                    style="margin: 0; font-size: 14px; font-family: sans-serif; color: #898989; padding: 0">
                                                    Name:
                                                </p>
                                            </td>

                                            <td style="text-align: right;padding-bottom: 10px;">
                                                <p
                                                    style="margin: 0; font-size: 14px; font-family: sans-serif; color: #555555; padding: 0">
                                                    {{ $appointment->first_name }} {{ $appointment->last_name }}
                                                </p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding-bottom: 10px;">
                                                <p
                                                    style="margin: 0; font-size: 14px; font-family: sans-serif; color: #898989; padding: 0">
                                                    Date:
                                                </p>
                                            </td>

                                            <td style="text-align: right; padding-bottom: 10px;">
                                                <p
                                                    style="margin: 0; font-size: 14px; font-family: sans-serif; color: #555555; padding: 0">
                                                    {{ $appointment->date }}
                                                </p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding-bottom: 10px;">
                                                <p
                                                    style="margin: 0; font-size: 14px; font-family: sans-serif; color: #898989; padding: 0">
                                                    Time:
                                                </p>
                                            </td>

                                            <td style="text-align: right; padding-bottom: 10px;">
                                                <p
                                                    style="margin: 0; font-size: 14px; font-family: sans-serif; color: #555555; padding: 0">
                                                    {{ implode(', ', json_decode($appointment->time_slot)) }}
                                                </p>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td style="padding-bottom: 10px;">
                                                <p
                                                    style="margin: 0; font-size: 14px; font-family: sans-serif; color: #898989; padding: 0">
                                                    Location:
                                                </p>
                                            </td>

                                            <td style="text-align: right; padding-bottom: 10px;">
                                                <p
                                                    style="margin: 0; font-size: 14px; font-family: sans-serif; color: #555555; padding: 0">
                                                    {{ $appointment->location ?? 'N/A' }}
                                                </p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding-bottom: 10px;">
                                                <p
                                                    style="margin: 0; font-size: 14px; font-family: sans-serif; color: #898989; padding: 0">
                                                   Meeting Link:
                                                </p>
                                            </td>

                                            <td style="text-align: right; padding-bottom: 10px;">
                                                <p
                                                    style="margin: 0; font-size: 14px; font-family: sans-serif; color: #555555; padding: 0">
                                                    {{ $appointment->meeting_link ?? 'N/A' }}
                                                </p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding-bottom: 10px;">
                                                <p
                                                    style="margin: 0; font-size: 14px; font-family: sans-serif; color: #898989; padding: 0">
                                                    Message:
                                                </p>
                                            </td>

                                            <td style="text-align: right; padding-bottom: 10px;">
                                                <p
                                                    style="margin: 0; font-size: 14px; font-family: sans-serif; color: #555555; padding: 0">
                                                 {{ $appointment->approval_message ?? 'No message' }}
                                                </p>
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                            </td>
                        </tr>
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
