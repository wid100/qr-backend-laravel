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

        .main-body-12 {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            color: #000;
        }

        /* Table styling */
        table {
            width: 100%;
            height: 100vh;
            border-spacing: 0;
            border-collapse: collapse;

        }

        .qr-image-12 {
            width: 100px;
            height: 100px;
            object-fit: cover;
            margin-top: 20px;
        }

        .sub-heading-12 {
            color: #000;
            font-size: 16px;
            padding: 15px 0;
            border-bottom: 1px solid #000;
            text-transform: uppercase;
            padding-bottom: 6px;
            font-weight: 600;
        }

        /* .contact-list-12,
        .education-list-12,
        .experience-list-12,
        .language-list-12,
        .hobbies-list-12,
        .skill-list-12 {
            padding-left: 0;
            padding-right: 20px;
        } */

        .contact-item-12,
        .education-item-12,
        .experience-item-12,
        .language-item-12,
        .hobbies-item-12,
        .skill-item-12 {
            list-style: none;
            font-size: 12px;
            padding: 4px 0;
            color: #000000;
            line-height: 140%;
            transition: background 0.3s;
        }

        .contact-item-12:hover,
        .education-item-12:hover,
        .experience-item-12:hover,
        .language-item-12:hover,
        .hobbies-item-12:hover,
        .skill-item-12:hover {
            background: rgba(255, 179, 23, 0.2);
        }

        .contact-link-12 {
            color: inherit;
            text-decoration: none;
        }

        /* Right side styles */
        .right-side-12 {
            background: #f5f5f5;
            color: #000000;
            padding: 30px;
        }

        .name-heading-12 {
            color: #000000;
            font-size: 26px;
            font-weight: 400;
            padding-top: 20px;
        }

        .designation-12 {
            font-weight: 400;
            color: #000000;
            margin-top: 10px;
        }

        .description-12 {
            font-size: 16px;
            padding: 10px 0 10px 0;
        }

        .section-heading-12 {
            font-weight: 700;
            color: #000;
            border-bottom: 1px solid #000;
            padding-bottom: 5px;
            margin-bottom: 15px;
            text-transform: uppercase;
            font-size: 18px
        }

        .references-12 {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            padding: 10px 0;
        }

        .reference-item-12 {
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

        .reference-item-12:hover {
            transform: translateY(-3px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }

        .reference-item-12 h3 {
            padding: 4px 0;
            font-size: 18px;
            font-weight: bold;
        }

        .reference-item-12 p {
            padding: 3px 0;
            margin: 0;
        }

        .reference-item-12 a {
            color: inherit;
            text-decoration: none;
        }

        .reference-item-12 a:hover {
            color: #000;
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <table>
        <tr>
            <!-- Left side -->
            <td style="width: 20%; height:100%; vertical-align: top; background-color: #f1f1f1;">
                <div class="left-side-12">
                    <div style="width: 100%;text-align: center;padding-top:20px;">
                        <img src="https://i.postimg.cc/1zSsmrt2/Rectangle-25164.png" alt="Profile-image"
                            style=" width: 170px;height: 170px; object-fit: cover; position: relative;z-index: 1;border: 2px solid #ffffff;border-radius: 50%;object-fit: cover;">
                        <h1 class="name-heading-12"><b>Pronub</b> Shaharier</h1>
                        <p class="designation-12">Full Stack Developer</p>
                    </div>

                    <div style="padding:20px;">
                        <h2 class="sub-heading-12">Contact</h2>
                        <ul class="contact-list-12">
                            <li class="contact-item-12">
                                <p style="font-size: 14px">Phone</p>
                                <a href="tel:123-456-7890" class="contact-link-12">123-456-7890</a>
                            </li>
                            <li class="contact-item-12">
                                <p style="font-size: 14px">Email</p>
                                <a href="mailto:jahanara.womeningdigital@gmail.com"
                                    class="contact-link-12">jahanara.womeningdigital@gmail.com</a>
                            </li>
                            <li class="contact-item-12">
                                <p style="font-size: 14px">Address</p>
                                <p>0-51, Janata Co-operative Housing Society, Mohammadpur, Dhaka,
                                    Bangladesh</p>
                            </li>
                        </ul>
                       
                        <h2 class="sub-heading-12" style="padding-bottom: 10px">Skills</h2>
                        <ul class="skill-list-12">
                            <li class="skill-item-12">English</li>
                            <li class="skill-item-12">Bangla</li>
                            <li class="skill-item-12">English</li>
                            <li class="skill-item-12">Bangla</li>
                        </ul>


                        {{-- <h2 class="sub-heading-12">Languages</h2> --}}
                        {{-- <ul class="language-list-12">
                            <li class="language-item-12">English</li>
                            <li class="language-item-12">Bangla</li>
                            <li class="language-item-12">English</li>
                            <li class="language-item-12">Bangla</li>
                        </ul> --}}
                        <h2 class="sub-heading-12">Languages</h2>
                        <table style="width: 100%; padding-top:10px;">
                            <tr>
                                <td style="font-size: 10px; white-space: nowrap;">
                                    <span class="custom-border">UI/UX</span>
                                </td>
                                <td style="font-size: 10px; white-space: nowrap;">
                                    <span class="custom-border">Visual Design</span>
                                </td>
                            </tr>
                            <tr>
                                <td style="font-size: 10px; white-space: nowrap;">
                                    <span class="custom-border">Wireframes</span>
                                </td>
                                <td style="font-size: 10px; white-space: nowrap;">
                                    <span class="custom-border">Storyboards</span>
                                </td>
                            </tr>
                            <tr>
                                <td style="font-size: 10px; white-space: nowrap;">
                                    <span class="custom-border">Wireframes</span>
                                </td>
                                <td style="font-size: 10px; white-space: nowrap;">
                                    <span class="custom-border">Storyboards</span>
                                </td>
                            </tr>
                        </table>
                        <h2 class="sub-heading-12">Interests</h2>
                        <table style="width: 100%; padding-top:10px;">
                            <tr>
                                <td style="font-size: 10px; white-space: nowrap;">
                                    <span class="custom-border">UI/UX</span>
                                </td>
                                <td style="font-size: 10px; white-space: nowrap;">
                                    <span class="custom-border">Visual Design</span>
                                </td>
                            </tr>
                            <tr>
                                <td style="font-size: 10px; white-space: nowrap;">
                                    <span class="custom-border">Wireframes</span>
                                </td>
                                <td style="font-size: 10px; white-space: nowrap;">
                                    <span class="custom-border">Storyboards</span>
                                </td>
                            </tr>
                            <tr>
                                <td style="font-size: 10px; white-space: nowrap;">
                                    <span class="custom-border">Wireframes</span>
                                </td>
                                <td style="font-size: 10px; white-space: nowrap;">
                                    <span class="custom-border">Storyboards</span>
                                </td>
                            </tr>
                        </table>

                    </div>
                </div>
            </td>

            <!-- Right side -->
            <td style="width: 80%; background-color: #f5f5f5;vertical-align: top; ">
                <div class="right-side-12">
                    <table>
                        <tr>
                            <td>
                                <p class="description-12" style="font-size: 12px;margin-right: 20px;">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                                    incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
                                    exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                                </p>
                            </td>
                            <td style="text-align: right;">
                                <img src="https://i.postimg.cc/cLwdGbsf/QR.png" alt="QR Code" class="qr-image-12" />
                            </td>
                        </tr>
                    </table>
                    <h2 class="section-heading-12" style="margin-top: 15px">Experience</h2>
                    <ul class="experience-list-12">
                        <li class="experience-item-12" style="color: #000; padding-top: 10px">
                            <table width="100%" cellspacing="0" cellpadding="0" border="0">
                                <tr>
                                    <td width="35%" valign="top" align="left">
                                        <p style="margin-bottom:5px; font-size:12px;">2019 - 2022</p>
                                        <h3 style="font-size:12px; font-weight: bold; margin-bottom:7px;">Company Name |
                                            123 Anywhere St. Any City</h3>
                                        <p style="font-size:12px; margin: 0;">Job Position</p>
                                    </td>
                                    <td width="5%"></td>
                                    <td width="60%" valign="top" align="right" style="text-align: left;">
                                        <p style="font-size:12px;">Sed ut perspiciatis unde omnis iste natus error sit
                                            voluptatem accusantium doloremque laudantium. Sed audantium. Audantium. Ut
                                            perspiciatis unde omnis iste voluptatem accusantium doloremque laudantium.
                                            Sed audantium.</p>
                                    </td>
                                </tr>
                            </table>
                        </li>
                        <li class="experience-item-12" style="color: #000; padding-top: 10px">
                            <table width="100%" cellspacing="0" cellpadding="0" border="0">
                                <tr>
                                    <td width="35%" valign="top" align="left">
                                        <p style="margin-bottom:5px; font-size:12px;">2019 - 2022</p>
                                        <h3 style="font-size:12px; font-weight: bold; margin-bottom:7px;">Company Name |
                                            123 Anywhere St. Any City</h3>
                                        <p style="font-size:12px; margin: 0;">Job Position</p>
                                    </td>
                                    <td width="5%"></td>
                                    <td width="60%" valign="top" align="right" style="text-align: left;">
                                        <p style="font-size:12px;">Sed ut perspiciatis unde omnis iste natus error sit
                                            voluptatem accusantium doloremque laudantium. Sed audantium. Audantium. Ut
                                            perspiciatis unde omnis iste voluptatem accusantium doloremque laudantium.
                                            Sed audantium.</p>
                                    </td>
                                </tr>
                            </table>
                        </li>
                        <li class="experience-item-12" style="color: #000; padding-top: 10px">
                            <table width="100%" cellspacing="0" cellpadding="0" border="0">
                                <tr>
                                    <td width="35%" valign="top" align="left">
                                        <p style="margin-bottom:5px; font-size:12px;">2019 - 2022</p>
                                        <h3 style="font-size:12px; font-weight: bold; margin-bottom:7px;">Company Name
                                            | 123 Anywhere St. Any City</h3>
                                        <p style="font-size:12px; margin: 0;">Job Position</p>
                                    </td>
                                    <td width="5%"></td>
                                    <td width="60%" valign="top" align="right" style="text-align: left;">
                                        <p style="font-size:12px;">Sed ut perspiciatis unde omnis iste natus error sit
                                            voluptatem accusantium doloremque laudantium. Sed audantium. Audantium. Ut
                                            perspiciatis unde omnis iste voluptatem accusantium doloremque laudantium.
                                            Sed audantium.</p>
                                    </td>
                                </tr>
                            </table>
                        </li>
                    </ul>
                    <h2 class="section-heading-12" style="margin-top: 15px">Education</h2>
                    <ul class="experience-list-12">
                        <li class="experience-item-12" style="color: #000; padding-top: 10px">
                            <table width="100%" cellspacing="0" cellpadding="0" border="0">
                                <tr>
                                    <td width="40%" valign="top" align="left">
                                        <span style="font-size: 12px">2008</span>
                                        <p style="font-size: 14px">Enter Your Degree
                                        </p>
                                        <p style="font-size: 12px">Grade</p>
                                        <p style="font-size: 12px">University of Liberal Arts Bangladesh</p>
                                    </td>
                                    
                                    <td width="60%" valign="top" align="right" style="text-align: left;">
                                        <p style="font-size:12px;">Sed ut perspiciatis unde omnis iste natus error sit
                                            voluptatem accusantium doloremque laudantium. Sed audantium. Audantium. Ut
                                            perspiciatis unde omnis iste voluptatem accusantium doloremque laudantium.
                                            Sed audantium.</p>
                                    </td>
                                </tr>
                            </table>
                        </li>
                        <li class="experience-item-12" style="color: #000; padding-top: 10px">
                            <table width="100%" cellspacing="0" cellpadding="0" border="0">
                                <tr>
                                    <td width="40%" valign="top" align="left">
                                        <span style="font-size: 12px">2008</span>
                                        <p style="font-size: 14px">Enter Your Degree
                                        </p>
                                        <p style="font-size: 12px">Grade</p>
                                        <p style="font-size: 12px">University of Liberal Arts Bangladesh</p>
                                    </td>
                                    
                                    <td width="60%" valign="top" align="right" style="text-align: left;">
                                        <p style="font-size:12px;">Sed ut perspiciatis unde omnis iste natus error sit
                                            voluptatem accusantium doloremque laudantium. Sed audantium. Audantium. Ut
                                            perspiciatis unde omnis iste voluptatem accusantium doloremque laudantium.
                                            Sed audantium.</p>
                                    </td>
                                </tr>
                            </table>
                        </li>
                        <li class="experience-item-12" style="color: #000; padding-top: 10px">
                            <table width="100%" cellspacing="0" cellpadding="0" border="0">
                                <tr>
                                    <td width="40%" valign="top" align="left">
                                        <span style="font-size: 12px">2008</span>
                                        <p style="font-size: 14px">Enter Your Degree
                                        </p>
                                        <p style="font-size: 12px">Grade</p>
                                        <p style="font-size: 12px">University of Liberal Arts Bangladesh</p>
                                    </td>
                                    
                                    <td width="60%" valign="top" align="right" style="text-align: left;">
                                        <p style="font-size:12px;">Sed ut perspiciatis unde omnis iste natus error sit
                                            voluptatem accusantium doloremque laudantium. Sed audantium. Audantium. Ut
                                            perspiciatis unde omnis iste voluptatem accusantium doloremque laudantium.
                                            Sed audantium.</p>
                                    </td>
                                </tr>
                            </table>
                        </li>
                    </ul>
                    <h2 class="section-heading-12" style="margin-top: 15px">References</h2>
                    <table style="width: 100%;">
                        <tr>
                            <td>
                                <h3 style="font-size: 16px; padding-bottom:7px">Name Surname</h3>
                                <p style="font-size: 12px; padding-bottom:5px">Job Position, Company</p>
                                <p style="font-size: 12px; padding-bottom:5px">Phone: <span> <a
                                            href="tel:123-456-7890" class="contact-link-12">123-456-7890</a></span>
                                </p>
                                <p style="font-size: 12px;padding-bottom:5px">Email: <a
                                        href="mailto:jahanara.womeningdigital@gmail.com"
                                        class="contact-link-12">jahanara.womeningdigital@gmail.com</a> </p>
                            </td>
                            <td>
                                <h3 style="font-size: 16px; padding-bottom:7px">Name Surname</h3>
                                <p style="font-size: 12px; padding-bottom:5px">Job Position, Company</p>
                                <p style="font-size: 12px; padding-bottom:5px">Phone: <span> <a
                                            href="tel:123-456-7890" class="contact-link-12">123-456-7890</a></span>
                                </p>
                                <p style="font-size: 12px;padding-bottom:5px">Email: <a
                                        href="mailto:jahanara.womeningdigital@gmail.com"
                                        class="contact-link-12">jahanara.womeningdigital@gmail.com</a> </p>
                            </td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
    </table>
</body>

</html>
