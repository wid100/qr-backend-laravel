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

        .main-body-1 {
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
        .qr-image-1 {
            width: 100px;
            height: 100px;
            object-fit: cover;
            margin-top: 20px;
        }

        .sub-heading-1 {
            color: #ffffff;
            font-size: 16px;
            padding: 15px 0;
            border-bottom: 1px solid #fff;
            text-transform: uppercase;
            padding-bottom:6px;
            font-weight: 600;
        }

        .contact-list-1,
        .education-list-1,
        .experience-list-1,
        .language-list-1,
        .hobbies-list-1,
        .certifications-list-1 {
            padding-left: 0;
            padding-right: 20px;            
        }

        .contact-item-1,
        .education-item-1,
        .experience-item-1,
        .language-item-1,
        .hobbies-item-1,
        .certification-item-1 {
            list-style: none;
            font-size: 12px;
            padding: 4px 0;
            color: #ffffff;
            line-height: 140%;
            transition: background 0.3s;
        }

        .contact-item-1:hover,
        .education-item-1:hover,
        .experience-item-1:hover,
        .language-item-1:hover,
        .hobbies-item-1:hover,
        .certification-item-1:hover {
            background: rgba(255, 179, 23, 0.2);
        }

        .contact-link-1 {
            color: inherit;
            text-decoration: none;
        }

        .skill-1 {
            list-style-type: none;
            padding: 10px 0;
            font-size: 13px;
            display: flex;
            flex-wrap: wrap;
            color: #fff;
        }

        .skill-1 li {
            width: 50%;
            padding: 5px 0;
        }

        /* Right side styles */
        .right-side-1 {
            background: #f5f5f5;
            color: #000000;
            padding: 30px;
        }

        .name-heading-1 {
            color: #004382;
            font-size: 30px;
            font-weight: 400;
        }

        .designation-1 {
            font-weight: 400;
            color: #000000;
            margin-top: 10px;
        }

        .description-1 {
            font-size: 16px;
            padding: 10px 0 10px 0;
        }

        .section-heading-1 {
            font-weight: 700;
            color: #004382;
            border-bottom: 1px solid #000;
            padding-bottom: 5px;
            margin-bottom: 15px;
            text-transform: uppercase;
            font-size: 18px
        }

        .references-1 {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            padding: 10px 0;
        }

        .reference-item-1 {
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

        .reference-item-1:hover {
            transform: translateY(-3px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }

        .reference-item-1 h3 {
            padding: 4px 0;
            font-size: 18px;
            font-weight: bold;
        }

        .reference-item-1 p {
            padding: 3px 0;
            margin: 0;
        }

        .reference-item-1 a {
            color: inherit;
            text-decoration: none;
        }

        .reference-item-1 a:hover {
            color: #004382;
            text-decoration: underline;
        }
      
    </style>
</head>

<body>
    <table>
        <tr>
            <!-- Left side -->
            <td style="width: 20%; height:100%; vertical-align: top; background-color: #004382;">
                <div class="left-side-1">
                    <div style="width: 100%;text-align: center;padding-top:20px;">
                        <img src="https://i.postimg.cc/1zSsmrt2/Rectangle-25164.png" alt="Profile-image" style=" width: 170px;height: 170px; object-fit: cover; position: relative;z-index: 1;border: 2px solid #ffffff;border-radius: 50%;object-fit: cover;">
                    </div>
                    <div style="padding:20px 0 20px 20px;">
                        <h2 class="sub-heading-1">Contact</h2>
                        <ul class="contact-list-1">
                            <li class="contact-item-1">
                                <p style="font-size: 14px">Phone</p>
                                <a href="tel:123-456-7890"
                                    class="contact-link-1">123-456-7890</a></li>
                            <li class="contact-item-1">
                                <p style="font-size: 14px">Email</p>
                                <a href="mailto:jahanara.womeningdigital@gmail.com"
                                    class="contact-link-1">jahanara.womeningdigital@gmail.com</a></li>
                            <li class="contact-item-1">
                                <p style="font-size: 14px">Address</p>
                                <p>0-51, Janata Co-operative Housing Society, Mohammadpur, Dhaka,
                                    Bangladesh</p>
                                </li>
                        </ul>
                        <h2 class="sub-heading-1">Education</h2>
                        <ul class="education-list-1" style="margin-bottom: 7px">
                            <li class="education-item-1">
                                <span style="font-size: 12px">2008</span>
                                <p style="font-size: 14px">Enter Your Degree
                                </p>
                                <p style="font-size: 12px">Grade</p>
                                <p style="font-size: 12px">2008 - University of Liberal Arts Bangladesh</p>
                            </li>
                        </ul>
                        <h2 class="sub-heading-1" style="padding-bottom: 10px">Skills</h2>

                        <table style="width: 100%; padding-top:10px">
                            <tr>
                                <td style="font-size: 10px; white-space:nowrap;color:#fff">
                                    UI/UX
                                </td>
                                <td style="font-size: 10px; white-space:nowrap;color:#fff">
                                    Visual Design
                                </td>
                            </tr>
                            <tr>
                                <td style="font-size: 10px; white-space:nowrap;color:#fff">
                                    Wireframes
                                </td>
                                <td style="font-size: 10px; white-space:nowrap;color:#fff">
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
                        <h2 class="sub-heading-1">Languages</h2>
                        <ul class="language-list-1">
                            <li class="language-item-1">English</li>
                            <li class="language-item-1">Bangla</li>
                        </ul>
                        <h2 class="sub-heading-1">Interests</h2>
                        <ul class="hobbies-list-1">
                            <li class="hobbies-item-1">Music</li>
                            <li class="hobbies-item-1">Reading</li>
                        </ul>
                        
                    </div>
                </div>
            </td>

            <!-- Right side -->
            <td style="width: 80%; background-color: #f5f5f5;vertical-align: top; ">
                <div class="right-side-1">
                    <table>
                        <tr>
                            <td>
                                <h1 class="name-heading-1"><b>Pronub</b> Shaharier</h1>
                                <p class="designation-1">Full Stack Developer</p>
                                <p class="description-1" style="font-size: 12px">
                                    I am a passionate Full Stack Developer with expertise in creating dynamic and responsive web applications.
                                </p>
                            </td>
                            <td style="text-align: right;">
                                <img src="https://i.postimg.cc/cLwdGbsf/QR.png" alt="QR Code" class="qr-image-1" />
                            </td>
                        </tr>
                    </table>
                    <h2 class="section-heading-1" style="margin-top: 15px">Experience</h2>
                    <ul class="experience-list-1">
                        <li class="experience-item-1" style="color: #000">

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
                        <li class="experience-item-1" style="color: #000">

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
                        <li class="experience-item-1" style="color: #000">

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
                    <h2 class="section-heading-1" style="margin-top: 15px">References</h2>
                   <table style="width: 100%;">
                        <tr>
                            <td>
                                <h3 style="font-size: 16px; padding-bottom:7px">Name Surname</h3>
                                <p style="font-size: 12px; padding-bottom:5px">Job Position, Company</p>
                                <p style="font-size: 12px; padding-bottom:5px">Phone: <span> <a href="tel:123-456-7890"
                                            class="contact-link-1">123-456-7890</a></span></p>
                                <p style="font-size: 12px;padding-bottom:5px">Email: <a
                                        href="mailto:jahanara.womeningdigital@gmail.com"
                                        class="contact-link-1">jahanara.womeningdigital@gmail.com</a> </p>
                            </td>
                            <td>
                                <h3 style="font-size: 16px; padding-bottom:7px">Name Surname</h3>
                                <p style="font-size: 12px; padding-bottom:5px">Job Position, Company</p>
                                <p style="font-size: 12px; padding-bottom:5px">Phone: <span> <a href="tel:123-456-7890"
                                            class="contact-link-1">123-456-7890</a></span></p>
                                <p style="font-size: 12px;padding-bottom:5px">Email: <a
                                        href="mailto:jahanara.womeningdigital@gmail.com"
                                        class="contact-link-1">jahanara.womeningdigital@gmail.com</a> </p>
                            </td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
    </table>
</body>

</html>
