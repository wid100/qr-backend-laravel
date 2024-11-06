<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $resume->fname }} {{ $resume->lname }}</title>
    <link rel="stylesheet" href="assets/css/style6.css" />
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'inter';
        }

        body {
            background: #f9f9f9;

        }

        .main-body-13 {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            color: #ffffff;
        }

        /* Table styling */
        table {
            width: 100%;
            height: 100vh;
            border-spacing: 0;
            border-collapse: collapse;

        }

        .image-container {
            width: 100px;
            height: 180px;
            background-color: #F97700;
            margin: 0 auto;
            position: relative;
            text-align: center;
            margin-bottom: 20px;
        }

        .image-container-bottom {
            width: 100%;
            height: 20px;
            background-color: #F97700;
            bottom: 0;
            right: 0;
            position: absolute;
        }

        .qr-image-13 {
            width: 80px;
            height: 80px;
            object-fit: cover;
            position: absolute;
            top: 49%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .sub-heading-13 {
            color: #F97700;
            font-size: 16px;
            padding: 15px 0;
            border-bottom: 1px solid #000;
            text-transform: uppercase;
            padding-bottom: 6px;
            font-weight: 600;
        }

        .contact-list-13,
        .education-list-13,
        .experience-list-13,
        .language-list-13,
        .hobbies-list-13,
        .skill-list-13 {
            padding-left: 0;
            padding-right: 20px;
        }

        .contact-item-13,
        .education-item-13,
        .experience-item-13,
        .language-item-13,
        .hobbies-item-13,
        .skill-item-13 {
            list-style: none;
            font-size: 14px;
            padding: 4px 0;
            color: #000;
            line-height: 140%;
            transition: background 0.3s;
        }

        .experience-item-13 {
            border-bottom: 1px solid #000000;
        }

        .experience-item-13:last-child {
            border-bottom: none;
        }

        .contact-item-13:hover,
        .education-item-13:hover,
        .experience-item-13:hover,
        .language-item-13:hover,
        .hobbies-item-13:hover,
        .skill-item-13:hover {
            background: rgba(255, 179, 23, 0.2);
        }

        .contact-link-13 {
            color: inherit;
            text-decoration: none;
        }

        .skill-13 {
            list-style-type: none;
            padding: 10px 0;
            font-size: 13px;
            display: flex;
            flex-wrap: wrap;
            color: #fff;
        }

        .skill-13 li {
            width: 50%;
            padding: 5px 0;
        }

        /* Right side styles */
        .right-side-13 {
            background: #ffffff;
            color: #000000;
            padding: 0 30px 30px;
        }

        .name-heading-13 {
            color: #000000;
            font-size: 30px;
            font-weight: 400;
            padding-top: 15px;
        }

        .designation-13 {
            font-weight: 400;
            color: #F97700;
            margin-top: 10px;
        }

        .description-13 {
            font-size: 16px;
            padding: 10px 0 10px 0;
        }

        .section-heading-13 {
            font-weight: 700;
            color: #F97700;
            border-bottom: 1px solid #000;
            padding-bottom: 5px;
            margin-bottom: 15px;
            text-transform: uppercase;
            font-size: 18px
        }

        .references-13 {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            padding: 10px 0;
        }

        .reference-item-13 {
            color: black;
            line-height: 15px;
            flex: 0 1 calc(50% - 10px);
            box-sizing: border-box;
            font-size: 15px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .reference-item-13:hover {
            transform: translateY(-3px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }

        .reference-item-13 h3 {
            padding: 4px 0;
            font-size: 18px;
            font-weight: bold;
        }

        .reference-item-13 p {
            padding: 3px 0;
            margin: 0;
        }

        .reference-item-13 a {
            color: inherit;
            text-decoration: none;
        }

        .reference-item-13 a:hover {
            color: #F97700;
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <table>
        <tr>
            <!-- Left side -->
            <td style="width: 80%; background-color: #ffffff;vertical-align: top; ">
                <div class="right-side-13">
                    <table style="border-collapse: separate;border-spacing: 0px 20px 0 0;">
                        <tr>
                            <div class="image-container" style="background: {{ $resume->primary_color }}; border:1px solid {{ $resume->primary_color }} ">
                                @if (isset($qrCodeBase64))
                                    <img src="{{ $qrCodeBase64 }}" alt="QR Code" class="qr-image-13" />
                                @endif
                            </div>
                            <td>
                                <div style="margin-left: 20px">
                                    <h1 class="name-heading-13"> <b>{{ $resume->fname }}</b> {{ $resume->lname }}</h1>
                                    <p class="designation-13" style="color: {{ $resume->primary_color }}">{{ $resume->profession }}</p>
                                    <p class="description-13" style="font-size: 12px">
                                       {!! strip_tags($resume->description) !!}
                                    </p>
                                </div>
                            </td>
                        </tr>
                    </table>
                    <h2 class="section-heading-13" style="margin-top: 15px; color:{{ $resume->primary_color }}">Experience</h2>
                    <ul class="experience-list-13">
                        @foreach ($experiences as $exp)
                            <li class="experience-item-13" style="color: #000; margin-bottom:20px">

                                <p style="margin-bottom:5px; font-size:14px; color: {{ $resume->primary_color }}">
                                    {{ \Carbon\Carbon::parse($exp['startYear'])->format('F Y') }} -
                                    @if ($exp['workingNow'])
                                        Present
                                    @else
                                        {{ $exp['endYear'] ? \Carbon\Carbon::parse($exp['endYear'])->format('F Y') : 'N/A' }}
                                    @endif
                                </p>
                                <h3 style="font-size:18px; font-weight: 600; padding-bottom:7px">
                                    {{ $exp['employeeName'] }} | {{ $exp['location'] }}

                                </h3>
                                <p style="font-size: 17px; padding-bottom:7px; color: {{ $resume->primary_color }}">{{ $exp['jobTitle'] }}</p>
                                <p style="font-size: 16px; line-height:130%; padding-right: 20px;">
                                       {!! strip_tags($exp['description']) !!}</p>
                            </li>
                        @endforeach

                    </ul>
                    <h2 class="section-heading-13" style="margin-top: 15px; color:{{ $resume->primary_color }}">References</h2>
                    <table style="width: 100%;">
                        <tr>
                            @foreach ($references as $reference)
                                <td>
                                    <h3 style="font-size: 16px; padding-bottom:7px">{{ $reference['firstName'] }}
                                        {{ $reference['lastName'] }}</h3>
                                    <p style="font-size: 12px; padding-bottom:5px">{{ $reference['jobTitle'] }}</p>
                                    <p style="font-size: 12px; padding-bottom:5px">Phone: <span> <a
                                                href='tel:{{ $reference['phone'] }}'
                                                class="contact-link-13">{{ $reference['phone'] }}</a></span>
                                    </p>
                                    <p style="font-size: 12px;padding-bottom:5px">Email: <a
                                            href="mailto:{{ $reference['email'] }}"
                                            class="contact-link-13">{{ $reference['email'] }}</a> </p>
                                </td>
                            @endforeach

                        </tr>
                    </table>
                </div>
            </td>

            <!-- Right side -->
            <td style="width: 20%; height:100%; vertical-align: top; background-color: #ffffff;position: relative">

                <div class="left-side-13">
                    <div style="width: 100%;text-align: center;padding-top:20px;">
                        @if ($base64Image)
                            <img src="{{ $base64Image }}" alt="Image error!"
                                style="  width: 170px;height: 170px; object-fit: cover; position: relative;z-index: 1;border: 2px solid {{ $resume->primary_color }};border-radius: 50%;object-fit: cover;">
                        @else
                            <p>No image available</p>
                        @endif
                    </div>
                    <div style="padding:20px 0 20px 20px;">
                        <h2 class="sub-heading-13" style="color: {{ $resume->primary_color }}">Contact</h2>
                        <ul class="contact-list-13">
                            <li class="contact-item-13">
                                <p style="font-size: 14px">Phone</p>
                                <a href="tel:{{ $resume->phone }}" class="contact-link-13">{{ $resume->phone }}</a>
                            </li>
                            <li class="contact-item-13">
                                <p style="font-size: 14px">Email</p>
                                <a href="mailto:{{ $resume->email }}" class="contact-link-13">{{ $resume->email }}</a>
                            </li>
                            <li class="contact-item-13">
                                <p style="font-size: 14px">Address</p>
                                <p>{{ $resume->address }}</p>
                            </li>
                        </ul>
                        <h2 class="sub-heading-13" style="color: {{ $resume->primary_color }}">Education</h2>
                        <ul class="education-list-13" style="margin-bottom: 7px">
                            @forelse($education as $edu)
                                <li class="education-item-13">
                                    <span style="font-size: 14px">
                                        {{ \Carbon\Carbon::parse($edu['startYear'])->format('F Y') }} -
                                        {{ \Carbon\Carbon::parse($edu['endYear'])->format('F Y') }}</span>
                                    <p style="font-size: 14px">{{ $edu['degree'] }}
                                    </p>
                                    <p style="font-size: 14px">Grade:{{ $edu['grade'] }}</p>
                                    <p style="font-size: 14px">{{ $edu['institution'] }}</p>
                                </li>
                            @empty
                                <p style="font-size: 12px">No education data available</p>
                            @endforelse

                        </ul>
                        <h2 class="sub-heading-13" style="padding-bottom: 10px;color:{{ $resume->primary_color }} ">Skills</h2>
                        <ul class="skill-list-13">
                            @forelse($skills as $skill)
                                <li class="skill-item-13"> {{ $skill }}</li>
                            @empty
                                <li class="skill-item-13">
                                    No skills available.
                                </li>
                            @endforelse
                        </ul>


                        <h2 class="sub-heading-13" style="color: {{ $resume->primary_color }}">Languages</h2>
                        <table style="width: 100%; padding-top:10px">
                            @foreach ($languages as $lan)
                                <tr>
                                    <td style="font-size: 14px; white-space: nowrap; color:#000">
                                        {{ $lan }}
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        <h2 class="sub-heading-13" style="color: {{ $resume->primary_color }}">Interests</h2>
                        <ul class="hobbies-list-13">
                            @foreach ($interestes as $int)
                                <li class="hobbies-item-13">{{ $int }}</li>
                            @endforeach
                        </ul>

                    </div>
                </div>
                <div class="image-container-bottom" style="background: {{ $resume->primary_color }}">
                </div>
            </td>
        </tr>
    </table>
</body>

</html>
