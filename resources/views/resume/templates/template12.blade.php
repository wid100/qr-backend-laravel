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

        .main-body-12 {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            color: #000;
        }

        /* Table styling */
        table {
            width: 100%;
            height: 100vh;
            border-spacing: 0;
            border-collapse: collapse;

        }

        .qr-image-12 {
            width: 100px;
            height: 100px;
            object-fit: cover;
            margin-top: 20px;
        }

        .sub-heading-12 {
            color: #000;
            font-size: 16px;
            padding: 15px 0;
            border-bottom: 1px solid #000;
            text-transform: uppercase;
            padding-bottom: 6px;
            font-weight: 600;
        }

        /* .contact-list-12,
        .education-list-12,
        .experience-list-12,
        .language-list-12,
        .hobbies-list-12,
        .skill-list-12 {
            padding-left: 0;
            padding-right: 20px;
        } */

        .contact-item-12,
        .education-item-12,
        .experience-item-12,
        .language-item-12,
        .hobbies-item-12,
        .skill-item-12 {
            list-style: none;
            font-size: 12px;
            padding: 4px 0;
            color: #000000;
            line-height: 140%;
            transition: background 0.3s;
        }

        .contact-item-12:hover,
        .education-item-12:hover,
        .experience-item-12:hover,
        .language-item-12:hover,
        .hobbies-item-12:hover,
        .skill-item-12:hover {
            background: rgba(255, 179, 23, 0.2);
        }

        .contact-link-12 {
            color: inherit;
            text-decoration: none;
        }

        /* Right side styles */
        .right-side-12 {
            background: #f5f5f5;
            color: #000000;
            padding: 30px;
        }

        .name-heading-12 {
            color: #000000;
            font-size: 20px;
            font-weight: 400;
            padding-top: 20px;
        }

        .designation-12 {
            font-weight: 400;
            color: #000000;
            margin-top: 10px;
        }

        .description-12 {
            font-size: 16px;
            padding: 10px 0 10px 0;
        }

        .section-heading-12 {
            font-weight: 700;
            color: #000;
            border-bottom: 1px solid #000;
            padding-bottom: 5px;
            margin-bottom: 15px;
            text-transform: uppercase;
            font-size: 18px
        }

        .references-12 {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            padding: 10px 0;
        }

        .reference-item-12 {
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

        .reference-item-12:hover {
            transform: translateY(-3px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }

        .reference-item-12 h3 {
            padding: 4px 0;
            font-size: 18px;
            font-weight: bold;
        }

        .reference-item-12 p {
            padding: 3px 0;
            margin: 0;
        }

        .reference-item-12 a {
            color: inherit;
            text-decoration: none;
        }

        .reference-item-12 a:hover {
            color: #000;
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <table>
        <tr>
            <!-- Left side -->
            <td
                style="width: 20%; height:100%; padding: 0 20px; vertical-align: top; background-color: {{ $resume->primary_color }};">
                <div class="left-side-12">
                    <div style="width: 100%;text-align: center;padding-top:20px;">
                        @if ($base64Image)
                            <img src="{{ $base64Image }}" alt="Image error!"
                                style=" width: 170px;height: 170px; object-fit: cover; position: relative;z-index: 1;border: 2px solid #ffffff;border-radius: 50%;object-fit: cover;">
                        @else
                            <p>No image available</p>
                        @endif
                        <h1 class="name-heading-12"><b>{{ $resume->fname }}</b> {{ $resume->lname }}</h1>
                        <p class="designation-12">{{ $resume->profession }}</p>
                    </div>

                    <div>
                        <h2 class="sub-heading-12">Contact</h2>
                        <ul class="contact-list-12">
                            <li class="contact-item-12">
                                <p style="font-size: 14px">Phone</p>
                                <a href="tel:{{ $resume->phone }}" class="contact-link-12">{{ $resume->phone }}</a>
                            </li>
                            <li class="contact-item-12">
                                <p style="font-size: 14px">Email</p>

                                <a href="mailto:{{ $resume->email }}" class="contact-link-12">{{ $resume->email }}</a>
                            </li>
                            <li class="contact-item-12">
                                <p style="font-size: 14px">Address</p>
                                <p style="font-size: 14px;">{{ $resume->address }}</p>
                            </li>
                        </ul>
                        <h2 class="sub-heading-12" style="padding-bottom: 10px">Skills</h2>
                        <ul class="skill-list-12">
                            @forelse($skills as $skill)
                                <li class="skill-item-12"> {{ $skill }}</li>
                            @empty
                                <li class="skill-item-12">
                                    No skills available.
                                </li>
                            @endforelse
                        </ul>
                        <h2 class="sub-heading-12">Languages</h2>
                        <table style="width: 100%; padding-top:10px;">
                            @foreach ($languages as $lan)
                                <tr>
                                    <td style="font-size: 14px; white-space: nowrap;">
                                        <span class="custom-border">{{ $lan }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        <h2 class="sub-heading-12">Interests</h2>
                        <table style="width: 100%; padding-top:10px;">
                            @foreach ($interestes as $int)
                                <tr>
                                    <td style="font-size: 14px; white-space: nowrap;">
                                        <span class="custom-border">{{ $int }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </td>
            <!-- Right side -->
            <td style="width: 80%; background-color: #f5f5f5;vertical-align: top; ">
                <div class="right-side-12">
                    <table>
                        <tr>
                            <td>
                                <p class="description-12" style="font-size: 14px;margin-right: 20px;">
                                    {!! strip_tags($resume->description) !!}
                                </p>
                            </td>
                            <td style="text-align: right;">
                                @if (isset($qrCodeBase64))
                                    <img src="{{ $qrCodeBase64 }}" alt="QR Code" class="qr-image-12"
                                        style="width: 100px; height:100px" />
                                @endif
                            </td>
                        </tr>
                    </table>
                    <h2 class="section-heading-12" style="margin-top: 15px">Experience</h2>
                    <ul class="experience-list-12">
                        @foreach ($experiences as $exp)
                            <li class="experience-item-12" style="color: #000; margin-bottom:20px">
                                <table width="100%" cellspacing="0" cellpadding="0" border="0">
                                    <tr>
                                        <td width="35%" valign="top" align="left">
                                            <p style="margin-bottom:5px; font-size:14px;">
                                                {{ \Carbon\Carbon::parse($exp['startYear'])->format('F Y') }} -
                                                @if ($exp['workingNow'])
                                                    Present
                                                @else
                                                    {{ $exp['endYear'] ? \Carbon\Carbon::parse($exp['endYear'])->format('F Y') : 'N/A' }}
                                                @endif
                                            </p>
                                            <h3 style="font-size:18px; font-weight: bold; margin-bottom:7px;">
                                                {{ $exp['employeeName'] }} | {{ $exp['location'] }}</h3>
                                            <p style="font-size:14px; margin: 0; ">
                                                {{ $exp['jobTitle'] }}
                                            </p>
                                        </td>
                                        <td width="5%"></td>
                                        <td width="60%" valign="top" align="right" style="text-align: left;">
                                            <p style="font-size:14px; line-height:130%;"> {!! strip_tags($exp['description']) !!}</p>
                                        </td>
                                    </tr>
                                </table>
                            </li>
                        @endforeach
                    </ul>
                    <h2 class="section-heading-12" style="margin-top: 15px">Education</h2>
                    <ul class="experience-list-12">
                        @forelse($education as $edu)
                            <li class="education-item-12">
                                <span style="font-size: 12px">
                                    {{ \Carbon\Carbon::parse($edu['startYear'])->format('F Y') }} -
                                    {{ \Carbon\Carbon::parse($edu['endYear'])->format('F Y') }}</span>
                                <p style="font-size: 14px">{{ $edu['degree'] }}
                                </p>
                                <p style="font-size: 12px">Grade:{{ $edu['grade'] }}</p>
                                <p style="font-size: 12px">{{ $edu['institution'] }}</p>
                            </li>
                        @empty
                            <p style="font-size: 12px">No education data available</p>
                        @endforelse

                    </ul>
                    <h2 class="section-heading-12" style="margin-top: 15px">References</h2>
                    <table style="width: 100%;">
                        <tr>
                            @foreach ($references as $reference)
                                <td>
                                    <h3 style="font-size: 16px; padding-bottom:7px">{{ $reference['firstName'] }}
                                        {{ $reference['lastName'] }}</h3>
                                    <p style="font-size: 12px; padding-bottom:5px">{{ $reference['jobTitle'] }}</p>
                                    <p style="font-size: 12px; padding-bottom:5px">Phone: <span> <a
                                                href='tel:{{ $reference['phone'] }}'
                                                class="contact-link-12">{{ $reference['phone'] }}</a></span>
                                    </p>
                                    <p style="font-size: 12px;padding-bottom:5px">Email: <a
                                            href="mailto:{{ $reference['email'] }}"
                                            class="contact-link-12">{{ $reference['email'] }}</a> </p>
                                </td>
                            @endforeach
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
    </table>
</body>

</html>
