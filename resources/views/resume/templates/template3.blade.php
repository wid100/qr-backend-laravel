<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Resume</title>
    <link rel="stylesheet" href="assets/css/style6.css" />
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
               font-family: Arial, Helvetica, sans-serif;
        }

        body {
            background: #f9f9f9;

        }

        .main-body-3 {
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
            height: 90px;
            background-color: #FF5280;
            margin: 0 auto;
            position: relative;
            text-align: center;
            margin-bottom: 110px;
            width: 100%;
            padding-top: 20px;

        }

        .image-container-heading {
            width: 16%;
            height: 50px;
            background-color: #D9D9D9;

            margin: 20px 0px 20px -30px;

        }

        .qr-image-3 {
            width: 100px;
            height: 100px;
            object-fit: cover;
            display: flex;
            padding-right: 20px;
        }

        .sub-heading-3 {
            font-size: 16px;
            padding: 15px 0;
            text-transform: uppercase;
            padding-bottom: 6px;
            font-weight: 600;
        }

        .contact-list-3,
        .education-list-3,
        .experience-list-3,
        .language-list-3,
        .hobbies-list-3,
        .skill-list-3 {
            padding-left: 0;
            padding-right: 20px;
        }

        .contact-item-3,
        .education-item-3,
        .experience-item-3,
        .language-item-3,
        .hobbies-item-3,
        .skill-item-3 {
            list-style: none;
            font-size: 12px;
            padding: 4px 0;
            color: #000;
            line-height: 140%;
            transition: background 0.3s;
        }

        .hobbies-item-3 {
            color: #FF5280;
        }

        .experience-item-3 {
            padding-bottom: 10px;
        }

        .experience-item-3:last-child {
            border-bottom: none;
        }

        .contact-item-3:hover,
        .education-item-3:hover,
        .experience-item-3:hover,
        .language-item-3:hover,
        .hobbies-item-3:hover,
        .skill-item-3:hover {
            background: rgba(255, 179, 23, 0.2);
        }

        .contact-link-3 {
            color: inherit;
            text-decoration: none;
        }

        .skill-3 {
            list-style-type: none;
            padding: 10px 0;
            font-size: 13px;
            display: flex;
            flex-wrap: wrap;
            color: #fff;
        }

        .skill-3 li {
            width: 50%;
            padding: 5px 0;
        }

        /* Right side styles */
        .right-side-3 {
            background: #ffffff;
            color: #000000;
            padding: 0 30px 30px;
        }

        .name-heading-3 {
            color: #FF5280;
            font-size: 30px;
            font-weight: 400;
            padding-top: 15px;
        }

        .designation-3 {
            font-weight: 400;
            color: #000000;
            margin-top: 10px;
        }

        .description-3 {
            font-size: 16px;
            padding: 10px 0 10px 0;
        }

        .section-heading-3 {
            font-weight: 700;
            color: #FF5280;
            text-transform: uppercase;
            font-size: 18px;
            position: absolute;
            margin: 0 auto;
            padding-left: 30px;
        }

        .references-3 {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            padding: 10px 0;
        }

        .reference-item-3 {
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

        .reference-item-3:hover {
            transform: translateY(-3px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }

        .reference-item-3 h3 {
            padding: 4px 0;
            font-size: 18px;
            font-weight: bold;
        }

        .reference-item-3 p {
            padding: 3px 0;
            margin: 0;
        }

        .reference-item-3 a {
            color: inherit;
            text-decoration: none;
        }

        .reference-item-3 a:hover {
            color: #FF5280;
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <table>
        <tr>
            <!-- Left side -->
            <td style="width: 80%; background-color: #ffffff;vertical-align: top; ">
                <div class="right-side-3">
                    <table>
                        <tr>
                            <td>
                                <div>
                                    <h1 class="name-heading-3" style="color: {{ $resume->primary_color }}">
                                        <b>{{ $resume->fname }}</b> {{ $resume->lname }}
                                    </h1>
                                    <p class="designation-3">{{ $resume->profession }}</p>
                                    <p class="description-3" style="font-size: 14px">
                                          {!! strip_tags($resume->description) !!}</p>
                                    </p>
                                </div>
                            </td>
                        </tr>
                    </table>
                    <div class="image-container-heading">
                        <h2 class="section-heading-3" style="margin-top: 15px;color: {{ $resume->primary_color }}">
                            Experience</h2>
                    </div>
                    <ul class="experience-list-3">
                        @foreach ($experiences as $exp)
                            <li class="experience-item-3" style="color: #000">
                                <p style="margin-bottom:5px; font-size:14px; color: {{ $resume->primary_color }}">
                                    {{ \Carbon\Carbon::parse($exp['startYear'])->format('Y') }} -
                                    @if ($exp['workingNow'])
                                        Present
                                    @else
                                        {{ $exp['endYear'] ? \Carbon\Carbon::parse($exp['endYear'])->format('Y') : 'N/A' }}
                                    @endif
                                </p>
                                <h3 style="font-size:16px; font-weight: 600; padding-bottom:7px">
                                    {{ $exp['employeeName'] }} | {{ $exp['location'] }}

                                </h3>
                                <p style="font-size: 15px; padding-bottom:7px; color: {{ $resume->primary_color }}">
                                    {{ $exp['jobTitle'] }}
                                </p>
                                <p style="font-size: 14px; padding-right: 20px;">{!! strip_tags($exp['description']) !!}</p>
                            </li>
                        @endforeach
                    </ul>
                    <div class="image-container-heading">
                        <h2 class="section-heading-3" style="margin-top: 15px; color: {{ $resume->primary_color }}">
                            References</h2>
                    </div>
                    <table style="width: 100%;">
                        <tr>
                            @foreach ($references as $reference)
                                <td>
                                    <h3
                                        style="font-size: 16px; padding-bottom:7px; color:{{ $resume->primary_color }}">
                                        {{ $reference['firstName'] }}
                                        {{ $reference['lastName'] }}</h3>
                                    <p style="font-size: 14px; padding-bottom:5px">{{ $reference['jobTitle'] }}</p>
                                    <p style="font-size: 14px; padding-bottom:5px"><span
                                            style="color: {{ $resume->primary_color }}">Phone:</span> <span> <a
                                                href="tel:{{ $reference['phone'] }}"
                                                class="contact-link-3">{{ $reference['phone'] }}</a></span></p>
                                    <p style="font-size: 14px;padding-bottom:5px"><span
                                            style="color:  {{ $resume->primary_color }}">Email:
                                        </span><a href="mailto:{{ $reference['email'] }}"
                                            class="contact-link-3">{{ $reference['email'] }}</a> </p>
                                </td>
                            @endforeach
                        </tr>
                    </table>
                </div>
            </td>

            <!-- Right side -->
            <td style="width: 40%;height:100%; vertical-align: top; background-color: #ffffff;padding-right:20px">

                <div class="left-side-3">
                    <div style=" background:{{ $resume->primary_color }}"class="image-container">
                        @if ($base64Image)
                            <img src="{{ $base64Image }}" alt="Image error!"
                                style=" width: 170px;height: 170px;border: 5px solid #ffffff;object-fit: cover;">
                        @else
                            <p>No image available</p>
                        @endif

                    </div>

                    <div style="padding:20px 0 20px 20px; background-color: #D9D9D9;height:862px;">
                        <div style="text-align: center">
                            @if (isset($qrCodeBase64))
                                <img src="{{ $qrCodeBase64 }}" alt="QR Code" class="qr-image-3" />
                            @endif
                        </div>
                        <h2 class="sub-heading-3">Contact</h2>
                        <ul class="contact-list-3">
                            <li class="contact-item-3">
                                <p style="font-size: 14px;color:{{ $resume->primary_color }}">Phone</p>
                                <a href="tel:{{ $resume->phone }}" class="contact-link-3">{{ $resume->phone }}</a>
                            </li>
                            <li class="contact-item-3">
                                <p style="font-size: 14px;color:{{ $resume->primary_color }}">Email</p>
                                <a href="mailto:{{ $resume->email }}" class="contact-link-3">{{ $resume->email }}</a>
                            </li>
                            <li class="contact-item-3">
                                <p style="font-size: 14px;color:{{ $resume->primary_color }}">Address</p>
                                <p style="font-size: 14px;">{{ $resume->address }}</p>
                            </li>
                        </ul>
                        <h2 class="sub-heading-3">Education</h2>
                        <ul class="education-list-3" style="margin-bottom: 7px">
                            @forelse($education as $edu)
                                <li class="education-item-3">
                                    <span style="font-size: 14px">
                                        {{ \Carbon\Carbon::parse($edu['startYear'])->format('Y') }} -
                                        {{ \Carbon\Carbon::parse($edu['endYear'])->format('Y') }}</span>
                                    <p style="font-size: 14px;color:{{ $resume->primary_color }}">{{ $edu['degree'] }}
                                    </p>
                                    <p style="font-size: 14px">Grade:{{ $edu['grade'] }}</p>
                                    <p style="font-size: 14px">{{ $edu['institution'] }}</p>
                                </li>
                            @empty
                                <p style="font-size: 14px">No education data available</p>
                            @endforelse
                        </ul>
                        <h2 class="sub-heading-3" style="padding-bottom: 10px">Skills</h2>
                        <table style="width: 100%; padding-top:0px">
                            @forelse($skills as $skill)
                                <tr>
                                    <td style="font-size: 14px;padding-bottom:5px white-space:nowrap;color:#000">
                                        {{ $skill }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="1" style="font-size: 10px; white-space:nowrap;color:#000">
                                        No skills available.
                                    </td>
                                </tr>
                            @endforelse
                        </table>
                        <h2 class="sub-heading-3">Languages</h2>
                        <table style="width: 100%; padding-top:10px">
                            @foreach ($languages as $lan)
                                <tr>
                                    <td style="font-size: 14px; white-space:nowrap;color:{{ $resume->primary_color }}">
                                        {{ $lan }}
                                    </td>

                                </tr>
                            @endforeach
                        </table>
                        <h2 class="sub-heading-3">Interests</h2>
                        <ul class="hobbies-list-3">
                            @foreach ($interestes as $int)
                                <li class="hobbies-item-3" style="color:{{ $resume->primary_color }} ">
                                    {{ $int }}</li>
                            @endforeach
                        </ul>

                    </div>
                </div>

            </td>
        </tr>
    </table>
</body>

</html>
