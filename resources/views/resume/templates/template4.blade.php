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

        .main-body-4 {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            color: #000000;
        }

        /* Table styling */
        table {
            width: 100%;
            height: 100vh;
            border-spacing: 0;
            border-collapse: collapse;
        }

        .qr-image-4 {
            width: 100px;
            height: 100px;
            object-fit: cover;
            margin-top: 20px;
        }

        .sub-heading-4 {
            font-size: 16px;
            padding: 15px 0;
            border-bottom: 1px solid #ffffff;
            text-transform: uppercase;
            padding-bottom: 6px;
            font-weight: 600;
        }

        .contact-list-4,
        .education-list-4,
        .experience-list-4,
        .language-list-4,
        .hobbies-list-4,
        .certifications-list-4 {
            padding-left: 0;
        }

        .contact-item-4,
        .education-item-4,
        .experience-item-4,
        .language-item-4,
        .hobbies-item-4,
        .certification-item-4 {
            list-style: none;
            font-size: 12px;
            padding: 4px 0;
            color: #fff;
            line-height: 140%;
            transition: background 0.3s;
        }

        .contact-item-4:hover,
        .education-item-4:hover,
        .experience-item-4:hover,
        .language-item-4:hover,
        .hobbies-item-4:hover,
        .certification-item-4:hover {
            background: rgba(255, 179, 23, 0.2);
        }

        .contact-link-4 {
            color: inherit;
            text-decoration: none;
        }

        .skill-4 {
            list-style-type: none;
            padding: 10px 0;
            font-size: 13px;
            display: flex;
            flex-wrap: wrap;
            color: #fff;
        }

        .skill-4 li {
            width: 50%;
            padding: 5px 0;
        }

        /* Right side styles */
        .right-side-4 {
            background: #ffffff;
            color: #000000;
            padding: 30px;
        }

        .name-heading-4 {
            color: #fff;
            font-size: 30px;
            font-weight: 400;
        }

        .designation-4 {
            font-weight: 400;
            color: #fff;
            margin-top: 10px;
        }

        .description-4 {
            font-size: 16px;
            color: #fff;
            padding: 10px 0 10px 0;
        }

        .section-heading-4 {
            font-weight: 700;
            color: #484848;
            padding: 8px 0 10px 0px;
            border-bottom: 1px solid #000;
            margin-bottom: 15px;
            text-transform: uppercase;
            font-size: 18px
        }

        .references-4 {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            padding: 10px 0;
        }

        .reference-item-4 {
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

        .reference-item-4:hover {
            transform: translateY(-3px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }

        .reference-item-4 h3 {
            padding: 4px 0;
            font-size: 18px;
            font-weight: bold;
        }

        .reference-item-4 p {
            padding: 3px 0;
            margin: 0;
        }

        .reference-item-4 a {
            color: inherit;
            text-decoration: none;
        }

        .reference-item-4 a:hover {
            color: #4391CF;
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <table>
        <tr>
            <!-- Left side -->
            <td style="width: 20%; height:100%; vertical-align: top; background-color: #484848; padding:0 20px">
                <div style="width: 100%;text-align: center;padding-top:20px;">
                    @if ($base64Image)
                        <img src="{{ $base64Image }}" alt="Image error!"
                            style=" width: 170px;height: 170px; object-fit: cover; position: relative;z-index: 1;border: 2px solid #ffffff;border-radius: 50%;object-fit: cover;">
                    @else
                        <p>No image available</p>
                    @endif

                </div>
                <div style="padding:20px;">
                    <h2 class="sub-heading-4" style="color: {{ $resume->primary_color }}">Contact</h2>
                    <ul class="contact-list-4">
                        <li class="contact-item-4">
                            <p style="font-size: 14px">Phone</p>
                            <a href="tel:{{ $resume->phone }}" class="contact-link-4">{{ $resume->phone }}</a>
                        </li>
                        <li class="contact-item-4">
                            <p style="font-size: 14px">Email</p>
                            <a href="mailto:{{ $resume->email }}" class="contact-link-4">{{ $resume->email }}</a>
                        </li>
                        <li class="contact-item-4">
                            <p style="font-size: 14px">Address</p>
                            <p>{{ $resume->address }}</p>
                        </li>
                    </ul>
                    <h2 class="sub-heading-4" style="color: {{ $resume->primary_color }}">Education</h2>
                    <ul class="education-list-4" style="margin-bottom: 7px">
                        @forelse($education as $edu)
                            <li class="education-item-4">
                                <span style="font-size: 12px">
                                    {{ \Carbon\Carbon::parse($edu['startYear'])->format('Y') }} -
                                    {{ \Carbon\Carbon::parse($edu['endYear'])->format('Y') }}</span>
                                <p style="font-size: 14px">{{ $edu['degree'] }}
                                </p>
                                <p style="font-size: 12px">Grade:{{ $edu['grade'] }}</p>
                                <p style="font-size: 12px">{{ $edu['institution'] }}</p>
                            </li>
                        @empty
                            <p style="font-size: 12px">No education data available</p>
                        @endforelse
                    </ul>
                    <h2 class="sub-heading-4"style="color: {{ $resume->primary_color }};padding-bottom: 10px ">Skills
                    </h2>

                    <table style="width: 100%; padding-top:10px">
                        @forelse($skills as $skill)
                            <tr>
                                <td style="font-size: 12px;padding-bottom:3px; white-space:nowrap; color:#fff">
                                    {{ $skill }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="1" style="font-size: 12px; white-space:nowrap; color:#fff">
                                    No skills available.
                                </td>
                            </tr>
                        @endforelse

                    </table>
                    <h2 class="sub-heading-4" style="color: {{ $resume->primary_color }}">Languages</h2>
                    <ul class="language-list-4">
                        @foreach ($languages as $lan)
                            <li class="language-item-4">{{ $lan }}</li>
                        @endforeach
                    </ul>
                    <h2 class="sub-heading-4" style="color: {{ $resume->primary_color }}">Interests</h2>
                    <ul class="hobbies-list-4">
                        @foreach ($interestes as $int)
                            <li class="hobbies-item-4">{{ $int }}</li>
                        @endforeach
                    </ul>
                </div>

            </td>

            <!-- Right side -->
            <td style="width: 80%; background-color: white;vertical-align: top;">
                <div style="background: {{ $resume->primary_color }}; padding:25px;">
                    <table>
                        <tr>
                            <td>
                                <h1 class="name-heading-4"> <b>{{ $resume->fname }}</b> {{ $resume->lname }}</h1>
                                <p class="designation-4">{{ $resume->profession }}</p>
                                <p class="description-4" style="font-size: 12px">
                                    {{ $resume->description }}
                                </p>
                            </td>
                            @if (isset($qrCodeBase64))
                                <div style="text-align: right;">
                                    <img src="{{ $qrCodeBase64 }}" alt="QR Code"
                                        style="width: 100px; height: 100px;" />
                                </div>
                            @endif
                        </tr>
                    </table>
                </div>
                <div class="right-side-4">

                    <h2 class="section-heading-4" style="margin-top: 15px">Experience</h2>
                    <ul class="experience-list-4">
                        @foreach ($experiences as $exp)
                            <li class="experience-item-4" style="color: #000; margin-bottom:20px">

                                <p style="margin-bottom:5px; font-size:14px">
                                    {{ \Carbon\Carbon::parse($exp['startYear'])->format('Y') }} -
                                    @if ($exp['workingNow'])
                                        Present
                                    @else
                                        {{ $exp['endYear'] ? \Carbon\Carbon::parse($exp['endYear'])->format('Y') : 'N/A' }}
                                    @endif
                                </p>
                                <h3 style="font-size:18px; font-weight: 600; padding-bottom:7px">
                                    {{ $exp['employeeName'] }} | {{ $exp['location'] }}

                                </h3>
                                <p style="font-size: 17px; padding-bottom:7px">{{ $exp['jobTitle'] }}</p>
                                <p style="font-size: 16px; line-height:130%; padding-right: 20px;">
                                    {{ $exp['description'] }}</p>
                            </li>
                        @endforeach

                    </ul>
                    <h2 class="section-heading-4" style="margin-top: 15px">References</h2>
                    <table style="width: 100%;">
                        <tr>
                            <td>
                                <h3 style="font-size: 16px; padding-bottom:7px">Name Surname</h3>
                                <p style="font-size: 12px; padding-bottom:5px">Job Position, Company</p>
                                <p style="font-size: 12px; padding-bottom:5px">Phone: <span> <a href="tel:123-456-7890"
                                            class="contact-link-4">123-456-7890</a></span></p>
                                <p style="font-size: 12px;padding-bottom:5px">Email: <a
                                        href="mailto:jahanara.womeningdigital@gmail.com"
                                        class="contact-link-4">jahanara.womeningdigital@gmail.com</a> </p>
                            </td>
                            <td>
                                <h3 style="font-size: 16px; padding-bottom:7px">Name Surname</h3>
                                <p style="font-size: 12px; padding-bottom:5px">Job Position, Company</p>
                                <p style="font-size: 12px; padding-bottom:5px">Phone: <span> <a href="tel:123-456-7890"
                                            class="contact-link-4">123-456-7890</a></span></p>
                                <p style="font-size: 12px;padding-bottom:5px">Email: <a
                                        href="mailto:jahanara.womeningdigital@gmail.com"
                                        class="contact-link-4">jahanara.womeningdigital@gmail.com</a> </p>
                            </td>
                        </tr>
                    </table>
                </div>
            </td>

        </tr>
    </table>
</body>

</html>
