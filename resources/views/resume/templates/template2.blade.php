<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
   <title>{{ $resume->fname }} {{ $resume->lname }}</title>
   {{-- {{dd($resume)}} --}}
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

        .main-body-2 {
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

        .qr-image-2 {
            width: 100px;
            height: 100px;
            object-fit: cover;
            margin-top: 20px;
        }

        .sub-heading-2 {
            color: #8c3494;
            font-size: 16px;
            padding: 15px 0;
            border-bottom: 1px solid #000;
            text-transform: uppercase;
            padding-bottom: 6px;
            font-weight: 600;
        }

        .contact-list-2,
        .education-list-2,
        .experience-list-2,
        .language-list-2,
        .hobbies-list-2,
        .certifications-list-2 {
            padding-left: 0;

        }

        .contact-item-2,
        .education-item-2,
        .experience-item-2,
        .language-item-2,
        .hobbies-item-2,
        .certification-item-2 {
            list-style: none;
            font-size: 12px;
            padding: 4px 0;
            color: #000000;
            line-height: 140%;
            transition: background 0.3s;
        }

        .contact-item-2:hover,
        .education-item-2:hover,
        .experience-item-2:hover,
        .language-item-2:hover,
        .hobbies-item-2:hover,
        .certification-item-2:hover {
            background: rgba(255, 179, 23, 0.2);
        }

        .contact-link-2 {
            color: inherit;
            text-decoration: none;
        }

        .skill-2 {
            list-style-type: none;
            padding: 10px 0;
            font-size: 13px;
            display: flex;
            flex-wrap: wrap;
            color: #fff;
        }

        .skill-2 li {
            width: 50%;
            padding: 5px 0;
        }

        /* Right side styles */
        .right-side-2 {
            background: #f5f5f5;
            color: #000000;
            padding: 30px;
        }

        .name-heading-2 {
            color: #8c3494;
            font-size: 30px;
            font-weight: 400;
        }

        .designation-2 {
            font-weight: 400;
            color: #000000;
            margin-top: 10px;
        }

        .description-2 {
            font-size: 16px;
            padding: 10px 0 10px 0;
        }

        .section-heading-2 {
            font-weight: 700;
            color: #8c3494;
            border-bottom: 1px solid #000;
            padding-bottom: 5px;
            margin-bottom: 15px;
            text-transform: uppercase;
            font-size: 18px
        }

        .references-2 {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            padding: 10px 0;
        }

        .reference-item-2 {
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

        .reference-item-2:hover {
            transform: translateY(-3px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }

        .reference-item-2 h3 {
            padding: 4px 0;
            font-size: 18px;
            font-weight: bold;
        }

        .reference-item-2 p {
            padding: 3px 0;
            margin: 0;
        }

        .reference-item-2 a {
            color: inherit;
            text-decoration: none;
        }

        .reference-item-2 a:hover {
            color: #8c3494;
            text-decoration: underline;
        }
  .left-side-2 {
            padding: 0 30px;
        }
        /* Responsive */
    </style>
</head>

<body>
    <table>
        <tr>
            <!-- Left side -->
            <td
                style="width: 20%; height:100%; vertical-align: top; background-color: #ffffff;border-left:10px solid {{ $resume->primary_color }}">
                <div class="left-side-2">
                    <div style="width: 100%;text-align: center;padding-top:20px">
                        @if ($base64Image)
                            <img src="{{ $base64Image }}" alt="Image error!"
                                style="width: 170px;height: 170px; object-fit: cover; position: relative;z-index: 1;border: 2px solid #ffffff;border-radius: 50%;object-fit: cover;">
                        @else
                            <p>No image available</p>
                        @endif
                    </div>
                    <div style="padding:20px 0">
                        <h2 class="sub-heading-2">Contact</h2>
                        <ul class="contact-list-2">
                            <li class="contact-item-2">
                                <p style="font-size: 14px">Phone</p>
                                <a href="tel:{{ $resume->phone }}" class="contact-link-2">{{ $resume->phone }}</a>
                            </li>
                            <li class="contact-item-2">
                                <p style="font-size: 14px">Email</p>
                                <a href="mailto:{{ $resume->email }}" class="contact-link-2">{{ $resume->email }}</a>
                            </li>
                            <li class="contact-item-2">
                                <p style="font-size: 14px">Address</p>
                                <p style="font-size: 12px;">{{ $resume->address }}</p>
                            </li>
                        </ul>
                        <h2 class="sub-heading-2">Education</h2>
                        <ul class="education-list-2" style="margin-bottom: 7px">
                            @forelse($education as $edu)
                                <li class="education-item-2">
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
                        <h2 class="sub-heading-2" style="padding-bottom: 10px">Skills</h2>

                        <table style="width: 100%; padding-top:10px">
                            @forelse($skills as $skill)
                                <tr>
                                    <td style="font-size: 12px;padding-bottom:3px; white-space:nowrap;">
                                        {{ $skill }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="1" style="font-size: 12px; white-space:nowrap;">
                                        No skills available.
                                    </td>
                                </tr>
                            @endforelse

                        </table>
                        <h2 class="sub-heading-2">Languages</h2>
                        <ul class="language-list-2">
                            @foreach ($languages as $lan)
                                <li class="language-item-2">{{ $lan }}</li>
                            @endforeach
                        </ul>
                        <h2 class="sub-heading-2">Interests</h2>
                        <ul class="hobbies-list-2">
                              @foreach ($interestes as $int)
                                <li class="hobbies-item-2">{{ $int }}</li>
                            @endforeach
                        </ul>

                    </div>
                </div>
            </td>

            <!-- Right side -->
            <td style="width: 80%; background-color: #f5f5f5;vertical-align: top; ">
                <div class="right-side-2">
                    <table>
                        <tr>
                            <td>
                                <h1 style="color: {{ $resume->primary_color }}" class="name-heading-1">
                                    <b>{{ $resume->fname }}</b> {{ $resume->lname }}
                                </h1>
                                <p class="designation-2">{{ $resume->profession }}</p>
                                <p class="description-2" style="font-size: 14px; padding-right:15px">
                                    {{ $resume->description }}
                                </p>
                            </td>
                            <td style="text-align: right;">
                                <img src="https://i.postimg.cc/cLwdGbsf/QR.png" alt="QR Code" class="qr-image-2" />
                            </td>
                        </tr>
                    </table>
                    <h2 class="section-heading-2" style="margin-top: 15px">Experience</h2>
                    <ul class="experience-list-2">
                           @foreach ($experiences as $exp)
                            <li class="experience-item-2" style="color: #000;  margin-bottom:20px;">

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
                    <h2 class="section-heading-2" style="margin-top: 15px">References</h2>
                    <table style="width: 100%;">
                        <tr>
                               @foreach ($references as $reference)
                                <td>
                                    <h3 style="font-size: 16px; padding-bottom:7px">{{ $reference['firstName'] }}
                                        {{ $reference['lastName'] }}</h3>
                                    <p style="font-size: 12px; padding-bottom:5px">{{ $reference['jobTitle'] }}</p>
                                    <p style="font-size: 12px; padding-bottom:5px">Phone: <span> <a
                                                href='tel:{{ $reference['phone'] }}'
                                                class="contact-link-2">{{ $reference['phone'] }}</a></span>
                                    </p>
                                    <p style="font-size: 12px;padding-bottom:5px">Email: <a
                                            href="mailto:{{ $reference['email'] }}"
                                            class="contact-link-2">{{ $reference['email'] }}</a> </p>
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
