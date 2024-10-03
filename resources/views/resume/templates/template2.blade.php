<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Resume</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Arial Narrow", Arial, sans-serif;
        }

        .main-body {
            /* background: #72c3f1; */
            display: flex;
            justify-content: center;
            color: #000000;
            overflow-x: hidden;
        }

        .qr-image img {
            width: 100px;
        }

        .resume-gap {
            margin-right: 20px;
        }

        .resume-1 {
            position: relative;
            width: 100%;
            max-width: 790px;
            min-height: auto;
            background: #ffffff;
            /* margin: 50px; */
            display: grid;
            grid-template-columns: 30% 70%;
            box-shadow: 0 35px 55px rgba(0, 0, 0, 0.1);
        }

        .resume-1 .left-side-1 {
            position: relative;
            background: #004382 !important;
            padding: 30px 0;
            color: #ffffff;
        }

        .profile-text-1 {
            position: relative;
            display: flex;
            flex-direction: column;
        }

        .profile-img-1 {
            width: 100%;
            display: flex;
            justify-content: center;
            padding-bottom: 10px;
        }

        .profile-img-1 img {
            width: 170px;
            height: 170px;
            position: relative;
            z-index: 1;
            border: 2px solid #ffffff;
            border-radius: 50%;
            object-fit: cover;
        }

        /* .resume-1 .right-side-1 {
            position: relative;
            background: #ffffff;
            padding: 30px;
        } */
        .sub-heading-1 {
            color: #ffffff;
            /* font-family: Inter; */
            text-align: left;
            font-size: 18px;
            padding: 15px 0 0 0;
            border-bottom: 2px solid #ffffff;
            text-transform: uppercase;
            padding-bottom: 6px;
            font-weight: 600;
        }

        .contact-details-1 {
            list-style: none;
            font-size: 14px;
            font-weight: 400;
            text-align: left;
            padding: 4px 10px 10px 0;
            line-height: 140%;
        }

        .contact-heading-1 {
            margin-top: 10px;
        }

        .education-1-details-1 {
            list-style: none;
            font-size: 12px;
            font-weight: 400;
            letter-spacing: 1px;
            text-align: left;
            padding: 3px 0 0 0;
        }

        .education-1 {
            margin-bottom: 10px;
            margin-top: 10px;
        }

        .skill-1 {
            list-style-type: none;
            padding: 10px 0 10px 0;
            font-size: 14px;
            display: flex;
            flex-wrap: wrap;
        }

        .skill-1 li {
            width: 50%;
            padding: 5px 0;
        }

        .skill-1 li:nth-child(odd) {
            float: right;
        }

        .skill-1 li:nth-child(even) {
            float: left;
        }

        .language-1 {
            list-style: none;
            margin: 0;
            padding: 5px 0 10px 0;
            position: relative;
            font-size: 14px;
            display: flex;
            flex-wrap: wrap;
        }

        .language-1 li {
            flex: 0 1 calc(50% - 10px);
            padding: 10px 10px 0 0;
            box-sizing: border-box;
        }

        .interest-1 {
            list-style: none;
            margin: 0;
            padding: 0;
            position: relative;
            font-size: 16px;
            display: flex;
            flex-wrap: wrap;
        }

        .interest-1 li {
            flex: 0 1 calc(33.33% - 10px);
            padding: 10px 10px 0 0;
            box-sizing: border-box;
        }

        .resume-name-1 {
            color: #004382;
            font-size: 42px;
            font-weight: 400;
        }

        .first-name-1 {
            color: #004382;
            font-size: 42px;
            font-weight: 900;
            margin-right: 15px;
        }

        .resume-1-display {
            display: flex;
            justify-content: space-between;
        }

        .resume-designation-1 {
            font-weight: 400;
            line-height: 19px;
            letter-spacing: 2px;
            text-align: left;
            color: #000000;
        }

        .resume-about-1 {
            font-size: 16px;
            font-weight: 400;
            padding: 15px 0 20px 0;
            /* text-align: justify; */
        }

        .contact-text,
        .education-1-text,
        .skill-1-text,
        .language-1-text,
        .interest-1-text {
            padding-left: 30px;
        }

        .experience-1 {
            font-weight: 700;
            color: #004382;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }

        .resume-experience-1 {
            position: relative;
            padding: 10px 0;
        }

        .job-1 {
            list-style: none;
            position: relative;
            display: flex;
        }

        .job-1-year {
            font-weight: bold;
            margin-bottom: 5px;
            position: relative;
            z-index: 2;
        }

        .job-1::before {
            content: "";
            position: absolute;
            /* left: 15px; */
            top: 0;
            width: 10px;
            height: 10px;
            background-color: #004382;
            border-radius: 50%;
            z-index: 1;
        }

        .timeline-line {
            width: 2px;
            background-color: #000000;
            position: absolute;
            top: 0;
            bottom: 0;
            left: 4px;
            z-index: 0;
        }

        .job-content {
            padding-left: 40px;
            box-sizing: border-box;
        }

        .company-name-1 {
            padding: 5px 0;
        }

        .job-1-position {
            padding: 5px 0;
        }

        .job-1-description {
            /* text-align: justify; */
            padding-bottom: 20px;
        }

        .job-1:last-child .job-1-description {
            padding-bottom: 0;
        }

        .reference-1 {
            font-weight: 700;
            color: #004382;
            padding-block: 10px;
            border-bottom: 2px solid #000;
        }

        .resume-reference-1 {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            padding: 10px 0 0px 0;
        }

        .ref {
            flex: 0 1 calc(50% - 20px);
            box-sizing: border-box;
        }

        .resume-right-1 .ref {
            color: black;
            font-size: 14px;
        }

        .ref p {
            line-height: 15px;
        }

        .resume-right-1 .ref span {
            font-weight: bolder;
        }

        .ref-name-1 {
            padding: 4px 0 4px 0;
        }

        .ref-position-1,
        .ref-phone-1,
        .ref-email-1 {
            padding: 3px 0 3px 0;
        }

        .contact-link,
        .contact-link-1 {
            color: inherit;
            text-decoration: none;
            word-wrap: break-word;
            word-break: break-word;
        }

        .contact-link:hover {
            color: #004382;
            text-decoration: underline;
        }

        .contact-link-1:hover {
            text-decoration: underline;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body>
    <table style="width: 100%; border-collapse: collapse;">

        <tr>
            <td class="left-side-1">
                <!---left portion starts from here-->

                <div class="profile-text-1" style="background:#004382">
                    <div class="profile-img-1">
                        <img src="{{ public_path('image/resume/longimage.png') }}" alt="Profile-image" />

                    </div>

                    <!-- Contact part -->

                    <div class="contact-text">
                        <h2 class="sub-heading-1">Contact</h2>
                        <ul>
                            <h4 class="contact-heading-1">Phone</h4>
                            <li class="contact-details-1">
                                <a href="tel:123-456-7890" class="contact-link-1">123-456-7890</a>
                            </li>
                            <h4 class="contact-heading-1">Email</h4>
                            <li class="contact-details-1">
                                <a href="mailto:mail@domainname.com" class="contact-link-1">mail@domainname.com</a>
                            </li>

                        </ul>
                    </div>
                    <!-- education part -->

                    <div class="education-1-text">
                        <h2 class="sub-heading-1">education</h2>

                        <ul class="education-1">
                            <div style="margin-bottom: 15px">
                                <li class="education-1-details-1">2008</li>
                                <h4 class="degree-1">Enter Your Degree</h4>
                                <li class="education-1-details-1">Grade</li>
                                <li class="education-1-details-1">
                                    University/Collage
                                </li>
                            </div>
                            <div style="margin-bottom: 15px">
                                <li class="education-1-details-1">2008</li>
                                <h4 class="degree-1">Enter Your Degree</h4>
                                <li class="education-1-details-1">Grade</li>
                                <li class="education-1-details-1">
                                    University/Collage
                                </li>
                            </div>
                        </ul>
                    </div>
                    <!-- skill part -->

                    <div class="skill-1-text">
                        <h2 class="sub-heading-1">skill</h2>

                        <ul class="skill-1">
                            <li>UI/UX</li>
                            <li>Visual Design</li>
                            <li>Wireframes</li>
                            <li>Storyboards</li>
                            <li>User Flows</li>
                            <li>Process Flows</li>
                        </ul>
                    </div>

                    <!-- language part -->

                    <div class="language-1-text">
                        <h2 class="sub-heading-1">language</h2>

                        <ul class="language-1">
                            <li>ENGLISH</li>
                            <li>BANGLA</li>
                            <li>BANGLA</li>
                        </ul>
                    </div>

                    <!-- interest part -->

                    <div class="interest-1-text">
                        <h2 class="sub-heading-1">interest</h2>
                        <ul class="interest-1">
                            <li>Music</li>
                            <li>Singing</li>
                            <li>Reading</li>
                            <li>Music</li>
                            <li>Singing</li>
                            <li>Reading</li>
                        </ul>
                    </div>
                </div>

                <!---left portion ends here-->
            </td>
            <td class="right-side-1">
                <!---right portion starts from here-->

                <div>
                    <h1 class="resume-name-1"><span class="first-name-1">Pronub</span>Shaharier</h1>
                    <div class="resume-1-display">
                        <div class="resume-gap">
                            <h2 class="resume-designation-1">Marketing Manager</h2>
                            <p class="resume-about-1">Lorem ipsum </p>
                        </div>
                        <div class="qr-image">
                            <img src="img/QR.png" alt="Qr Image">
                        </div>
                    </div>
                </div>

                <!-- Experience part -->

                <div>
                    <h2 class="experience-1">Experience</h2>
                    <ul class="resume-experience-1">

                        <li class="job-1">
                            <div class="timeline-line"></div>
                            <div class="job-content">
                                <p class="job-1-year">2015 - 2017</p>
                                <p class="company-name-1">Company Name | 123 Anywhere St. Any City</p>
                                <h3 class="job-1-position">Job Position Here</h3>
                                <p class="job-1-description">Sed ut perspiciatis unde omnis iste natus error sit
                                    voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab
                                    illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
                            </div>
                        </li>
                    </ul>
                </div>

                <!-- Reference part -->

                <div>
                    <h2 class="reference-1">Reference</h2>
                    <div class="resume-reference-1">
                        <div class="ref">
                            <h3 class="ref-name-1"><span>Name (Surmame)</span></h3>
                            <p class="ref-position-1">job Position | Company Name</p>
                            <p class="ref-phone-1">
                                <span><b>Phone</b></span>
                                <a href="tel:123-456-7890" class="contact-link">123-456-7890</a>
                            </p>
                            <p class="ref-email-1">
                                <span><b>Email</b></span>
                                <a href="mailto:hello@domainname.com" class="contact-link">hello@domainname.com</a>
                            </p>
                        </div>
                        <div class="ref">
                            <h3 class="ref-name-1"><span>Name (Surmame)</span></h3>
                            <p class="ref-position-1">job Position | Company Name</p>
                            <p class="ref-phone-1">
                                <span><b>Phone</b></span>
                                <a href="tel:123-456-7890" class="contact-link">123-456-7890</a>
                            </p>
                            <p class="ref-email-1">
                                <span><b>Email</b></span>
                                <a href="mailto:hello@domainname.com" class="contact-link">hello@domainname.com</a>
                            </p>
                        </div>

                    </div>
                </div>

                <!--right portion ends here-->
            </td>
        </tr>
    </table>

</body>

</html>
