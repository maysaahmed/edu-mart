<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edumart</title>
</head>
<body style="margin: 0; padding: 0; font-family: 'inter', sans-serif;">

<table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background-color: #fff; padding: 50px;">
    <tr>
        <td align="center">
            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="overflow: hidden;">
                <tr>
                    <td style="text-align: center;">
                        <!-- Logo Image -->
                        <img src="logo.png" alt="Logo" width="120" style="display: block; margin: 0 auto;">

                        <h1 style="color:#344054; font-size: 24px; line-height: 31.2px; font-weight: 700;">You’re Almost There!</h1>
                        <p style="color:#344054; font-size: 22px; line-height: 28.6px; font-weight: 400; margin-bottom: 90px;">You have been added as a user to Edumart application, you can follow the registration process. </p>
                        <a href="{{$link}}" style="background: none; color: #344054; padding: 16px 51px; text-decoration: none; border: 2px solid #344054; border-radius: 4px; font-size: 20px; line-height: 26px; font-weight: 600;">Follow link</a>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center;">
                        <p style="color: #344054; font-size: 20px; line-height: 26px; font-weight: 400; margin: 45px 0 7px;">Or copy and paste the url into your browser</p>
                        <a href="{{$link}}" style="color: #004AC6; font-size: 20px; line-height: 26px; font-weight: 400;">{{$link}}</a>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center;">
                        <p style="color: #344054; font-size: 16px; line-height: 20.8px; font-weight: 400; margin-top: 90px;"></p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

</body>
</html>
