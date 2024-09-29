<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resume</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <link rel="stylesheet" href="style_7.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial Narrow', Arial, sans-serif;
        }

        .main-body-4 {
            margin: 0 auto;
            min-height: 100vh;
            color: #000000;
            position: relative;
            max-width: 790px;
            box-shadow: 0 35px 55px rgba(0, 0, 0, 0.2);
            padding: 20px;
            background: #ffffff;
        }

        .header {
            background-color: #4391CF;
            color: #ffffff;
            padding: 10px 20px 20px 40px;
        }

        .header h1 {
            font-size: 42px;
            font-weight: 400;
        }

        .header h2 {
            font-weight: 400;
            line-height: 19px;
            letter-spacing: 2px;
        }

        .header p {
            font-size: 16px;
            font-weight: 400;
            line-height: 140%;
        }

        /* Table layout to ensure both sections are side by side */
        .content-table {
            width: 100%;
            border-spacing: 0;
        }

        .left-section,
        .right-section {
            padding: 20px;
            vertical-align: top;
        }

        .left-section {
            width: 70%;
            background: #ffffff;
        }

        .right-section {
            width: 30%;
            background: #F5F5F5;
        }

        .job-7 {
            list-style: none;
            position: relative;
            display: flex;
            align-items: center;
        }

        .job-7::before {
            content: "";
            position: absolute;
            top: 0;
            width: 10px;
            height: 10px;
            background-color: #ffffff;
            border: 1px solid #000000;
            border-radius: 50%;
            z-index: 1;
        }

        .job-7-description {
            text-align: justify;
            padding-bottom: 20px;
        }

        .job-7:last-child .job-7-description {
            padding-bottom: 0;
        }
    </style>
</head>

<body>
    <div class="main-body-4">
        <div class="header">
            <div
                style="position: relative;margin: 0px 0 0 -20px;background-color: #4391CF;color: #ffffff;padding: 10px 20px 20px 40px;">
                <h1 style="color:#ffffff ;font-size: 42px;font-weight: 400;"><span
                        style=" color:#ffffff ;font-size: 42px;font-weight: 900;margin-right: 15px;">Pronub</span>Shaharier
                </h1>
                <div style="margin-right: 120px;">
                    <h2
                        style="font-weight: 400;line-height: 19px;letter-spacing: 2px;text-align: left;color: #ffffff;padding: 10px 0;">
                        Marketing Manager</h2>
                    <p
                        style="font-size: 16px;font-weight: 400;padding: 10px 130px 10px 0;text-align: justify;line-height: 140%;">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                        labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
                        laboris nisi ut aliquip ex ea commodo consequat.</p>
                </div>
            </div>
        </div>
        <table class="content-table">
            <tr>
                <td class="left-section">
                    <h2 style="font-weight: 700; color: #4391CF; border-bottom: 2px solid #000; padding-bottom: 10px;">
                        Experience</h2>
                    <ul style="margin: 20px 0;">
                        <li class="job-7">
                            <div
                                style="width: 2px; background-color: #000000; position: absolute; top: 0; bottom: 0; left: 5px; z-index: 0;">
                            </div>
                            <div style="padding-left: 25px; box-sizing: border-box;">
                                <p style="margin-bottom: 5px; position: relative; z-index: 2;">2019 - 2022</p>
                                <p style="padding: 5px 0;">Company Name | 123 Anywhere St. Any City</p>
                                <h3 style="padding: 5px 0; font-size: 16px;">Job Position Here</h3>
                                <p class="job-7-description">Sed ut perspiciatis unde omnis iste natus error sit
                                    voluptatem
                                    accusantium doloremque laudantium.</p>
                            </div>
                        </li>
                        <li class="job-7">
                            <div
                                style="width: 2px; background-color: #000000; position: absolute; top: 0; bottom: 0; left: 5px; z-index: 0;">
                            </div>
                            <div style="padding-left: 25px; box-sizing: border-box;">
                                <p style="margin-bottom: 5px; position: relative; z-index: 2;">2019 - 2022</p>
                                <p style="padding: 5px 0;">Company Name | 123 Anywhere St. Any City</p>
                                <h3 style="padding: 5px 0; font-size: 16px;">Job Position Here</h3>
                                <p class="job-7-description">Sed ut perspiciatis unde omnis iste natus error sit
                                    voluptatem
                                    accusantium doloremque laudantium.</p>
                            </div>
                        </li>
                        <li class="job-7">
                            <div
                                style="width: 2px; background-color: #000000; position: absolute; top: 0; bottom: 0; left: 5px; z-index: 0;">
                            </div>
                            <div style="padding-left: 25px; box-sizing: border-box;">
                                <p style="margin-bottom: 5px; position: relative; z-index: 2;">2019 - 2022</p>
                                <p style="padding: 5px 0;">Company Name | 123 Anywhere St. Any City</p>
                                <h3 style="padding: 5px 0; font-size: 16px;">Job Position Here</h3>
                                <p class="job-7-description">Sed ut perspiciatis unde omnis iste natus error sit
                                    voluptatem
                                    accusantium doloremque laudantium.</p>
                            </div>
                        </li>

                    </ul>
                    <h2 style="font-weight: 700; color: #4391CF; border-bottom: 2px solid #000; padding-block: 10px;">
                        References</h2>
                    <div style="display: flex; flex-wrap: wrap; gap: 20px; padding: 10px 0; font-size: 14px;">
                        <div style="flex: 0 1 calc(50% - 10px); box-sizing: border-box;">
                            <h3 style="padding: 4px 0; font-size: 18px;">Name (Surname)</h3>
                            <p>Job Position | Company Name</p>
                            <p>
                                <span><b>Phone:</b></span>
                                <a href="tel:123-456-7890"
                                    style="color: inherit; text-decoration: none;">123-456-7890</a>
                            </p>
                            <p>
                                <span><b>Email:</b></span>
                                <a href="mailto:hello@domainname.com"
                                    style="color: inherit; text-decoration: none;">hello@domainname.com</a>
                            </p>
                        </div>
                    </div>
                </td>
                <td class="right-section">
                    <div style="position: relative; display: flex; flex-direction: column; align-items: center;">
                        <img src="img/formal-pic-1.png" alt="Profile-image"
                            style="width: 170px; height: 170px; object-fit: cover; border: 2px solid #000000; border-radius: 50%;">
                        <div class="qr-image-4">
                            <img src="img/QR.png" alt="Qr Image"
                                style="width: 100px; height: 100px; margin: 30px 0 0 35px; object-fit: cover;">
                        </div>
                        <h2
                            style="color: #4391CF; text-align: left; font-size: 20px; padding: 15px 0; border-bottom: 2px solid #000000;">
                            Contact</h2>
                        <ul>
                            <h4 style="margin-top: 10px;">Phone</h4>
                            <li style="font-size: 14px; font-weight: 400;">
                                <a href="tel:123-456-7890"
                                    style="color: inherit; text-decoration: none;">123-456-7890</a>
                            </li>
                            <h4 style="margin-top: 10px;">Email</h4>
                            <li style="font-size: 14px; font-weight: 400;">
                                <a href="mailto:hello@domainname.com"
                                    style="color: inherit; text-decoration: none;">hello@domainname.com</a>
                            </li>
                        </ul>
                        <h2
                            style="color: #4391CF; text-align: left; font-size: 20px; padding: 15px 0; border-bottom: 2px solid #000000;">
                            Education</h2>
                        <ul>
                            <li style="font-size: 12px; font-weight: 400;">2008</li>
                            <h4>Enter Your Degree</h4>
                            <li style="font-size: 12px; font-weight: 400;">Grade</li>
                            <li style="font-size: 12px; font-weight: 400;">University/College</li>
                        </ul>
                        <h2
                            style="color: #4391CF; text-align: left; font-size: 20px; padding: 15px 0; border-bottom: 2px solid #000000;">
                            Skills</h2>
                        <ul style="list-style: none; display: flex; flex-wrap: wrap;">
                            <li style="flex: 0 1 calc(50% - 10px); font-weight: 700;">UI/UX</li>
                            <li style="flex: 0 1 calc(50% - 10px); font-weight: 700;">User Flows</li>
                        </ul>
                        <h2
                            style="color: #4391CF; text-align: left; font-size: 20px; padding: 15px 0; border-bottom: 2px solid #000000;">
                            Languages</h2>
                        <ul style="list-style: none; display: flex; flex-wrap: wrap;">
                            <li style="flex: 0 1 calc(50% - 10px); font-weight: 700;">English</li>
                            <li style="flex: 0 1 calc(50% - 10px); font-weight: 700;">Spanish</li>
                        </ul>
                    </div>
                </td>
            </tr>
        </table>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const element = document.querySelector(".main-body-4");
            const opt = {
                margin: 0,
                filename: 'myResume.pdf',
                image: {
                    type: 'jpeg',
                    quality: 0.98
                },
                html2canvas: {
                    scale: 2
                },
                jsPDF: {
                    unit: 'in',
                    format: 'letter',
                    orientation: 'portrait'
                }
            };
            document.getElementById('download').addEventListener('click', function() {
                html2pdf().from(element).set(opt).save();
            });
        });
    </script>
</body>

</html>
