<!DOCTYPE HTML>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="x-apple-disable-message-reformatting">
    <meta name="format-detection" content="date=no">
    <meta name="format-detection" content="telephone=no">
    <style type="text/CSS"></style>
    <style @import url('https://dopplerhealth.com/fonts/BasierCircle/basiercircle-regular-webfont.woff2');></style>
    <title></title>
    <style>
        table,
        td,
        div,
        h1,
        p {
            font-family: 'Basier Circle', 'Roboto', 'Helvetica', 'Arial', sans-serif;
        }

        @media screen and (max-width: 530px) {
            .unsub {
                display: block;
                padding: 8px;
                margin-top: 14px;
                border-radius: 6px;
                /* background-color: #FFEADA; */
                text-decoration: none !important;
                font-weight: bold;
            }

            .button {
                min-height: 42px;
                line-height: 42px;
            }

            .col-lge {
                max-width: 100% !important;
            }
        }

        @media screen and (min-width: 531px) {
            .col-sml {
                max-width: 27% !important;
            }

            .col-lge {
                max-width: 73% !important;
            }
        }
    </style>
</head>

<body style="margin:0;padding:0;word-spacing:normal;">
    <div role="article" aria-roledescription="email" lang="en"
        style="text-size-adjust:100%;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;">
        <table role="presentation" style="width:100%;border:none;border-spacing:0;">
            <tr>
                <td align="center" style="padding:0;">
                    <table role="presentation"
                        style="width:94%;max-width:600px;border:none;border-spacing:0;text-align:left;font-family:'Basier Circle', 'Roboto', 'Helvetica', 'Arial', sans-serif;font-size:1em;line-height:1.37em;color:#384049;">
                        <!--      Logo headder -->
                        <tr>
                            <td style="padding:40px 30px 30px 30px;text-align:center;font-size:1.5em;font-weight:bold;">
                                <a href="{{ url('/') }}" style="text-decoration:none;">
                                    <img src="https://www.zoesomaconsultancy.com" width="100"
                                        alt="{{ config('app.name') }}"
                                        style="width:100px;max-width:80%;height:auto;border:none;text-decoration:none;color:#ffffff;">
                                </a>
                            </td>
                        </tr>
                        <!--      Intro Section -->
                        <tr>
                            <td style="padding:30px;">
                                {{-- <h6 style="margin-top:0;margin-bottom:1.38em;font-size:1.953em;line-height:1.3;font-weight:bold;letter-spacing:-0.02em;"> {{ $trip->ref_no}} Trip Approval</h6> --}}
                                <p style="margin:0;">Dear {{ $full_name }},</p>

                                <p>Your ZoeSoma Credentials are as follows </p>
                                <br/>
                                   <p>  Username: <strong>{{ $credentials['username'] }}</strong>. </p>
                                   <p>  Password: <strong>{{ $credentials['password'] }}</strong>. </p>
                                <p>We are pleased to inform you that your credentials have been successfully created. You can
                                    now log in to your account and start using our services.</p>
                                    <br>
                                <p>If you have any questions or need assistance, please do not hesitate to contact us.</p>
                                <p>To access your account, please click the button below:</p>
                                <p style="margin:0;">You can also log in using the attached button</p>

                                <p>Best regards,</p>

                                <p>ZOESOMA Support Team</p>
                                <p style="text-align: center;margin: 2.5em auto;">
                                    <a href="{{ url('https://zoesomaconsultancy.com') }}" class="btn-primary"
                                        itemprop="url"
                                        style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; color: white; text-decoration: none; line-height: 2em; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: capitalize; background-color: #D3A92A; margin: 0; border-color: #D3A92A; border-style: solid; border-width: 8px 16px;">
                                        <span style="mso-text-raise:10pt;font-weight:bold;" class="btn btn-perfrom">
                                            Login Link</span>
                                    </a>
                                </p>
                            </td>
                        </tr>

                    </table>
                </td>
            </tr>
        </table>
    </div>
</body>

</html>
