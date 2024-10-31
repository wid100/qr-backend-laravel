<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $resume->fname }} {{ $resume->lname }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'inter';
        }

        body {
            background: #ffffff;

        }

        .main-body-14 {
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

        .qr-image-14 {
            width: 100px;
            height: 100px;
            object-fit: cover;
            margin-top: 20px;
        }

        .sub-heading-14 {
            color: #000000;
            font-size: 16px;
            padding: 15px 0;
            text-align: center;
            text-transform: uppercase;
            padding-bottom: 6px;
            font-weight: 600;
        }

        .sub-heading-14:first-child {
            padding-top: 0;
        }


        .contact-list-14,
        .education-list-14,
        .reference-list-14,
        .experience-list-14,
        .language-list-14,
        .hobbies-list-14,
        .skillnews-list-14 {
            padding-left: 0;

        }

        .contact-item-14,
        .education-item-14,
        .reference-item-14,
        .experience-item-14,
        .language-item-14,
        .hobbies-item-14,
        .skillnew-item-14 {
            list-style: none;
            font-size: 12px;
            padding: 4px 0;
            color: #000000;
            line-height: 140%;
            transition: background 0.3s;
        }

        .experience-item-14 {
            border-bottom: 1px solid #000;
        }

        .experience-item-14:last-child {
            border-bottom: none;
        }

        .contact-item-14,
        .reference-item-14 {
            text-align: center;
        }

        .contact-item-14:hover,
        .education-item-14:hover,
        .reference-item-14:hover,
        .experience-item-14:hover,
        .language-item-14:hover,
        .hobbies-item-14:hover,
        .skillnew-item-14:hover {
            background: rgba(255, 179, 23, 0.2);
        }

        .contact-link-14 {
            color: inherit;
            text-decoration: none;
        }

        /* Top section with name and contact */
        .top-section-14 {
            color: #ffffff;
            background-color: #2E3E4E;
            text-align: center;
            padding: 20px 0;
            display: flex;
            align-items: center;
        }

        .top-section-14 h1 {
            margin-bottom: 5px;
            font-size: 28px;
        }

        .top-section-14 p {
            margin: 5px 0;
        }

        .qr-section-14 {
            text-align: right;
        }

        .qr-section-14 img {
            width: 100px;
            height: auto;
        }

        /* Right side styles */
        .right-side-14 {
            background: #ffffff;
            color: #000000;
            padding: 30px 30px 30px 0px;
        }

        .name-heading-14 {
            color: #000000;
            font-size: 30px;
            font-weight: 400;
        }

        .designation-14 {
            font-weight: 400;
            color: #000000;
            margin-top: 10px;
        }

        .description-14 {
            font-size: 16px;
        }

        .section-heading-14 {
            font-weight: 700;
            color: #000000;
            border-bottom: 1px solid #000;
            padding-bottom: 5px;
            margin-bottom: 15px;
            text-transform: uppercase;
            font-size: 18px
        }
    </style>


</head>

<body>

    <!-- Top section -->
    <div class="top-section-14" style="background:{{$resume->primary_color}}">
        <table width="100%">
            <tr>
                <!-- Profile Image Section -->
                <td width="20%">
                </td>

                <!-- Name and Title Section -->
                <td align="center" width="60%">
                    <h1 style="font-size: 1.8rem; margin: 0;"><b>{{ $resume->fname }}</b> {{ $resume->lname }}</h1>
                    <p style="font-size: 1.2rem; margin: 0;">{{ $resume->profession }}</p>
                </td>

                <!-- QR Code Section -->
                <td align="center" width="20%">
                    @if (isset($qrCodeBase64))
                        <img src="{{ $qrCodeBase64 }}" alt="QR Code" class="qr-image-6"
                            style="width: 100px; height:100px" />
                    @endif
                </td>
            </tr>
        </table>

    </div>


    <!-- Main content table -->
    <table>
        <tr>

            <!-- Left side -->
            <td style="width: 40%;  vertical-align: top; background-color: #ffffff; padding:20px;">
                <div class="left-side-14">
                    <div>
                        <div style="width: 100%;text-align: center;portion: relative;margin-top:-110px">
                            @if ($base64Image)
                                <img src="{{ $base64Image }}" alt="Image error!" class="profile-image"
                                    style="width: 170px;height: 170px; object-fit: cover;border-radius: 50%;border: 5px solid #ffffff">
                            @else
                                <p class="no-image-text">No image available</p>
                            @endif
                        </div>
                        <h2 class="sub-heading-14">Contact</h2>
                        <ul class="contact-list-14">
                            <li class="contact-item-14">
                                <p style="font-size: 14px">Phone</p>
                                <a href="tel:{{ $resume->phone }}" class="contact-link-14">{{ $resume->phone }}</a>
                            </li>
                            <li class="contact-item-14">
                                <p style="font-size: 14px">Email</p>
                                <a href="mailto:{{ $resume->email }}" class="contact-link-14">{{ $resume->email }}</a>
                            </li>
                            <li class="contact-item-14">
                                <p style="font-size: 14px">Address</p>
                                <p> {{ $resume->address }}</p>
                            </li>
                        </ul>

                        <h2 class="sub-heading-14" style="padding-bottom: 10px">Skills</h2>

                        <table style="width: 100%; padding-top:10px;text-align: center">
                            @forelse($skills as $skill)
                                <tr>
                                    <td style="font-size: 12px;padding-bottom:3px; white-space:nowrap; color:#000">
                                        {{ $skill }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="1" style="font-size: 12px; white-space:nowrap; color:#000">
                                        No skills available.
                                    </td>
                                </tr>
                            @endforelse
                        </table>
                        <h2 class="sub-heading-14">Languages</h2>
                        <table style="width: 100%; padding-top:10px; text-align: center">
                            @foreach ($languages as $lan)
                                <tr>
                                    <td style="font-size: 14px; white-space: nowrap;">
                                        <span class="custom-border">{{ $lan }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </table>


                        <h2 class="sub-heading-14">Interests</h2>
                        <table style="width: 100%; padding-top:10px; text-align: center">
                            @foreach ($interestes as $int)
                                <tr>
                                    <td style="font-size: 14px; white-space: nowrap;">
                                        <span class="custom-border">{{ $int }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        <h2 class="sub-heading-14">Referances</h2>
                        <ul class="reference-list-14" style="margin-bottom: 7px">
                            @foreach ($references as $reference)
                                <li class="reference-item-14">
                                    <h3 style="font-size: 16px; padding-bottom:7px">{{ $reference['firstName'] }}
                                        {{ $reference['lastName'] }}</h3>
                                    <p style="font-size: 12px; padding-bottom:5px">{{ $reference['jobTitle'] }}</p>
                                    <p style="font-size: 12px; padding-bottom:5px">Phone: <span> <a
                                                href='tel:{{ $reference['phone'] }}'
                                                class="contact-link-14">{{ $reference['phone'] }}</a></span>
                                    </p>
                                    <p style="font-size: 12px;padding-bottom:5px">Email: <a
                                            href="mailto:{{ $reference['email'] }}"
                                            class="contact-link-14">{{ $reference['email'] }}</a> </p>
                                </li>
                            @endforeach

                        </ul>
                    </div>
                </div>
            </td>

            <!-- Right side -->
            <td style="width: 80%; background-color: #ffffff;vertical-align: top; ">
                <div class="right-side-14">
                    <p class="description-14" style="font-size: 12px">
                        {!! strip_tags($resume->description) !!}
                    </p>
                    <h2 class="section-heading-14" style="margin-top: 15px">Experience</h2>
                    <ul class="experience-list-14">
                        @foreach ($experiences as $exp)
                            <li class="experience-item-14"
                                style="color: #000;border-bottom: 1px solid #000; margin-bottom:20px">

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
                    <h2 class="section-heading-14" style="margin-top: 15px">Education</h2>
                    <ul class="education-list-14" style="margin-bottom: 7px">

                        @forelse($education as $edu)

                            <li class="education-item-14">
                                <div>
                                    <table width="100%">
                                        <tr>
                                            <td style="font-size:14px; text-align: left;">
                                                <p style="margin: 0;">{{ $edu['degree'] }}</p>
                                            </td>
                                            <td style="font-size:12px; text-align: right; vertical-align: top;">
                                                <span> {{ \Carbon\Carbon::parse($edu['startYear'])->format('F Y') }} -
                                                    {{ \Carbon\Carbon::parse($edu['endYear'])->format('F Y') }}</span>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <p style="font-size: 12px">
                                    <span>Grade:{{ $edu['grade'] }}</span>
                                    <span>,</span>
                                    <span>{{ $edu['institution'] }}</span>
                                </p>
                            </li>
                        @empty
                            <p style="font-size: 12px">No education data available</p>
                        @endforelse
                
                    </ul>
                </div>
            </td>
        </tr>
    </table>
</body>

</html>
