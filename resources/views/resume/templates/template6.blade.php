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
            font-family: "Arial Narrow", Arial, sans-serif;
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

        .sub-heading-6 {
            color: #ffb317;
            font-size: 16px;
            padding: 15px 0;
            border-bottom: 1px solid #ffffff;
            text-transform: uppercase;
            padding-bottom:6px;
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
            color: #ffffff;
            line-height: 140%;
            transition: background 0.3s;
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
            padding: 30px;
            border-left: 1px solid #ccc;
        }

        .name-heading-6 {
            color: #ffb317;
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
            padding: 10px 0 10px 0;
        }

        .section-heading-6 {
            font-weight: 700;
            color: #ffb317;
            padding: 8px 0 10px 20px;
            background-color: #484848;
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
            color: #ffb317;
            text-decoration: underline;
        }

        /* Responsive */
      
    </style>
</head>

<body>
    <table>
        <tr>
            <!-- Left side -->
            <td class="left-side-6s" style="width: 20%; height:96%; vertical-align: top; background-color: #484848; padding:20px">
                <div class="left-side-6">
                    <div>
                        <img src="https://i.postimg.cc/1zSsmrt2/Rectangle-25164.png" alt="Profile-image"
                            style="width:200px; height:200px" />
                        <img src="https://i.postimg.cc/cLwdGbsf/QR.png" alt="QR Code" class="qr-image-6" />
                        <h2 class="sub-heading-6">Contact</h2>
                        <ul class="contact-list-6">
                            <li class="contact-item-6"><a href="tel:123-456-7890"
                                    class="contact-link-6">123-456-7890</a></li>
                            <li class="contact-item-6"><a href="mailto:jahanara.womeningdigital@gmail.com"
                                    class="contact-link-6">jahanara.womeningdigital@gmail.com</a></li>
                            <li class="contact-item-6">0-51, Janata Co-operative Housing Society, Mohammadpur, Dhaka,
                                Bangladesh</li>
                        </ul>
                        <h2 class="sub-heading-6">Education</h2>
                        <ul class="education-list-6">
                            <li class="education-item-6">2008 - University of Liberal Arts Bangladesh</li>
                        </ul>
                        <h2 class="sub-heading-6" style="padding-bottom: 10px">Skills</h2>

                        <table style="width: 100%; padding-top:10px">
                            <tr>
                                <td style="font-size: 10px; white-space:nowrap; color:#fff">
                                    UI/UX
                                </td>
                                <td style="font-size: 10px; white-space:nowrap; color:#fff">
                                    Visual Design
                                </td>
                            </tr>
                            <tr>
                                <td style="font-size: 10px; white-space:nowrap; color:#fff">
                                    Wireframes
                                </td>
                                <td style="font-size: 10px; white-space:nowrap; color:#fff">
                                    Storyboards
                                </td>

                            </tr>
                            <tr>
                                <td style="font-size: 10px; white-space:nowrap; color:#fff">
                                    Wireframes
                                </td>
                                <td style="font-size: 10px; white-space:nowrap; color:#fff">
                                    Storyboards
                                </td>

                            </tr>
                        </table>
                        <h2 class="sub-heading-6">Languages</h2>
                        <ul class="language-list-6">
                            <li class="language-item-6">English</li>
                            <li class="language-item-6">Bangla</li>
                        </ul>
                        <h2 class="sub-heading-6">Interests</h2>
                        <ul class="hobbies-list-6">
                            <li class="hobbies-item-6">Music</li>
                            <li class="hobbies-item-6">Reading</li>
                        </ul>
                        <h2 class="sub-heading-6">Certifications</h2>
                        <ul class="certifications-list-6">
                            <li class="certification-item-6">Certified UI/UX Designer</li>
                        </ul>
                    </div>
                </div>
            </td>

            <!-- Right side -->
            <td style="width: 80%; background-color: white;vertical-align: top; ">
                <div class="right-side-6">
                    <h1 class="name-heading-6"><b>Pronub</b> Shaharier</h1>
                    <p class="designation-6">Full Stack Developer</p>
                    <p class="description-6" style="font-size: 12px">
                        I am a passionate Full Stack Developer with expertise in creating dynamic and responsive web
                        applications.
                    </p>
                    <h2 class="section-heading-6" style="margin-top: 15px">Experience</h2>
                    <ul class="experience-list-6">
                        <li class="experience-item-6" style="color: #000">

                            <p style="margin-bottom:5px; font-size:12px">2019 - 2022</p>
                            <h3 style="font-size:16px; font-weight: 600; padding-bottom:7px">Company Name | 123 Anywhere St. Any
                                City

                            </h3>
                            <p style="font-size: 15px; padding-bottom:7px">Job Position</p>
                            <p style="font-size: 12px; padding-right: 20px;">Sed ut perspiciatis unde omnis iste
                                natus error sit
                                voluptatem accusantium doloremque laudantium. Sed audantium. audantium. ut
                                perspiciatis unde omnis iste
                                voluptatem accusantium doloremque laudantium. Sed audantium. audantium. ut
                                perspiciatis unde omnis iste
                                natus error sit voluptatem accusantium doloremque laudantium. Sed ut perspiciatis
                                unde omnis iste natus error sit voluptatem accusantium doloremque laudantium.
                                natus error sit voluptatem accusantium doloremque laudantium. Sed ut perspiciatis
                                unde omnis iste natus error sit voluptatem accusantium doloremque laudantium.</p>
                        </li>
                        <li class="experience-item-6" style="color: #000">

                            <p style="margin-bottom:5px; font-size:12px">2019 - 2022</p>
                            <h3 style="font-size:16px; font-weight: 600; padding-bottom:7px">Company Name | 123 Anywhere St. Any
                                City

                            </h3>
                            <p style="font-size: 15px; padding-bottom:7px">Job Position</p>
                            <p style="font-size: 12px; padding-right: 20px;">Sed ut perspiciatis unde omnis iste
                                natus error sit
                                voluptatem accusantium doloremque laudantium. Sed audantium. audantium. ut
                                perspiciatis unde omnis iste
                                voluptatem accusantium doloremque laudantium. Sed audantium. audantium. ut
                                perspiciatis unde omnis iste
                                natus error sit voluptatem accusantium doloremque laudantium. Sed ut perspiciatis
                                unde omnis iste natus error sit voluptatem accusantium doloremque laudantium.
                                natus error sit voluptatem accusantium doloremque laudantium. Sed ut perspiciatis
                                unde omnis iste natus error sit voluptatem accusantium doloremque laudantium.</p>
                        </li>
                        <li class="experience-item-6" style="color: #000">

                            <p style="margin-bottom:5px; font-size:12px ;padding-bottom:7px">2019 - 2022</p>
                            <h3 style="font-size:16px; font-weight: 600; padding-bottom:7px">Company Name | 123 Anywhere St. Any
                                City

                            </h3>
                            <p style="font-size: 15px; padding-bottom:7px">Job Position</p>
                            <p style="font-size: 12px; padding-right: 20px;">Sed ut perspiciatis unde omnis iste
                                natus error sit
                                voluptatem accusantium doloremque laudantium. Sed audantium. audantium. ut
                                perspiciatis unde omnis iste
                                voluptatem accusantium doloremque laudantium. Sed audantium. audantium. ut
                                perspiciatis unde omnis iste
                                            perspiciatis unde omnis iste
                                voluptatem accusantium doloremque laudantium. Sed audantium. audantium. ut
                                perspiciatis unde omnis iste
                                            perspiciatis unde omnis iste
                                voluptatem accusantium doloremque laudantium. Sed audantium. audantium. ut
                                perspiciatis unde omnis iste
                            </p>
                        </li>
                    </ul>
                    <h2 class="section-heading-6" style="margin-top: 15px">References</h2>
                    <table style="width: 100%;">
                        <tr>
                            <td>
                                <h3 style="font-size: 16px;padding-bottom:10px">Name Surname</h3>
                                <p style="font-size: 12px; ">Job Position, Company</p>
                                <p style="font-size: 12px;">Phone: 123-456-7890</p>
                                <p style="font-size: 12px;">Email: hello@domainname.com</p>
                            </td>
                            <td>
                                <h3 style="font-size: 16px; padding-bottom:10px">Name Surname</h3>
                                <p style="font-size: 12px;">Job Position, Company</p>
                                <p style="font-size: 12px;">Phone: 123-456-7890</p>
                                <p style="font-size: 12px;">Email: hello@domainname.com</p>
                            </td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
    </table>
</body>

</html>
