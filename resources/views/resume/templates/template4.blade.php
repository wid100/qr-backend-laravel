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
            color: #e3707f;
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
            <td style="width: 20%; height:100%; vertical-align: top; background-color: #484848;">
                    <div style="width: 100%;text-align: center;padding-top:20px;">
                        <img src="https://i.postimg.cc/1zSsmrt2/Rectangle-25164.png" alt="Profile-image" style=" width: 170px;height: 170px; object-fit: cover; position: relative;z-index: 1;border: 2px solid #ffffff;border-radius: 50%;object-fit: cover;">
                    </div>
                <div style="padding:20px;">
                    <h2 class="sub-heading-4">Contact</h2>
                    <ul class="contact-list-4">
                        <li class="contact-item-4">
                            <p style="font-size: 14px">Phone</p>
                            <a href="tel:123-456-7890"
                                class="contact-link-4">123-456-7890</a></li>
                        <li class="contact-item-4">
                            <p style="font-size: 14px">Email</p>
                            <a href="mailto:jahanara.womeningdigital@gmail.com"
                                class="contact-link-4">jahanara.womeningdigital@gmail.com</a></li>
                        <li class="contact-item-4">
                            <p style="font-size: 14px">Address</p>
                            <p>0-51, Janata Co-operative Housing Society, Mohammadpur, Dhaka,
                                Bangladesh</p>
                            </li>
                    </ul>
                    <h2 class="sub-heading-4">Education</h2>
                    <ul class="education-list-4" style="margin-bottom: 7px">
                        <li class="education-item-4">
                            <span style="font-size: 12px">2008</span>
                            <p style="font-size: 14px">Enter Your Degree
                            </p>
                            <p style="font-size: 12px">Grade</p>
                            <p style="font-size: 12px">2008 - University of Liberal Arts Bangladesh</p>
                        </li>
                    </ul>
                    <h2 class="sub-heading-4" style="padding-bottom: 10px">Skills</h2>

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
                    <h2 class="sub-heading-4">Languages</h2>
                    <ul class="language-list-4">
                        <li class="language-item-4">English</li>
                        <li class="language-item-4">Bangla</li>
                    </ul>
                    <h2 class="sub-heading-4">Interests</h2>
                    <ul class="hobbies-list-4">
                        <li class="hobbies-item-4">Music</li>
                        <li class="hobbies-item-4">Reading</li>
                    </ul>
                </div>
                
            </td>

            <!-- Right side -->
            <td style="width: 80%; background-color: white;vertical-align: top;">
                <div style="background: #e3707f; padding:25px;">
                    <table>
                        <tr>
                            <td>
                                <h1 class="name-heading-4"><b>Pronub</b> Shaharier</h1>
                                <p class="designation-4">Full Stack Developer</p>
                                <p class="description-4" style="font-size: 12px">
                                    I am a passionate Full Stack Developer with expertise in creating dynamic and responsive web applications.voluptatem accusantium doloremque laudantium. Sed audantium. audantium. ut
                                    perspiciatis unde omnis iste
                                    
                                </p>
                            </td>
                            <td style="text-align: right;">
                                <img src="https://i.postimg.cc/cLwdGbsf/QR.png" alt="QR Code" class="qr-image-4" />
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="right-side-4">

                    <h2 class="section-heading-4" style="margin-top: 15px">Experience</h2>
                    <ul class="experience-list-4">
                        <li class="experience-item-4" style="color: #000">

                            <p style="margin-bottom:5px; font-size:12px">2019 - 2022</p>
                            <h3 style="font-size:16px; font-weight: 600; padding-bottom:7px">Company Name | 123 Anywhere
                                St. Any
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
                        <li class="experience-item-4" style="color: #000">

                            <p style="margin-bottom:5px; font-size:12px">2019 - 2022</p>
                            <h3 style="font-size:16px; font-weight: 600; padding-bottom:7px">Company Name | 123 Anywhere
                                St. Any
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
                        <li class="experience-item-4" style="color: #000">

                            <p style="margin-bottom:5px; font-size:12px ;padding-bottom:7px">2019 - 2022</p>
                            <h3 style="font-size:16px; font-weight: 600; padding-bottom:7px">Company Name | 123 Anywhere
                                St. Any
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
