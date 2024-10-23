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
            background: #f5f5f5;

        }

        .main-body-15 {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            color: #32353A;
        }

        /* Table styling */
        table {
            width: 100%;
            height: 100vh;
            border-spacing: 0;
            border-collapse: collapse;

        }

        .qr-image-15 {
            width: 100px;
            height: 100px;
            object-fit: cover;
            margin-top: 20px;
        }

        .sub-heading-15 {
            color: #B3835A;
            font-size: 16px;
            padding: 15px 0;
            border-bottom: 1px solid #fff;
            text-transform: uppercase;
            padding-bottom: 6px;
            font-weight: 600;
        }

       

        .contact-item-15,
        .education-item-15,
        .experience-item-15,
        .language-item-15,
        .hobbies-item-15,
        .skill-item-15 {
            list-style: none;
            font-size: 12px;
            padding: 4px 0;
            color: #ffffff;
            line-height: 140%;
            transition: background 0.3s;
        }
    
        .contact-item-15:hover,
        .education-item-15:hover,
        .experience-item-15:hover,
        .language-item-15:hover,
        .hobbies-item-15:hover,
        .skill-item-15:hover {
            background: rgba(255, 179, 23, 0.2);
        }

        .contact-link-15 {
            color: inherit;
            text-decoration: none;
        }

        /* Right side styles */
        .right-side-15 {
            /* background: #f5f5f5; */
            color: #32353A;
            padding: 30px;
        }

        .name-heading-15 {
            color: #ffffff;
            font-size: 26px;
            font-weight: 400;
            padding-top: 15px;
            padding-left: 20px;
        }

        .designation-15 {
            font-weight: 400;
            color: #ffffff;
            padding-left: 20px;
            /* margin-top: 10px; */
        }

        .description-15 {
            font-size: 16px;
            padding: 10px 0 10px 0;
        }

        .section-heading-15 {
            font-weight: 700;
            color: #B3835A;
            border-bottom: 1px solid #32353A;
            padding-bottom: 5px;
            margin-bottom: 15px;
            text-transform: uppercase;
            font-size: 18px
        }

        .references-15 {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            padding: 10px 0;
        }

        .reference-item-15 {
            color: #32353A;
            line-height: 15px;
            flex: 0 1 calc(50% - 10px);
            box-sizing: border-box;
            font-size: 15px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .reference-item-15:hover {
            transform: translateY(-3px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }

        .reference-item-15 h3 {
            padding: 4px 0;
            font-size: 18px;
            font-weight: bold;
        }

        .reference-item-15 p {
            padding: 3px 0;
            margin: 0;
        }

        .reference-item-15 a {
            color: inherit;
            text-decoration: none;
        }

        .reference-item-15 a:hover {
            color: #32353A;
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <table>
        <tr>
            <!-- Left side -->
            <td style="width: 21%; height:100%; vertical-align: top; background-color: #32353A;">
                <div class="left-side-15">
                    <div style="width:100%">
                        <img src="https://i.postimg.cc/1zSsmrt2/Rectangle-25164.png" alt="Profile-image"
                    style=" width: 227px;height: 227px;object-fit: cover;">
                    </div>
                    <div style="width: 100%;padding:0px 0px 20px 0px;background-color: #B3835A">
                        <h1 class="name-heading-15"><b>Pronub</b> Shaharier</h1>
                        <p class="designation-15">Full Stack Developer</p>
                    </div>

                    <div style="padding:20px;">
                        <h2 class="sub-heading-15">Contact</h2>
                        <ul class="contact-list-15">
                            <li class="contact-item-15">
                                <p style="font-size: 14px">Phone</p>
                                <a href="tel:123-456-7890" class="contact-link-15">123-456-7890</a>
                            </li>
                            <li class="contact-item-15">
                                <p style="font-size: 14px">Email</p>
                                <a href="mailto:jahanara.womeningdigital@gmail.com"
                                    class="contact-link-15">jahanara.womeningdigital@gmail.com</a>
                            </li>
                            <li class="contact-item-15">
                                <p style="font-size: 14px">Address</p>
                                <p>0-51, Janata Co-operative Housing Society, Mohammadpur, Dhaka,
                                    Bangladesh</p>
                            </li>
                        </ul>
                       
                        <h2 class="sub-heading-15" style="padding-bottom: 10px">Skills</h2>
                        <ul class="skill-list-15">
                            <li class="skill-item-15">English</li>
                            <li class="skill-item-15">Bangla</li>
                            <li class="skill-item-15">English</li>
                            <li class="skill-item-15">Bangla</li>
                        </ul>


                        <h2 class="sub-heading-15">Languages</h2>
                        <table style="width: 100%; padding-top:10px;">
                            <tr>
                                <td style="font-size: 10px; white-space: nowrap;color:#fff">
                                    <span class="custom-border" >UI/UX</span>
                                </td>
                                <td style="font-size: 10px; white-space: nowrap;color:#fff">
                                    <span class="custom-border">Visual Design</span>
                                </td>
                            </tr>
                            <tr>
                                <td style="font-size: 10px; white-space: nowrap;color:#fff">
                                    <span class="custom-border">Wireframes</span>
                                </td>
                                <td style="font-size: 10px; white-space: nowrap;color:#fff">
                                    <span class="custom-border">Storyboards</span>
                                </td>
                            </tr>
                            <tr>
                                <td style="font-size: 10px; white-space: nowrap;color:#fff">
                                    <span class="custom-border">Wireframes</span>
                                </td>
                                <td style="font-size: 10px; white-space: nowrap;color:#fff">
                                    <span class="custom-border">Storyboards</span>
                                </td>
                            </tr>
                        </table>

                       
                        <h2 class="sub-heading-15">Interests</h2>
                        <table style="width: 100%; padding-top:10px;">
                            <tr>
                                <td style="font-size: 10px; white-space: nowrap;color:#fff">
                                    <span class="custom-border">UI/UX</span>
                                </td>
                                <td style="font-size: 10px; white-space: nowrap;color:#fff">
                                    <span class="custom-border">Visual Design</span>
                                </td>
                            </tr>
                            <tr>
                                <td style="font-size: 10px; white-space: nowrap;color:#fff">
                                    <span class="custom-border">Wireframes</span>
                                </td>
                                <td style="font-size: 10px; white-space: nowrap;color:#fff">
                                    <span class="custom-border">Storyboards</span>
                                </td>
                            </tr>
                            <tr>
                                <td style="font-size: 10px; white-space: nowrap;color:#fff">
                                    <span class="custom-border">Wireframes</span>
                                </td>
                                <td style="font-size: 10px; white-space: nowrap;color:#fff">
                                    <span class="custom-border">Storyboards</span>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </td>

            <!-- Right side -->
            <td style="vertical-align: top; ">
                <div class="right-side-15">
                    <table>
                        <tr>
                            <td>
                                <p class="description-15" style="font-size: 12px;margin-right: 20px;">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                                    incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
                                    exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                                </p>
                            </td>
                            <td style="text-align: right;">
                                <img src="https://i.postimg.cc/cLwdGbsf/QR.png" alt="QR Code" class="qr-image-15" />
                            </td>
                        </tr>
                    </table>
                    <h2 class="section-heading-15" style="margin-top: 15px">Experience</h2>
                    <ul class="experience-list-15">
                        <li class="experience-item-15" style="color: #32353A; padding-top: 10px">
                            <table width="100%" cellspacing="0" cellpadding="0" border="0">
                                <tr>
                                    <td width="35%" valign="top" align="left">
                                        <p style="margin-bottom:5px; font-size:12px;">2019 - 2022</p>
                                        <h3 style="font-size:12px; font-weight: bold; margin-bottom:7px;">Company Name |
                                            123 Anywhere St. Any City</h3>
                                        <p style="font-size:12px; margin: 0; color:#B3835A">Job Position</p>
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
                        <li class="experience-item-15" style="color: #32353A; padding-top: 10px">
                            <table width="100%" cellspacing="0" cellpadding="0" border="0">
                                <tr>
                                    <td width="35%" valign="top" align="left">
                                        <p style="margin-bottom:5px; font-size:12px;">2019 - 2022</p>
                                        <h3 style="font-size:12px; font-weight: bold; margin-bottom:7px;">Company Name |
                                            123 Anywhere St. Any City</h3>
                                        <p style="font-size:12px; margin: 0; color:#B3835A">Job Position</p>
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
                        <li class="experience-item-15" style="color: #32353A; padding-top: 10px">
                            <table width="100%" cellspacing="0" cellpadding="0" border="0">
                                <tr>
                                    <td width="35%" valign="top" align="left">
                                        <p style="margin-bottom:5px; font-size:12px;">2019 - 2022</p>
                                        <h3 style="font-size:12px; font-weight: bold; margin-bottom:7px;">Company Name
                                            | 123 Anywhere St. Any City</h3>
                                        <p style="font-size:12px; margin: 0; color:#B3835A">Job Position</p>
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
                    <h2 class="section-heading-15" style="margin-top: 15px">Education</h2>
                    <ul class="experience-list-15">
                        <li class="experience-item-15" style="color: #32353A; padding-top: 10px">
                            <table width="100%" cellspacing="0" cellpadding="0" border="0">
                                <tr>
                                    <td width="40%" valign="top" align="left">
                                        <span style="font-size: 12px">2008</span>
                                        <p style="font-size: 14px; color:#B3835A">Enter Your Degree
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
                        <li class="experience-item-15" style="color: #32353A; padding-top: 10px">
                            <table width="100%" cellspacing="0" cellpadding="0" border="0">
                                <tr>
                                    <td width="40%" valign="top" align="left">
                                        <span style="font-size: 12px">2008</span>
                                        <p style="font-size: 14px; color:#B3835A">Enter Your Degree
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
                        <li class="experience-item-15" style="color: #32353A; padding-top: 10px">
                            <table width="100%" cellspacing="0" cellpadding="0" border="0">
                                <tr>
                                    <td width="40%" valign="top" align="left">
                                        <span style="font-size: 12px">2008</span>
                                        <p style="font-size: 14px; color:#B3835A">Enter Your Degree
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
                    <h2 class="section-heading-15" style="margin-top: 15px">References</h2>
                    <table style="width: 100%;">
                        <tr>
                            <td>
                                <h3 style="font-size: 16px; padding-bottom:7px">Name Surname</h3>
                                <p style="font-size: 12px; padding-bottom:5px">Job Position, Company</p>
                                <p style="font-size: 12px; padding-bottom:5px">Phone: <span> <a
                                            href="tel:123-456-7890" class="contact-link-15">123-456-7890</a></span>
                                </p>
                                <p style="font-size: 12px;padding-bottom:5px">Email: <a
                                        href="mailto:jahanara.womeningdigital@gmail.com"
                                        class="contact-link-15">jahanara.womeningdigital@gmail.com</a> </p>
                            </td>
                            <td>
                                <h3 style="font-size: 16px; padding-bottom:7px">Name Surname</h3>
                                <p style="font-size: 12px; padding-bottom:5px">Job Position, Company</p>
                                <p style="font-size: 12px; padding-bottom:5px">Phone: <span> <a
                                            href="tel:123-456-7890" class="contact-link-15">123-456-7890</a></span>
                                </p>
                                <p style="font-size: 12px;padding-bottom:5px">Email: <a
                                        href="mailto:jahanara.womeningdigital@gmail.com"
                                        class="contact-link-15">jahanara.womeningdigital@gmail.com</a> </p>
                            </td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
    </table>
</body>

</html>
