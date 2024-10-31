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

        .main-body-11 {
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

        .qr-image-11 {
            width: 100px;
            height: 100px;
            object-fit: cover;
            margin-top: 20px;
        }

        .sub-heading-11 {
            color: #C55911;
            font-size: 16px;
            padding: 15px 0;
            /* border-bottom: 2px solid #000; */
            text-align: center;
            text-transform: uppercase;
            padding-bottom: 6px;
            font-weight: 600;
        }

        .sub-heading-11:first-child {
            padding-top: 0;
        }


        .contact-list-11,
        .education-list-11,
        .experience-list-11,
        .language-list-11,
        .hobbies-list-11,
        .skillnews-list-11 {
            padding-left: 0;

        }

        .contact-item-11,
        .education-item-11,
        .experience-item-11,
        .language-item-11,
        .hobbies-item-11,
        .skillnew-item-11 {
            list-style: none;
            font-size: 14px;
            padding: 4px 0;
            color: #000000;
            line-height: 140%;
            transition: background 0.3s;
        }

        .experience-item-11 {
            border-bottom: 1px solid #B5B5B5;
        }

        .experience-item-11:last-child {
            border-bottom: none;
        }

        .contact-item-11 {
            text-align: center;
        }

        .education-item-11,
        .language-item-11,
        .hobbies-item-11,
        .skillnew-item-11 {
            text-align: center;
            border-bottom: 1px solid #d9d9d9;
        }

        .contact-item-11:hover,
        .education-item-11:hover,
        .experience-item-11:hover,
        .language-item-11:hover,
        .hobbies-item-11:hover,
        .skillnew-item-11:hover {
            background: rgba(255, 179, 23, 0.2);
        }

        .contact-link-11 {
            color: inherit;
            text-decoration: none;
        }

        .custom-border {
            display: inline-block;
            border-bottom: 1px solid #d9d9d9;
            padding-bottom: 5px;
            padding-top: 5px;
            width: 70%;
            margin: 0 auto;
        }


        .skill-11 {
            list-style-type: none;
            padding: 10px 0;
            font-size: 13px;
            display: flex;
            flex-wrap: wrap;
            color: #fff;
        }

        .skill-11 li {
            width: 50%;
            padding: 5px 0;
        }

        /* Right side styles */
        .right-side-11 {
            background: #ffffff;
            color: #000000;
            padding: 30px 30px 30px 0px;
        }

        .name-heading-11 {
            color: #C55911;
            font-size: 30px;
            font-weight: 400;
        }

        .designation-11 {
            font-weight: 400;
            color: #000000;
            margin-top: 10px;
        }

        .description-11 {
            font-size: 16px;
            padding: 10px 0 10px 0;
        }

        .section-heading-11 {
            font-weight: 700;
            color: #C55911;
            border-bottom: 1px solid #d9d9d9;
            padding-bottom: 5px;
            margin-bottom: 15px;
            text-transform: uppercase;
            font-size: 18px
        }

        .references-11 {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            padding: 10px 0;
        }

        .reference-item-11 {
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

        .reference-item-11:hover {
            transform: translateY(-3px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }

        .reference-item-11 h3 {
            padding: 4px 0;
            font-size: 18px;
            font-weight: bold;
        }

        .reference-item-11 p {
            padding: 3px 0;
            margin: 0;
        }

        .reference-item-11 a {
            color: inherit;
            text-decoration: none;
        }

        .reference-item-11 a:hover {
            color: #C55911;
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <table>
        <tr>
            <!-- Left side -->
            <td style="width: 45%; height:100%; vertical-align: top; background-color: #ffffff;">
                <div class="left-side-11">

                    <div style="padding:20px;">
                        <div style="width: 100%;">
                            <h1 class="name-heading-11" style="color:{{ $resume->primary_color }}"> <b>{{ $resume->fname }}</b> {{ $resume->lname }}</h1>
                            <p class="designation-11">{{ $resume->profession }}</p>
                            <p class="description-11" style="font-size: 14px">
                                {!! strip_tags($resume->description) !!}
                            </p>
                        </div>

                        <div style="width: 100%;text-align: center;padding-top:20px;">
                            @if ($base64Image)
                                <img src="{{ $base64Image }}" alt="Image error!" class="profile-image"
                                    style=" width: 170px;height: 170px; object-fit: cover;">
                            @else
                                <p class="no-image-text">No image available</p>
                            @endif
                        </div>
                    </div>
                    <div style="padding:0 20px ;">
                        <h2 class="sub-heading-11" style="color: {{ $resume->primary_color }}">Education</h2>
                        <ul class="education-list-11" style="margin-bottom: 7px">
                            @forelse($education as $edu)
                                <li class="education-item-11">
                                    <span style="font-size: 14px">
                                        {{ \Carbon\Carbon::parse($edu['startYear'])->format('F Y') }} -
                                        {{ \Carbon\Carbon::parse($edu['endYear'])->format('F Y') }}</span>
                                    <p style="font-size: 14px">{{ $edu['degree'] }}
                                    </p>
                                    <p style="font-size: 14px">Grade:{{ $edu['grade'] }}</p>
                                    <p style="font-size: 14px">{{ $edu['institution'] }}</p>
                                </li>
                            @empty
                                <p style="font-size: 14px">No education data available</p>
                            @endforelse

                        </ul>
                        <h2 class="sub-heading-11" style="padding-bottom: 10px; color: {{ $resume->primary_color }}">Skills</h2>

                        <ul class="skillnews-list-11">
                            @forelse($skills as $skill)
                                <li class="skillnew-item-11"> {{ $skill }}</li>
                            @empty
                                <li class="skillnew-item-11">
                                    No skills available.
                                </li>
                            @endforelse
                        </ul>
                        <h2 class="sub-heading-11"  style="color: {{ $resume->primary_color }}">Languages</h2>
                        <table style="width: 100%; padding-top:10px; text-align: center">
                            @foreach ($languages as $lan)
                                <tr>
                                    <td style="font-size: 14px; white-space: nowrap;">
                                        <span class="custom-border">{{ $lan }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </table>


                        <h2 class="sub-heading-11"  style="color: {{ $resume->primary_color }}">Interests</h2>
                        <table style="width: 100%; padding-top:10px; text-align: center">
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
            <td style="width: 80%; background-color: #ffffff;vertical-align: top; ">
                <div class="right-side-11">
                    <table>
                        <tr>
                            <td style="vertical-align: bottom;text" align="center">
                                <h4>Address</h4>
                                <p class="description-1" style="font-size: 14px">
                                    {{ $resume->address }}
                                </p>
                            </td>
                            <td style="margin-left:20px;">
                                <div style="text-align: center">

                                    @if (isset($qrCodeBase64))
                                        <img src="{{ $qrCodeBase64 }}" alt="QR Code" class="qr-image-6" style="width: 100px; padding-bottom:20px; height:100px" />
                                    @endif
                                    <p style="font-size: 14px; padding-bottom:5px"><span
                                            style="font-size: 14px;display: block">Phone</span>
                                        <a href="tel:{{ $resume->phone }}"
                                            class="contact-link-11">{{ $resume->phone }}</a>
                                    </p>
                                    <p style="font-size: 14px;padding-bottom:5px"><span
                                            style="font-size: 14px">Email</span>
                                        <a href="mailto:{{ $resume->email }}"
                                            class="contact-link-11">{{ $resume->email }}</a>
                                    </p>
                                </div>
                            </td>
                        </tr>

                    </table>
                    <h2 class="section-heading-11" style="margin-top: 15px; color: {{ $resume->primary_color }}">Experience</h2>
                    <ul class="experience-list-11">
                        @foreach ($experiences as $exp)
                            <li class="experience-item-11" style="color: #000; margin-bottom:20px">

                                <p style="margin-bottom:5px; font-size:14px">
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
                                <p style="font-size: 17px; padding-bottom:7px">{{ $exp['jobTitle'] }}</p>
                                <p style="font-size: 16px; line-height:130%; padding-right: 20px;">
                                       {!! strip_tags($exp['description']) !!}</p>
                            </li>
                        @endforeach

                    </ul>
                    <h2 class="section-heading-11" style="margin-top: 15px;color: {{ $resume->primary_color }}">References</h2>
                    <table style="width: 100%;">
                        <tr>
                            @foreach ($references as $reference)
                                <td>
                                    <h3 style="font-size: 16px; padding-bottom:7px">{{ $reference['firstName'] }}
                                        {{ $reference['lastName'] }}</h3>
                                    <p style="font-size: 14px; padding-bottom:5px">{{ $reference['jobTitle'] }}</p>
                                    <p style="font-size: 14px; padding-bottom:5px">Phone: <span> <a
                                                href='tel:{{ $reference['phone'] }}'
                                                class="contact-link-11">{{ $reference['phone'] }}</a></span>
                                    </p>
                                    <p style="font-size: 14px;padding-bottom:5px">Email: <a
                                            href="mailto:{{ $reference['email'] }}"
                                            class="contact-link-11">{{ $reference['email'] }}</a> </p>
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
