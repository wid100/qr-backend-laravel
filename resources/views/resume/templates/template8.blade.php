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
            /* font-family: "Arial Narrow", Arial, sans-serif; */
        }

        .main-body-6 {
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

        .qr-image-6 {
            width: 100px;
            height: 100px;
            object-fit: cover;
            margin-top: 20px;
        }

        .sub-heading-6 {
            color: #ffb317;
            font-size: 16px;
            padding: 15px 0;
            border-bottom: 1px solid #000;
            text-transform: uppercase;
            padding-bottom: 6px;
            font-weight: 600;
        }

        .contact-list-6,
        .education-list-6,
        .experience-list-6,
        .language-list-6,
        .hobbies-list-6,
        .certifications-list-6 {
            padding-left: 0px;
        }

        .contact-item-6,
        .education-item-6,
        .experience-item-6,
        .language-item-6,
        .hobbies-item-6,
        .certification-item-6 {
            list-style: none;
            font-size: 12px;
            padding: 4px 0;
            color: #ffffff;
            line-height: 140%;
            transition: background 0.3s;
        }

        .experience-item-6 {
            margin-left: 20px;
        }

        .contact-item-6:hover,
        .education-item-6:hover,
        .experience-item-6:hover,
        .language-item-6:hover,
        .hobbies-item-6:hover,
        .certification-item-6:hover {
            background: rgba(255, 179, 23, 0.2);
        }

        .contact-link-6 {
            color: inherit;
            text-decoration: none;
        }

        .skill-6 {
            list-style-type: none;
            padding: 10px 0;
            font-size: 13px;
            display: flex;
            flex-wrap: wrap;
            color: #fff;
        }

        .skill-6 li {
            width: 50%;
            padding: 5px 0;
        }

        /* Right side styles */
        .right-side-6 {
            background: #ffffff;
            color: #000000;
            padding: 0 30px 30px;

            /* border-left: 1px solid #ccc; */
        }

        .name-heading-6 {
            color: #000000;
            font-size: 30px;
            font-weight: 400;
        }

        .designation-6 {
            font-weight: 400;
            color: #000000;
            margin-top: 10px;
        }

        .description-6 {
            font-size: 16px;
            padding: 0px 0 10px 0;
        }

        .section-heading-6 {
            font-weight: 700;
            color: #000000;
            padding: 8px 0 10px 20px;
            background-color: #F6EADD;
            margin-bottom: 15px;

            font-size: 18px
        }

        .references-6 {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            padding: 10px 0;
        }

        .reference-item-6 {
            color: black;
            line-height: 15px;
            flex: 0 1 calc(50% - 10px);
            box-sizing: border-box;
            font-size: 15px;
            padding: 10px;
            /* border: 1px solid #ccc; */
            border-radius: 5px;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .reference-item-6:hover {
            transform: translateY(-3px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }

        .reference-item-6 h3 {
            padding: 4px 0;
            font-size: 18px;
            font-weight: bold;
        }

        .reference-item-6 p {
            padding: 3px 0;
            margin: 0;
        }

        .reference-item-6 a {
            color: inherit;
            text-decoration: none;
        }

        .reference-item-6 a:hover {
            color: #ffb317;
            text-decoration: underline;
        }

        .image-container-8 {
            position: relative;
            width: 220px;
            height: 80px;
            background-color: #F6EADD;
            padding-top: 20px;
            margin-bottom: 60px;
            display: flex;
            justify-content: center;
            align-items: flex-start;
        }

        .profile-image {
            width: 180px;
            height: 180px;
            object-fit: cover;
            position: absolute;
            top: 70%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .image-container {
            width: 100px;
            height: 200px;
            background-color: #00B2D9;
            margin: 0 auto;
            position: relative;
            text-align: center;
            /* No border-radius for the background container */
        }
    </style>
</head>

<body>
    <table>
        <tr>
            <td colspan="2" style="background-color: {{ $resume->primary_color }}; height: 40px;"></td>
        </tr>
        <tr>
            <!-- Left side -->
            <td class="left-side-6s" style="width: 20%; height:40%; vertical-align: top; z-index: 1;">
                <div class="left-side-6">
                    <div class="image-container-8">
                        @if ($base64Image)
                            <img src="{{ $base64Image }}" alt="Profile-image" class="profile-image">
                        @else
                            <p style="color: {{ $resume->primary_color }}; text-align: center;">No image available</p>
                        @endif
                    </div>
                    <div style="padding:0 20px 20px">

                        <h2 class="sub-heading-6" style="color:#000000; padding-top:20px">Contact</h2>
                        <ul class="contact-list-6">
                            <li class="contact-item-6">
                                <p style="font-size:14px; color:{{ $resume->primary_color }};">Phone</p>
                                <a href="tel:{{ $resume->phone }}" style="color:#000000;"
                                    class="contact-link-6">{{ $resume->phone }}</a>
                            </li>
                            <li class="contact-item-6">
                                <p style="font-size:14px; color:{{ $resume->primary_color }};">Email</p>

                                <a href="mailto:{{ $resume->email }}" class="contact-link-6 "
                                    style="color:#000000;">{{ $resume->email }}</a>
                            </li>
                            <li class="contact-item-6">
                                <p style="font-size:14px;color:{{ $resume->primary_color }};">Address</p>
                                <p style="font-size: 10px; color:#000000;">{{ $resume->address }}</p>
                            </li>
                        </ul>

                    </div>
                    <div
                        style="background-color: #F6EADD; padding: 20px; position: absolute; height: 660px;bottom: 0;width: 23%;">
                        <h2 class="sub-heading-6" style="color: #000">Education</h2>
                        <ul class="education-list-6" style="margin-bottom: 7px">
                            @forelse($education as $edu)
                                <li class="education-item-6">
                                    <span style="font-size: 12px; color: #000">
                                        {{ \Carbon\Carbon::parse($edu['startYear'])->format('Y') }} -
                                        {{ \Carbon\Carbon::parse($edu['endYear'])->format('Y') }}</span>
                                    <p style="font-size: 14px;color:{{ $resume->primary_color }};">
                                        {{ $edu['degree'] }}
                                    </p>
                                    <p style="font-size: 12px; color:#000">{{ $edu['grade'] }}</p>
                                    <p style="font-size: 12px; color:#000">{{ $edu['institution'] }}</p>
                                </li>
                            @empty
                                <p style="font-size: 12px">No education data available</p>
                            @endforelse

                        </ul>
                        <h2 class="sub-heading-6" style="padding-bottom: 10px; color:#000">Skills</h2>

                        <table style="width: 100%; padding-top: 10px;">
                            @forelse($skills as $skill)
                                <tr>
                                    <td style="font-size: 14px;padding-bottom:3px; white-space:nowrap; color:#000">
                                        {{ $skill }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="1" style="font-size: 14px; white-space:nowrap; color:#000">
                                        No skills available.
                                    </td>
                                </tr>
                            @endforelse
                            {{-- @forelse(collect($skills)->chunk(2) as $chunk)
                                <tr>
                                    @foreach ($chunk as $skill)
                                        <td style="font-size: 10px; white-space: nowrap;">
                                            <span>{{ $skill }}</span>
                                        </td>
                                    @endforeach

                                    @if ($chunk->count() < 2)
                                        <td></td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" style="font-size: 12px; white-space: nowrap; color: #000;">
                                        No skills available.
                                    </td>
                                </tr>
                            @endforelse --}}
                        </table>


                        <h2 class="sub-heading-6" style="color:#000">Languages</h2>
                          <ul class="language-list-6">
                            @foreach ($languages as $lan)
                                <li class="language-item-6">{{ $lan }}</li>
                            @endforeach
                        </ul>
                        <table style="width: 100%; padding-top: 10px;">
                            {{-- @foreach ($languages as $lan)
                                <li class="language-item-6">{{ $lan }}</li>
                            @endforeach --}}
                            {{-- @forelse(collect($languages)->chunk(2) as $chunk)
                                <tr>
                                    @foreach ($chunk as $language)
                                        <td
                                            style="font-size: 12px; white-space: nowrap; color: {{ $resume->primary_color }};">
                                            {{ $language }}
                                        </td>
                                    @endforeach

                                    @if ($chunk->count() < 2)
                                        <td></td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2"
                                        style="font-size: 12px; white-space: nowrap; color: {{ $resume->primary_color }};">
                                        No languages available.
                                    </td>
                                </tr>
                            @endforelse --}}
                        </table>

                        <h2 class="sub-heading-6" style="color:#000">Interests</h2>
                        <ul class="hobbies-list-6">
                            @foreach ($interestes as $int)
                                <li class="hobbies-item-6" style="color:{{ $resume->primary_color }};">
                                    {{ $int }}</li>
                            @endforeach

                        </ul>
                    </div>

                </div>
            </td>

            <!-- Right side -->
            <td style="width: 80%; background-color: white;vertical-align: top;padding-top:2px ">
                <div class="right-side-6">
                    <table>
                        <tr>
                            <td>
                                <h1 class="name-heading-6"><b>{{ $resume->fname }}</b> {{ $resume->lname }}</h1>
                                <p class="designation-6">{{ $resume->profession }}</p>
                            </td>
                            <td style="text-align: right;">
                                @if (isset($qrCodeBase64))
                                    <img src="{{ $qrCodeBase64 }}"
                                        style="width: 100px; height:100px; position: relative; top: -42px"
                                        alt="QR Code" class="qr-image-6" />
                                @endif
                            </td>
                        </tr>
                    </table>
                    <p class="description-6" style="font-size: 12px">
                        {!! strip_tags($resume->description) !!}
                    </p>
                    <h2 class="section-heading-6" style="margin-top: 15px">Experience</h2>
                    <ul class="experience-list-6s">
                        @foreach ($experiences as $exp)
                            <li class="experience-item-6" style="color: #000">

                                <p style="margin-bottom:5px; font-size:12px">
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
                                <p style="font-size: 15px; padding-bottom:7px">{{ $exp['jobTitle'] }}</p>
                                <p style="font-size: 12px; padding-right: 20px;">{!! strip_tags($exp['description']) !!}</p>
                            </li>
                        @endforeach

                    </ul>
                    <h2 class="section-heading-6" style="margin-top: 15px">References</h2>
                    <table style="width: 100%;">
                        <tr>
                            @foreach ($references as $reference)
                                <td>
                                    <div style="margin-left: 20px">
                                        <h3 style="font-size: 16px; padding-bottom:10px">{{ $reference['firstName'] }}
                                            {{ $reference['lastName'] }}</h3>
                                        <p style="font-size: 12px; padding-bottom:5px">{{ $reference['jobTitle'] }}</p>
                                        <p style="font-size: 12px; padding-bottom:5px">Phone: <span> <a
                                                    href='tel:{{ $reference['phone'] }}'
                                                    class="contact-link-6">{{ $reference['phone'] }}</a></span>
                                        </p>
                                        <p style="font-size: 12px;padding-bottom:5px">Email: <a
                                                href="mailto:{{ $reference['email'] }}"
                                                class="contact-link-6">{{ $reference['email'] }}</a> </p>
                                    </div>
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
