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

        .main-body-13 {
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
            width: 100px;
            height: 180px;
            background-color: #F97700;
            margin: 0 auto;
            position: relative;
            text-align: center;
            margin-bottom: 20px;
        }
        .image-container-bottom{
            width: 100%;
            height: 20px;
            background-color: #F97700;
            bottom: 0;
            right: 0;
            position: absolute;
        }
        .qr-image-13 {
            width: 80px;
            height: 80px;
            object-fit: cover;
            position: absolute;
            top: 49%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .sub-heading-13 {
            color: #F97700;
            font-size: 16px;
            padding: 15px 0;
            border-bottom: 1px solid #000;
            text-transform: uppercase;
            padding-bottom:6px;
            font-weight: 600;
        }

        .contact-list-13,
        .education-list-13,
        .experience-list-13,
        .language-list-13,
        .hobbies-list-13,
        .skill-list-13 {
            padding-left: 0;
            padding-right: 20px;            
        }

        .contact-item-13,
        .education-item-13,
        .experience-item-13,
        .language-item-13,
        .hobbies-item-13,
        .skill-item-13 {
            list-style: none;
            font-size: 12px;
            padding: 4px 0;
            color: #000;
            line-height: 140%;
            transition: background 0.3s;
        }

        .experience-item-13{
            border-bottom: 1px solid #000000;
        }
        .experience-item-13:last-child{
            border-bottom: none;
        }

        .contact-item-13:hover,
        .education-item-13:hover,
        .experience-item-13:hover,
        .language-item-13:hover,
        .hobbies-item-13:hover,
        .skill-item-13:hover {
            background: rgba(255, 179, 23, 0.2);
        }

        .contact-link-13 {
            color: inherit;
            text-decoration: none;
        }

        .skill-13 {
            list-style-type: none;
            padding: 10px 0;
            font-size: 13px;
            display: flex;
            flex-wrap: wrap;
            color: #fff;
        }

        .skill-13 li {
            width: 50%;
            padding: 5px 0;
        }

        /* Right side styles */
        .right-side-13 {
            background: #ffffff;
            color: #000000;
            padding:0 30px 30px;
        }

        .name-heading-13 {
            color: #000000;
            font-size: 30px;
            font-weight: 400;
            padding-top: 15px;
        }

        .designation-13 {
            font-weight: 400;
            color: #F97700;
            margin-top: 10px;
        }

        .description-13 {
            font-size: 16px;
            padding: 10px 0 10px 0;
        }

        .section-heading-13 {
            font-weight: 700;
            color: #F97700;
            border-bottom: 1px solid #000;
            padding-bottom: 5px;
            margin-bottom: 15px;
            text-transform: uppercase;
            font-size: 18px
        }

        .references-13 {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            padding: 10px 0;
        }

        .reference-item-13 {
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

        .reference-item-13:hover {
            transform: translateY(-3px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }

        .reference-item-13 h3 {
            padding: 4px 0;
            font-size: 18px;
            font-weight: bold;
        }

        .reference-item-13 p {
            padding: 3px 0;
            margin: 0;
        }

        .reference-item-13 a {
            color: inherit;
            text-decoration: none;
        }

        .reference-item-13 a:hover {
            color: #F97700;
            text-decoration: underline;
        }
      
    </style>
</head>

<body>
    <table>
        <tr>
            <!-- Left side -->
            <td style="width: 80%; background-color: #ffffff;vertical-align: top; ">
                <div class="right-side-13">
                    <table style="border-collapse: separate;border-spacing: 0px 20px 0 0;">
                        <tr>
                            <div class="image-container">
                                <img src="https://i.postimg.cc/cLwdGbsf/QR.png" alt="QR Code" class="qr-image-13" />
                            </div>
                            <td>
                               <div style="margin-left: 20px">
                                    <h1 class="name-heading-13"><b>Pronub</b> Shaharier</h1>
                                    <p class="designation-13">Full Stack Developer</p>
                                    <p class="description-13" style="font-size: 12px">
                                        I am a passionate Full Stack Developer with expertise in creating dynamic and responsive web applications.
                                        I am a passionate Full Stack Developer with expertise in creating dynamic and responsive web applications.
                                       
                                    </p>
                               </div>
                            </td>
                        </tr>
                    </table>
                    <h2 class="section-heading-13" style="margin-top: 15px">Experience</h2>
                    <ul class="experience-list-13">
                        <li class="experience-item-13" style="color: #000">

                            <p style="margin-bottom:5px; font-size:12px; color: #F97700">2019 - 2022</p>
                            <h3 style="font-size:16px; font-weight: 600; padding-bottom:7px">Company Name | 123 Anywhere St. Any
                                City

                            </h3>
                            <p style="font-size: 15px; padding-bottom:7px; color: #F97700">Job Position</p>
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
                        <li class="experience-item-13" style="color: #000">

                            <p style="margin-bottom:5px; font-size:12px; color: #F97700">2019 - 2022</p>
                            <h3 style="font-size:16px; font-weight: 600; padding-bottom:7px">Company Name | 123 Anywhere St. Any
                                City

                            </h3>
                            <p style="font-size: 15px; padding-bottom:7px;color: #F97700">Job Position</p>
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
                        <li class="experience-item-13" style="color: #000">

                            <p style="margin-bottom:5px; font-size:12px ;padding-bottom:7px; color: #F97700">2019 - 2022</p>
                            <h3 style="font-size:16px; font-weight: 600; padding-bottom:7px">Company Name | 123 Anywhere St. Any
                                City

                            </h3>
                            <p style="font-size: 15px; padding-bottom:7px;color: #F97700">Job Position</p>
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
                    <h2 class="section-heading-13" style="margin-top: 15px">References</h2>
                   <table style="width: 100%;">
                        <tr>
                            <td>
                                <h3 style="font-size: 16px; padding-bottom:7px">Name Surname</h3>
                                <p style="font-size: 12px; padding-bottom:5px">Job Position, Company</p>
                                <p style="font-size: 12px; padding-bottom:5px">Phone: <span> <a href="tel:123-456-7890"
                                            class="contact-link-13">123-456-7890</a></span></p>
                                <p style="font-size: 12px;padding-bottom:5px">Email: <a
                                        href="mailto:jahanara.womeningdigital@gmail.com"
                                        class="contact-link-13">jahanara.womeningdigital@gmail.com</a> </p>
                            </td>
                            <td>
                                <h3 style="font-size: 16px; padding-bottom:7px">Name Surname</h3>
                                <p style="font-size: 12px; padding-bottom:5px">Job Position, Company</p>
                                <p style="font-size: 12px; padding-bottom:5px">Phone: <span> <a href="tel:123-456-7890"
                                            class="contact-link-13">123-456-7890</a></span></p>
                                <p style="font-size: 12px;padding-bottom:5px">Email: <a
                                        href="mailto:jahanara.womeningdigital@gmail.com"
                                        class="contact-link-13">jahanara.womeningdigital@gmail.com</a> </p>
                            </td>
                        </tr>
                    </table>
                </div>
            </td>

            <!-- Right side -->
            <td style="width: 20%; height:100%; vertical-align: top; background-color: #ffffff;position: relative">
                
                <div class="left-side-13">
                    <div style="width: 100%;text-align: center;padding-top:20px;">
                        <img src="https://i.postimg.cc/1zSsmrt2/Rectangle-25164.png" alt="Profile-image" style=" width: 170px;height: 170px; object-fit: cover; position: relative;z-index: 1;border: 2px solid #F97700;border-radius: 50%;object-fit: cover;">
                    </div>
                    <div style="padding:20px 0 20px 20px;">
                        <h2 class="sub-heading-13">Contact</h2>
                        <ul class="contact-list-13">
                            <li class="contact-item-13">
                                <p style="font-size: 14px">Phone</p>
                                <a href="tel:123-456-7890"
                                    class="contact-link-13">123-456-7890</a></li>
                            <li class="contact-item-13">
                                <p style="font-size: 14px">Email</p>
                                <a href="mailto:jahanara.womeningdigital@gmail.com"
                                    class="contact-link-13">jahanara.womeningdigital@gmail.com</a></li>
                            <li class="contact-item-13">
                                <p style="font-size: 14px">Address</p>
                                <p>0-51, Janata Co-operative Housing Society, Mohammadpur, Dhaka,
                                    Bangladesh</p>
                                </li>
                        </ul>
                        <h2 class="sub-heading-13">Education</h2>
                        <ul class="education-list-13" style="margin-bottom: 7px">
                            <li class="education-item-13">
                                <span style="font-size: 12px">2008</span>
                                <p style="font-size: 14px">Enter Your Degree
                                </p>
                                <p style="font-size: 12px">Grade</p>
                                <p style="font-size: 12px">2008 - University of Liberal Arts Bangladesh</p>
                            </li>
                        </ul>
                        <h2 class="sub-heading-13" style="padding-bottom: 10px">Skills</h2>
                        <ul class="skill-list-13">
                            <li class="skill-item-13">English</li>
                            <li class="skill-item-13">Bangla</li>
                        </ul>

                       
                        <h2 class="sub-heading-13">Languages</h2>
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
                        <h2 class="sub-heading-13">Interests</h2>
                        <ul class="hobbies-list-13">
                            <li class="hobbies-item-13">Music</li>
                            <li class="hobbies-item-13">Reading</li>
                        </ul>
                        
                    </div>
                </div>
                <div class="image-container-bottom">
                </div>
            </td>
        </tr>
    </table>
</body>

</html>
