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
            font-family: 'inter';
        }

        body {
            background: #f9f9f9;
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

        .qr-image-6-con {
            display: flex;
            justify-content: center;
            width: 100%;
            align-items: center;
            margin: auto;
        }

        .sub-heading-6 {
            color: #fff;
            font-size: 16px;
            padding: 15px 0;
            border-bottom: 1px solid #fff;
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
            padding-left: 0;
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
            color: #fff;
            line-height: 140%;
            transition: background 0.3s;
        }

        .experience-item-6{
            border-bottom: 1px solid #B5B5B5;
        }

        .experience-item-6:last-child{
            border-bottom: none;
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
            padding: 0 30px 30px 30px;
        }

        .name-heading-6 {
            color: #fff;
            font-size: 30px;
            font-weight: 400;
        }

        .designation-6 {
            font-weight: 400;
            color: #fff;
            margin-top: 10px;
        }

        .description-6 {
            font-size: 16px;
            color: #fff;
            padding: 10px 0 10px 0;
        }

        .section-heading-6 {
            font-weight: 700;
            color: #000000;
            padding: 8px 0 10px 0px;
            border-bottom: 1px solid #000;
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
            border: 1px solid #ccc;
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
            color: #4391CF;
            text-decoration: underline;
        }



        /* Responsive */
    </style>
</head>

<body>
    <table>
        <tr>


            <!-- Right side -->
            <td style="width: 80%; background-color: white;vertical-align: top; ">
                <div style="padding:25px 25px 0 30px; color:#000">
                    <h1 class="name-heading-6" style="color:#000"><b>{{ $resume->fname }}</b> {{ $resume->lname }}</h1>
                    <p class="designation-6" style="color:#000">{{ $resume->profession }}</p>
                    <p class="description-6" style="font-size: 12px; color:#000">
                        {{ $resume->description }}
                    </p>
                </div>
                <div class="right-side-6">

                    <h2 class="section-heading-6">Experience</h2>
                    <ul class="experience-list-6">
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
                                <p style="font-size: 12px; padding-right: 20px;">{{ $exp['description'] }}</p>
                            </li>
                        @endforeach

                    </ul>
                    <h2 class="section-heading-6" style="margin-top: 15px">References</h2>
                    <table style="width: 100%;">
                        <tr>
                            @foreach ($references as $reference)
                                <td>
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
                                </td>
                            @endforeach
                        </tr>
                    </table>
                </div>
            </td>
            <!-- Left side -->
            <td class="left-side-6s" style="width: 20%;  vertical-align: top; background-color: #F5F5F5;">
                <div class="left-side-6">
                    <div>
                        <div style="width: 100%;text-align: center;">
                            @if ($base64Image)
                                <img src="{{ $base64Image }}" alt="Image error!"
                                    style="width: 210px;height: 200px; object-fit: cover; position: relative;object-fit: cover;">
                            @else
                                <p>No image available</p>
                            @endif
                        </div>
                        <div class="left-site-bg" style="background:#989898;height:902px; padding:0px 20px 20px 20px ;clip-path: polygon(0 8%, 100% 0, 100% 100%, 0 100%); position: relative;">
                            <table>
                                <tr>
                                    <td align="center">
                                        <div class="qr-image-6-con">
                                            <img src="https://i.postimg.cc/cLwdGbsf/QR.png" alt="QR Code"
                                                class="qr-image-6" />
                                        </div>
                                    </td>
                                </tr>
                            </table>
                            <h2 class="sub-heading-6" style="color: #fff">Contact</h2>
                            <ul class="contact-list-6">
                                <li class="contact-item-6">
                                    <p style="font-size:14px; color:#fff;">Phone</p>
                                    <a href="tel:{{ $resume->phone }}" style="color:#fff;"
                                        class="contact-link-6">{{ $resume->phone }}</a>
                                </li>
                                <li class="contact-item-6">
                                    <p style="font-size:14px; color:#fff;">Email</p>
                                    <a href="mailto:{{ $resume->email }}" class="contact-link-6 "
                                        style="color:#fff;">{{ $resume->email }}</a>
                                </li>
                                <li class="contact-item-6" style="color: #fff">
                                    <p style="font-size:14px;color:#fff;">Address</p>
                                    <p style="font-size: 10px; color:#fff;">{{ $resume->address }}</p>
                                </li>
                            </ul>
                            <h2 class="sub-heading-6" style="color: #fff">Education</h2>
                            <ul class="education-list-6">
                                @forelse($education as $edu)
                                    <li class="education-item-6">
                                        <span style="font-size: 12px; color: #fff">
                                            {{ \Carbon\Carbon::parse($edu['startYear'])->format('Y') }} -
                                            {{ \Carbon\Carbon::parse($edu['endYear'])->format('Y') }}</span>
                                        <p style="font-size: 14px;color:#edebeb;">{{ $edu['degree'] }}
                                        </p>
                                        <p style="font-size: 12px; color:#fff">Grade:{{ $edu['grade'] }}</p>
                                        <p style="font-size: 12px; color:#fff">{{ $edu['institution'] }}</p>
                                    </li>
                                @empty
                                    <p style="font-size: 12px">No education data available</p>
                                @endforelse
                            </ul>
                            <h2 class="sub-heading-6" style="padding-bottom: 10px;color: #fff">Skills</h2>

                            <table style="width: 100%; padding-top:10px">
                                @forelse(collect($skills)->chunk(2) as $chunk)
                                <tr>
                                    @foreach ($chunk as $skill)
                                        <td style="font-size: 10px; white-space: nowrap;color: #fff;">
                                            <span>{{ $skill }}</span>
                                        </td>
                                    @endforeach

                                    @if ($chunk->count() < 2)
                                        <td></td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" style="font-size: 12px; white-space: nowrap; color: #fff;">
                                        No skills available.
                                    </td>
                                </tr>
                            @endforelse

                            </table>
                            <h2 class="sub-heading-6">Languages</h2>
                            <table style="width: 100%; padding-top: 10px;">
                                @forelse(collect($languages)->chunk(2) as $chunk)
                                    <tr>
                                        @foreach ($chunk as $language)
                                            <td style="font-size: 12px; white-space: nowrap;color: #fff;">
                                                {{ $language }}
                                            </td>
                                        @endforeach

                                        @if ($chunk->count() < 2)
                                            <td></td>
                                        @endif
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" style="font-size: 12px; white-space: nowrap;color: #fff;">
                                            No languages available.
                                        </td>
                                    </tr>
                                @endforelse
                            </table>
                            {{-- <ul class="language-list-6">
                                @foreach ($languages as $lan)
                                    <li class="language-item-6" style="color:#fff;">{{ $lan }}</li>
                                @endforeach
                            </ul> --}}
                            <h2 class="sub-heading-6">Interests</h2>
                            <ul class="hobbies-list-6">
                                @foreach ($interestes as $int)
                                    <li class="hobbies-item-6" style="color:#fff;">{{ $int }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
    </table>
</body>

</html>
