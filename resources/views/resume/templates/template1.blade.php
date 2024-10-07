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
            margin: 0;
            padding: 0;
            border: 0;
        }

        body {
            margin: 0px;
            padding: 0px;
            font-family: 'Nunito', sans-serif;
            background: white;
        }

        table {
            width: 100%;
            table-layout: fixed;
            margin: 20px;
            border-spacing: 0;
            box-shadow: 4px 4px 10px 4px #484848;
        }

        td {
            padding: 20px;
        }

        .header {
            display: flex;
            align-items: center;
        }

        .header img {
            border-radius: 50%;
            width: 150px;
            height: 150px;
            border: 3px solid white;
        }

        .header h1 {
            color: #D19855;
            -webkit-text-stroke: 1px black;
            font-size: 32px;
            font-weight: normal;
            text-shadow: 0px 5px 10px black;
        }

        .header p {
            margin-top: 10px;
            font-size: 18px;
        }

        .contact-info {
            background-color: #484848;
            color: white;
            padding: 30px;
            height: auto;
        }

        .content-section {
            padding: 20px;
            min-height: 100vh;
        }

        .section-title {
            color: #D19855;
            font-size: 20px;
            margin-bottom: 10px;
            border-bottom: 1px solid white;
        }

        .experience,
        .reference {
            margin-top: 20px;
        }

        .experience h3,
        .reference h3 {
            font-size: 16px;
            font-weight: 600;
        }

        .skills-list,
        .education-list,
        .language-list {
            list-style: none;
            padding-left: 0;
        }

        .experience-details,
        .reference-details {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>

    <div class="container">
        <table>
            <!-- Top section: Image and name -->
            <tr class="header">
                <td style="width: 30%; background-color: #484848; text-align: center;">
                    @if ($base64Image)
                        <img src="{{ $base64Image }}" alt="Image error!">
                    @else
                        <p>No image available</p>
                    @endif
                </td>

                <td>
                    <h1>{{ $resume->fname }} {{ $resume->lname }}</h1>
                    <p>{{ $resume->profession }}</p>
                    <p>{{ $resume->description }}</p>
                </td>
            </tr>

            <!-- Body Section -->
            <tr>
                <td class="contact-info" style="width: 30%;">
                    <h2 class="section-title">Contact</h2>
                    <p>Phone: {{ $resume->phone }}</p>
                    <p>Email: {{ $resume->email }}</p>
                    <p>Address: {{ $resume->address }}</p>

                    <h2 class="section-title">Education</h2>
                    <ul class="education-list">
                        @forelse($education as $edu)
                            <li>
                                {{ \Carbon\Carbon::parse($edu['startYear'])->format('Y') }} -
                                {{ \Carbon\Carbon::parse($edu['endYear'])->format('Y') }},
                                {{ $edu['degree'] }} (Grade: {{ $edu['grade'] }}) at {{ $edu['institution'] }}
                            </li>
                        @empty
                            <li>No education data available</li>
                        @endforelse
                    </ul>

                    <h2 class="section-title">Skills</h2>
                    <ul class="skills-list">
                        @forelse($skills as $skill)
                            <li>{{ $skill }}</li>
                        @empty
                            <li>No skills available</li>
                        @endforelse
                    </ul>

                    <h2 class="section-title">Languages</h2>
                    <ul class="language-list">
                        @foreach ($languages as $lan)
                            <li>{{ $lan }}</li>
                        @endforeach
                    </ul>

                    <h2 class="section-title">Interests</h2>
                    <ul>
                        @foreach ($interestes as $int)
                            <li>{{ $int }}</li>
                        @endforeach
                    </ul>
                </td>

                <td class="content-section" style="width: 70%;">
                    <h2 class="section-title">Experience</h2>
                    @foreach ($experiences as $exp)
                        <div class="experience-details">
                            <p>{{ \Carbon\Carbon::parse($exp['startYear'])->format('Y') }} -
                                @if ($exp['workingNow'])
                                    Present
                                @else
                                    {{ \Carbon\Carbon::parse($exp['endYear'])->format('Y') }}
                                @endif
                            </p>
                            <h3>{{ $exp['employeeName'] }} - {{ $exp['location'] }}</h3>
                            <p>{{ $exp['jobTitle'] }}</p>
                            <p>{{ $exp['description'] }}</p>
                        </div>
                    @endforeach

                    <h2 class="section-title">References</h2>
                    <div class="reference">
                        @foreach ($references as $reference)
                            <div class="reference-details">
                                <h3>{{ $reference['firstName'] }} {{ $reference['lastName'] }}</h3>
                                <p>{{ $reference['jobTitle'] }}</p>
                                <p>Phone: {{ $reference['phone'] }}</p>
                                <p>Email: {{ $reference['email'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </td>
            </tr>
        </table>
    </div>

</body>

</html>
