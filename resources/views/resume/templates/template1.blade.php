<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $resume->fname }} {{ $resume->lname }}</title>
    <style>
        @page {
            margin: 0px;
        }

        * {
            margin: 0;
            padding: 0;
            border: 0;
        }

        body {
            margin: 0px;
            padding: 0px;
            font-family: 'Nunito', sans-serif;
            background: white;
        }

        table {
            width: 100%;
            table-layout: fixed;
            margin: 20px;
            border-spacing: 0;
            box-shadow: 4px 4px 10px 4px #484848;
        }

        td {
            padding: 20px;
        }

        .header {
            display: flex;
            align-items: center;
        }

        .header img {
            border-radius: 50%;
            width: 150px;
            height: 150px;
            border: 3px solid white;
        }

        .header h1 {
            color: #D19855;
            -webkit-text-stroke: 1px black;
            font-size: 32px;
            font-weight: normal;
            text-shadow: 0px 5px 10px black;
        }

        .header p {
            margin-top: 10px;
            font-size: 18px;
        }

        .contact-info {
            background-color: #484848;
            color: white;
            padding: 30px;
            height: auto;
        }

        .content-section {
            padding: 20px;
            min-height: 100vh;
        }

        .section-title {
            color: #D19855;
            font-size: 20px;
            margin-bottom: 10px;
            border-bottom: 1px solid white;
        }

        .experience,
        .reference {
            margin-top: 20px;
        }

        .experience h3,
        .reference h3 {
            font-size: 16px;
            font-weight: 600;
        }

        .skills-list,
        .education-list,
        .language-list {
            list-style: none;
            padding-left: 0;
        }

        .experience-details,
        .reference-details {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            height: 100vh;
            border-spacing: 0;
            border-collapse: collapse;
        }

        tr {
            height: auto;
        }

        td {
            margin: 0;
            padding: 0;
        }
    </style>
</head>

<body>

    <div class="container">
        <table>
            <!-- Top section: Image and name -->
            <tr style="height: auto;">
                <td
                    style="width: 30%; height:24%; background-color: #484848; text-align: center; border-radius: 500px 500px 0 0;">
                    @if ($base64Image)
                        <img src="{{ $base64Image }}" alt="Image error!">
                    @else
                        <p>No image available</p>
                    @endif
                </td>

                <td style=" padding: 0px 30px 10px 20px;">
                    <h1
                        style="color: #D19855; -webkit-text-stroke: 1px black; margin: 0; font-size:20px; font-weight: lighter; text-shadow: 0px 5px 10px black;">
                        {{ $resume->fname }} {{ $resume->lname }}</h1>
                    <p style="color: #000000; letter-spacing: 2px; margin: 0; font-size: 13px; padding-top:10px ">
                        {{ $resume->profession }}</p>
                    <p style="text-align: justify; font-size: 12px; padding-right:20px;padding-top:10px">
                        {{ $resume->description }}
                    </p>
                </td>
            </tr>

            <!-- Body Section -->
            <tr>

                <td
                    style="width: 33%;height:70%; background-color: #484848; padding-left:20px;padding-right:20px; padding-top:30px; color:#fff; padding-bottom:20px">
                    <h1 style="color: #D19855; font-size: 16px;  border-bottom: 1px solid #fff; padding-bottom:15px">
                        CONTACT
                    </h1>
                    <h3 style="padding-top: 10px;font-size: 12px;">Phone</h3>
                    <p style="font-size: 12px">{{ $resume->phone }}</p>
                    <h3 style="font-size: 12px">Email</h3>
                    <p style="font-size: 12px">{{ $resume->email }}</p>
                    <h3 style="font-size: 12px">Address</h3>
                    <p>{{ $resume->address }}</p>

                    <h1
                        style="color: #D19855; font-size: 16px;  border-bottom: 1px solid #fff; padding-bottom:15px; padding-top:10px">
                        EDUCATION
                    </h1>
                    @forelse($education as $edu)
                        <p style="font-size: 12px">
                            {{ \Carbon\Carbon::parse($edu['startYear'])->format('Y') }} -
                            {{ \Carbon\Carbon::parse($edu['endYear'])->format('Y') }},
                            {{ $edu['degree'] }},
                            Grade: {{ $edu['grade'] }},
                            {{ $edu['institution'] }}
                        </p>
                    @empty
                        <p style="font-size: 12px">No education data available</p>
                    @endforelse
                    <h1
                        style="color: #D19855; font-size: 16px;  border-bottom: 1px solid #fff; padding-bottom:15px; padding-top:10px">
                        SKILLS
                    </h1>
                    <ul style="padding: 0; list-style: none;">
                        @forelse($skills as $skill)
                            <li style="font-size: 12px; line-height:10px ">{{ $skill }}</li>
                        @empty
                            <li style="font-size: 12px">No skills available</li>
                        @endforelse
                    </ul>

                    <h1
                        style="color: #D19855; font-size: 16px;  border-bottom: 1px solid #fff; padding-bottom:15px; padding-top:10px">
                        LANGUAGE
                    </h1>
                    @foreach ($languages as $lan)
                        <p style="line-height:10px;font-size: 12px">{{ $lan }}</p>
                    @endforeach

                    <h1
                        style="color: #D19855; font-size: 16px;  border-bottom: 1px solid #fff; padding-bottom:15px; padding-top:10px">
                        INTEREST
                    </h1>
                    @foreach ($interestes as $int)
                        <p style="line-height:10px;font-size: 12px">{{ $int }}</p>
                    @endforeach
                </td>
                <td style="width: 67%; vertical-align: top;">
                    <h1
                        style="color: #D19855; background-color: #484848; width:200px; padding: 5px 5px 5px 20px; border-radius: 0px 50px 50px 0px; font-size:18px">
                        Experience</h1>
                    <table style="width: 100%; padding-left: 20px;">
                        <tr>
                            <td style="width: 0%; font-size: 14px;">
                                @foreach ($experiences as $exp)
                                    <div style="margin-bottom: 20px;">
                                        <p style="margin-bottom:5px; font-size:12px">
                                            {{ \Carbon\Carbon::parse($exp['startYear'])->format('Y') }} -
                                            @if ($exp['workingNow'])
                                                Present
                                            @else
                                                {{ $exp['endYear'] ? \Carbon\Carbon::parse($exp['endYear'])->format('Y') : 'N/A' }}
                                            @endif
                                        </p>
                                        <h3 style="font-size:16px; font-weight: 600;">
                                            {{ $exp['employeeName'] }} | {{ $exp['location'] }}
                                        </h3>
                                        <p style="font-size: 12px">{{ $exp['jobTitle'] }}</p>
                                        <p style="font-size: 12px; padding-right: 20px;">{{ $exp['description'] }}</p>
                                    </div>
                                @endforeach
                            </td>
                        </tr>

                    </table>

                    <h1
                        style="color: #D19855; background-color: #484848; width:200px; padding: 5px 5px 5px 20px; border-radius: 0px 50px 50px 0px; font-size:18px">
                        Reference</h1>
                    <table style="width: 100%; padding-left:20px">
                        <tr>
                            @foreach ($references as $reference)
                                <td style="padding-right: 20px; vertical-align: top;">
                                    <h3 style="font-size: 12px;">{{ $reference['firstName'] }}
                                        {{ $reference['lastName'] }}</h3>
                                    <p style="font-size: 12px;">{{ $reference['jobTitle'] }}</p>
                                    <p style="font-size: 12px;">Phone: {{ $reference['phone'] }}</p>
                                    <p style="font-size: 12px;">Email: {{ $reference['email'] }}</p>
                                </td>
                            @endforeach
                        </tr>
                    </table>
                    <div style="padding-left:20px">
                        <img src="https://i.postimg.cc/cLwdGbsf/QR.png" alt="QR Code" class="qr-image-6" />
                    </div>
                </td>
            </tr>
        </table>
    </div>

</body>

</html>
