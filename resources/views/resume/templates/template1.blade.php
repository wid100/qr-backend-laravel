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
            margin-bottom: 2px;
            padding: 0;
            border: 0;
            margin-top: 10px;
        }

        body {
            margin: 0px;
            padding: 0px;
        }
    </style>

</head>

<body style="font-family: 'Nunito', sans-serif; margin: 0px; padding: 0px; background: white;">

    <div style="">
        <table
            style=" margin-top:20px; background-color: #ffffff;border-spacing:inherit; box-shadow: 4px 4px 10px 4px #484848; margin-left:20px">
            <!-- Top section: Image and name -->
            <tr>
                <td style="width: 30%; background-color: #484848; text-align: center; border-radius: 500px 500px 0 0;">
                    @if ($base64Image)
                        <img src="{{ $base64Image }}" alt="Image error!"
                            style="width: 200px; height:200px; margin-top: 20px; border: 2px solid white; border-radius: 50%;">
                    @else
                        <p>No image available</p>
                    @endif
                </td>

                <td style=" padding: 0px 30px 10px 20px;">
                    <h1
                        style="color: #D19855; -webkit-text-stroke: 1px black; margin: 0; font-size: xxx-large; font-weight: lighter; text-shadow: 0px 5px 10px black;">
                        {{ $resume->fname }} {{ $resume->lname }}</h1>
                    <p style="color: #000000; letter-spacing: 2px; margin: 0; font-size: 18px; padding-top:10px ">
                        {{ $resume->profession }}</p>
                    <p style="text-align: justify; font-size: 14px; padding-right:20px;padding-top:10px">
                        {{ $resume->description }}
                    </p>
                </td>
            </tr>
            <!-- Body Section -->
            <tr>
                <td
                    style="width: 33%; background-color: #484848; padding-left:20px;padding-right:20px; padding-top:30px; color:#fff; hight:100vh ; padding-bottom:50px">
                    <h1 style="color: #D19855; font-size: 20px;  border-bottom: 1px solid #fff; padding-bottom:15px">
                        CONTACT
                    </h1>
                    <h3 style="padding-top: 10px;">Phone</h3>
                    <p>{{ $resume->phone }}</p>
                    <h3>Email</h3>
                    <p>{{ $resume->email }}</p>
                    <h3>Address</h3>
                    <p>{{ $resume->address }}</p>

                    <h1
                        style="color: #D19855; font-size: 20px;  border-bottom: 1px solid #fff; padding-bottom:15px; padding-top:20px">
                        EDUCATION
                    </h1>
                    @forelse($education as $edu)
                        <p>
                            {{ \Carbon\Carbon::parse($edu['startYear'])->format('Y') }} -
                            {{ \Carbon\Carbon::parse($edu['endYear'])->format('Y') }},
                            {{ $edu['degree'] }},
                            Grade: {{ $edu['grade'] }},
                            {{ $edu['institution'] }}
                        </p>
                    @empty
                        <p>No education data available</p>
                    @endforelse
                    <h1
                        style="color: #D19855; font-size: 20px;  border-bottom: 1px solid #fff; padding-bottom:15px; padding-top:20px">
                        SKILLS
                    </h1>
                    <ul style="padding: 0; list-style: none;">
                        @forelse($skills as $skill)
                            <li>{{ $skill }}</li>
                        @empty
                            <li>No skills available</li>
                        @endforelse
                    </ul>

                    <h1
                        style="color: #D19855; font-size: 20px;  border-bottom: 1px solid #fff; padding-bottom:15px; padding-top:20px">
                        LANGUAGE
                    </h1>
                    @foreach ($languages as $lan)
                        <p>{{ $lan }}</p>
                    @endforeach

                    <h1
                        style="color: #D19855; font-size: 20px;  border-bottom: 1px solid #fff; padding-bottom:15px; padding-top:20px">
                        INTEREST
                    </h1>
                    @foreach ($interestes as $int)
                        <p>{{ $int }}</p>
                    @endforeach
                </td>
                <td style="width: 67%;">
                    <h1
                        style="color: #D19855; background-color: #484848; width:200px; padding: 5px 5px 5px 20px; border-radius: 0px 50px 50px 0px; font-size:22px">
                        Experience</h1>
                    <table style="width: 100%; border-spacing: 10px;">
                        <tr>
                            <td style="width: 0%; font-size: 14px;"></td>
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
                                    <p style="font-size: 15px">{{ $exp['jobTitle'] }}</p>
                                    <p style="font-size: 14px; padding-right: 20px;">{{ $exp['description'] }}</p>
                                </div>
                            @endforeach

                        </tr>

                    </table>

                    <h1
                        style="color: #D19855; background-color: #484848; width:200px; padding: 5px 5px 5px 20px; border-radius: 0px 50px 50px 0px; font-size:22px">
                        Reference</h1>
                    <table style="width: 100%; padding-left:20px">
                        <tr>
                            @foreach ($references as $reference)
                                <td style="padding-right: 20px; vertical-align: top;">
                                    <h3 style="font-size: 16px;">{{ $reference['firstName'] }}
                                        {{ $reference['lastName'] }}</h3>
                                    <p style="font-size: 14px;">{{ $reference['jobTitle'] }}</p>
                                    <p style="font-size: 14px;">Phone: {{ $reference['phone'] }}</p>
                                    <p style="font-size: 14px;">Email: {{ $reference['email'] }}</p>
                                </td>
                            @endforeach
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>

</body>

</html>
