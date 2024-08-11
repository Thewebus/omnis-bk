<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="description" content="OMNIS un système de gestion scolaire qui consiste en la digitalisation des process existants dans les différents établissements aussi bien primaires, secondaires que supérieurs dans les secteurs public et privé." />
        <meta name="keywords" content="ERP éducation, éducation, logiciel de gestion d'école, école, grande école" />
        <meta name="author" content="selfbranding" />
        <link rel="icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon" />
        <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon" />
        <title>OMNIS SYSTEM</title>
        <link href="https://fonts.googleapis.com/css?family=Work+Sans:100,200,300,400,500,600,700,800,900" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet" />
        <style>
            body {
                width: 650px;
                font-family: work-Sans, sans-serif;
                background-color: #f6f7fb;
                display: block;
            }
            a {
                text-decoration: none;
            }
            span {
                font-size: 14px;
            }
            p {
                font-size: 13px;
                line-height: 1.7;
                letter-spacing: 0.7px;
                margin-top: 0;
            }
            .text-center {
                text-align: center;
            }
            h6 {
                font-size: 16px;
                margin: 0 0 18px 0;
            }
        </style>
    </head>
    <body style="margin: 30px auto;">
        <table style="width: 100%;">
            <tbody>
                <tr>
                    <td>
                        <table style="background-color: #f6f7fb; width: 100%;">
                            <tbody>
                                <tr>
                                    <td>
                                        <table style="width: 650px; margin: 0 auto; margin-bottom: 30px;">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <a href="{{ env('APP_URL') }}"><img class="img-fluid" src="{{ asset(env('LOGO_PATH')) }}" alt="" /></a>
                                                    </td>
                                                    <td style="text-align: right; color: #999;"><span>Digital Center</span></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table style="width: 650px; margin: 0 auto; background-color: #fff; border-radius: 8px;">
                            <tbody>
                                <tr>
                                    <td style="padding: 30px;">
                                        <h6 style="font-weight: 600;">Nouveau compte</h6>
                                        <p>
                                            Bonjour cher {{ $fullname }}, <br />
                                            votre compte OMNIS SYSTEM viens d'être créer, voila les accès : <br />
                                            <strong>Email</strong> : {{ $email }} <br />
                                            <strong>Mot de passe</strong> : {{ $password }} <br />
                                            Cliquez sur le bouton pour vous connecter.
                                        </p>
                                        <p style="text-align: center;">
                                            @if (str_contains(env('APP_URL'), 'ua-bouake'))
                                                <a href="https://ua-bouake.omnis-ci.com/personnel/login" style="padding: 10px; background-color: #24695c; color: #fff; display: inline-block; border-radius: 4px; font-weight: 600;">UA BOUAKE</a>
                                            @elseif(str_contains(env('APP_URL'), 'ua-bassam'))
                                                <a href="https://ua-bassam.omnis-ci.com/personnel/login" style="padding: 10px; background-color: #24695c; color: #fff; display: inline-block; border-radius: 4px; font-weight: 600;">UA BASSAM</a>
                                            @elseif(str_contains(env('APP_URL'), 'ua-sp'))
                                                <a href="https://ua-sp.omnis-ci.com/personnel/login" style="padding: 10px; background-color: #24695c; color: #fff; display: inline-block; border-radius: 4px; font-weight: 600;">UA SAN PEDRO</a>
                                            @else
                                                <a href="https://ua.omnis-ci.com/personnel/login" style="padding: 10px; background-color: #24695c; color: #fff; display: inline-block; border-radius: 4px; font-weight: 600;">UA ABIDJAN</a>
                                            @endif
                                        </p>
                                        <p>Si vous rencontrez un problème, veuillez vous adresser à l'informaticien</p>
                                        <p>Bon travail à vous</p>
                                        <p style="margin-bottom: 0;">
                                            Cordialement,<br />
                                            OMNIS SYSTEM
                                        </p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table style="width: 650px; margin: 0 auto; margin-top: 30px;">
                            <tbody>
                                <tr style="text-align: center;">
                                    <td>
                                        {{-- <p style="color: #999; margin-bottom: 0;">333 Woodland Rd. Baldwinsville, NY 13027</p>
                                        <p style="color: #999; margin-bottom: 0;">Don't Like These Emails?<a href="javascript:void(0)" style="color: #24695c;">Unsubscribe</a></p> --}}
                                        <p style="color: #999; margin-bottom: 0;">Powered By SELFBRANDING</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    </body>
</html>
