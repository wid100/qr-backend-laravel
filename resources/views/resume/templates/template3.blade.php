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
            padding-top:20px;

        }

        .image-container-heading {
            width: 16%;
            height: 50px;
            background-color: #D9D9D9;
            
            margin:20px 0px 20px -30px;

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
        .hobbies-item-3{
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
                                    <h1 class="name-heading-3"><b>Pronub</b> Shaharier</h1>
                                    <p class="designation-3">Full Stack Developer</p>
                                    <p class="description-3" style="font-size: 12px">
                                        I am a passionate Full Stack Developer with expertise in creating dynamic and
                                        responsive web applications.
                                        I am a passionate Full Stack Developer with expertise in creating dynamic and
                                        responsive web applications.

                                    </p>
                                </div>
                            </td>
                        </tr>
                    </table>
                    <div class="image-container-heading">
                        <h2 class="section-heading-3" style="margin-top: 15px">Experience</h2>
                    </div>
                    <ul class="experience-list-3">
                        <li class="experience-item-3" style="color: #000">

                            <p style="margin-bottom:5px; font-size:12px; color: #FF5280">2019 - 2022</p>
                            <h3 style="font-size:16px; font-weight: 600; padding-bottom:7px">Company Name | 123 Anywhere
                                St. Any
                                City

                            </h3>
                            <p style="font-size: 15px; padding-bottom:7px; color: #FF5280">Job Position</p>
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
                        <li class="experience-item-3" style="color: #000">

                            <p style="margin-bottom:5px; font-size:12px; color: #FF5280">2019 - 2022</p>
                            <h3 style="font-size:16px; font-weight: 600; padding-bottom:7px">Company Name | 123 Anywhere
                                St. Any
                                City

                            </h3>
                            <p style="font-size: 15px; padding-bottom:7px;color: #FF5280">Job Position</p>
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
                        <li class="experience-item-3" style="color: #000">

                            <p style="margin-bottom:5px; font-size:12px; color: #FF5280">2019 - 2022</p>
                            <h3 style="font-size:16px; font-weight: 600; padding-bottom:7px">Company Name | 123 Anywhere
                                St. Any
                                City

                            </h3>
                            <p style="font-size: 15px; padding-bottom:7px;color: #FF5280">Job Position</p>
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
                    </ul>
                    <div class="image-container-heading">
                        <h2 class="section-heading-3" style="margin-top: 15px">References</h2>
                    </div>
                    <table style="width: 100%;">
                        <tr>
                            <td>
                                <h3 style="font-size: 16px; padding-bottom:7px;color: #FF5280">Name Surname</h3>
                                <p style="font-size: 12px; padding-bottom:5px">Job Position, Company</p>
                                <p style="font-size: 12px; padding-bottom:5px"><span style="color: #FF5280">Phone:</span> <span> <a href="tel:123-456-7890"
                                            class="contact-link-3">123-456-7890</a></span></p>
                                <p style="font-size: 12px;padding-bottom:5px"><span  style="color: #FF5280">Email: </span><a
                                        href="mailto:jahanara.womeningdigital@gmail.com"
                                        class="contact-link-3">jahanara.womeningdigital@gmail.com</a> </p>
                            </td>
                            <td>
                                <h3 style="font-size: 16px; padding-bottom:7px;color: #FF5280">Name Surname</h3>
                                <p style="font-size: 12px; padding-bottom:5px">Job Position, Company</p>
                                <p style="font-size: 12px; padding-bottom:5px"><span style="color: #FF5280">Phone:</span><span> <a href="tel:123-456-7890"
                                            class="contact-link-3">123-456-7890</a></span></p>
                                <p style="font-size: 12px;padding-bottom:5px"><span  style="color: #FF5280">Email: </span><a
                                        href="mailto:jahanara.womeningdigital@gmail.com"
                                        class="contact-link-3">jahanara.womeningdigital@gmail.com</a> </p>
                            </td>
                        </tr>
                    </table>
                </div>
            </td>

            <!-- Right side -->
            <td style="width: 20%;height:100%; vertical-align: top; background-color: #ffffff;padding-right:20px">

                <div class="left-side-3">
                    <div style=""class="image-container">
                        <img src="https://i.postimg.cc/1zSsmrt2/Rectangle-25164.png" alt="Profile-image"
                            style=" width: 170px;height: 170px;border: 5px solid #ffffff;object-fit: cover;">
                    </div>
                    
                    <div style="padding:20px 0 20px 20px; background-color: #D9D9D9;height:862px;">
                        <div style="text-align: center">
                            <img src="https://i.postimg.cc/cLwdGbsf/QR.png" alt="QR Code" class="qr-image-3" />
                        </div>
                        <h2 class="sub-heading-3">Contact</h2>
                        <ul class="contact-list-3">
                            <li class="contact-item-3">
                                <p style="font-size: 14px;color: #FF5280">Phone</p>
                                <a href="tel:123-456-7890" class="contact-link-3">123-456-7890</a>
                            </li>
                            <li class="contact-item-3">
                                <p style="font-size: 14px;color: #FF5280">Email</p>
                                <a href="mailto:jahanara.womeningdigital@gmail.com"
                                    class="contact-link-3">jahanara.womeningdigital@gmail.com</a>
                            </li>
                            <li class="contact-item-3">
                                <p style="font-size: 14px;color: #FF5280">Address</p>
                                <p>0-51, Janata Co-operative Housing Society, Mohammadpur, Dhaka,
                                    Bangladesh</p>
                            </li>
                        </ul>
                        <h2 class="sub-heading-3">Education</h2>
                        <ul class="education-list-3" style="margin-bottom: 7px">
                            <li class="education-item-3">
                                <span style="font-size: 12px">2008</span>
                                <p style="font-size: 14px;color: #FF5280">Enter Your Degree
                                </p>
                                <p style="font-size: 12px">Grade</p>
                                <p style="font-size: 12px">2008 - University of Liberal Arts Bangladesh</p>
                            </li>
                        </ul>
                        <h2 class="sub-heading-3" style="padding-bottom: 10px">Skills</h2>
                        <table style="width: 100%; padding-top:10px">
                            <tr>
                                <td style="font-size: 10px; white-space:nowrap;color:#000">
                                    UI/UX
                                </td>
                                <td style="font-size: 10px; white-space:nowrap;color:#000">
                                    Visual Design
                                </td>
                            </tr>
                            <tr>
                                <td style="font-size: 10px; white-space:nowrap;color:#000">
                                    Wireframes
                                </td>
                                <td style="font-size: 10px; white-space:nowrap;color:#000">
                                    Storyboards
                                </td>

                            </tr>

                        </table>
                        <h2 class="sub-heading-3">Languages</h2>
                        <table style="width: 100%; padding-top:10px">
                            <tr>
                                <td style="font-size: 10px; white-space:nowrap;color:#FF5280">
                                    UI/UX
                                </td>
                                <td style="font-size: 10px; white-space:nowrap;color:#FF5280">
                                    Visual Design
                                </td>
                            </tr>
                            <tr>
                                <td style="font-size: 10px; white-space:nowrap;color:#FF5280">
                                    Wireframes
                                </td>
                                <td style="font-size: 10px; white-space:nowrap;color:#FF5280">
                                    Storyboards
                                </td>

                            </tr>

                        </table>
                        <h2 class="sub-heading-3">Interests</h2>
                        <ul class="hobbies-list-3">
                            <li class="hobbies-item-3">Music</li>
                            <li class="hobbies-item-3">Reading</li>
                        </ul>

                    </div>
                </div>

            </td>
        </tr>
    </table>
</body>

</html>
