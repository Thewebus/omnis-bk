<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>PV de délibération</title>
    <style>
        body{
            font-size: 14px;
        }
        .titre{
            margin-left: 14px;
            font-size: 20px;
            font-weight: 200
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-block row">
                        @php
                            if (env('OWNER') == 'ua_abidjan') {
                                $ua = 'ABIDJAN';
                            }
                            else if (env('OWNER') == 'ua_bouake') {
                                $ua = 'BOUAKE';
                            }
                            else if (env('OWNER') == 'ua_bassam') {
                                $ua = 'GRAND BASSAM';
                            }
                            else {
                                $ua = 'SAN-PEDRO';
                            }
                        @endphp
                        <div class="col-sm-12 col-lg-12 col-xl-12">
                            @if ($anneeAcademique->id == 1)
                                <table class="table table-bordered text-center align-middle">
                                    <tr>
                                        @foreach ($entetes[0] as $entete)
                                            <td rowspan="{{ $entete['rowspan'] }}" colspan="{{ $entete['colspan'] }}">{{ $entete['nom'] }}</td>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        @foreach ($entetes[1] as $entete)
                                            <td rowspan="{{ $entete['rowspan'] }}" colspan="{{ $entete['colspan'] }}">{{ $entete['nom'] }}</td>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        @foreach ($entetes[2] as $entete)
                                            <td rowspan="{{ $entete['rowspan'] }}" colspan="{{ $entete['colspan'] }}">{{ $entete['nom'] }}</td>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        @foreach ($entete4 as $entete)
                                            <td>{{ $entete }}</td>
                                        @endforeach
                                    </tr>
                                    @foreach ($dataAllEtudiants as $dataAllEtudiant)
                                        <tr>
                                            @foreach ($dataAllEtudiant as $item)
                                                <td style="{{ $item === '-' ? "background-color: rgb(240, 239, 239)" : '' }}" class="black-background">{{ $item }}</td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </table>
                            @else
                                <table class="table table-bordered text-center align-middle">
                                    <tr>
                                        <td></td>
                                        @foreach ($entetes[0] as $entete)
                                            <td rowspan="{{ $entete['rowspan'] }}" colspan="{{ $entete['colspan'] }}"></td>
                                        @endforeach
                                    </tr>
                                    <tr style="height: 2em">
                                        <td></td>
                                        @foreach ($entetes[0] as $entete)
                                            <td height="20em" style="border: 5px solid #c7c7c7;" bg bgcolor="#808080" align="center" valign="center" rowspan="{{ $entete['rowspan'] }}" colspan="{{ $entete['colspan'] }}">
                                                UNIVERSITE DE L'ATLANTIQUE {{ $ua }} - ANNEE ACADEMIQUE : {{ $anneeAcademique->debut }} - {{ $anneeAcademique->fin }}
                                            </td>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td></td>
                                        @foreach ($entetes[0] as $entete)
                                            <td height="20em"
                                                style="border: 5px solid #222; text-align:center; vertical-align:center" 
                                                rowspan="{{ $entete['rowspan'] }}" 
                                                colspan="{{ $entete['colspan'] }}"
                                            >
                                                {{ $entete['nom'] }}
                                            </td>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td></td>
                                        @foreach ($entetes[1] as $entete)
                                            <td
                                                style=
                                                    "
                                                        border: 5px solid #222; 
                                                        text-align:center; 
                                                        vertical-align:center;
                                                        word-wrap: break-word;
                                                        @if($loop->index > 0 && $loop->index < array_key_last($entetes[1]))
                                                        background-color: #c7c7c7;
                                                        @endif
                                                    "
                                                height="23em"
                                                rowspan="{{ $entete['rowspan'] }}" 
                                                colspan="{{ $entete['colspan'] }}"
                                            >
                                                {{ $entete['nom'] }}
                                            </td>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td></td>
                                        @foreach ($entetes[2] as $entete)
                                            <td 
                                                style=
                                                    "
                                                        border: 5px solid #222; 
                                                        text-align:center; 
                                                        vertical-align:center;
                                                        word-wrap: break-word;
                                                        @if ($entete['nom'] == 'MOY.UE' || $entete['nom'] == 'RES.UE' || $entete['nom'] == 'CREDIT(S)')
                                                            background-color: #c7c7c7;
                                                        @endif
                                                    "
                                                height="23em"
                                                rowspan="{{ $entete['rowspan'] }}"
                                                colspan="{{ $entete['colspan'] }}"
                                            >
                                                {{ $entete['nom'] }}
                                            </td>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td></td>
                                        @foreach ($entetes[3] as $entete)
                                            <td
                                                height="15em"
                                                width="10em"
                                                style=
                                                    "
                                                        border: 5px solid #222; 
                                                        text-align:center; 
                                                        vertical-align:center;
                                                        @if ($entete == 'MOY.ECUE' || $loop->index == array_key_last($entetes[3]))
                                                            background-color: #c7c7c7;
                                                        @endif
                                                    "
                                            >
                                                {{ $entete }}
                                            </td>
                                        @endforeach
                                    </tr>
                                    @foreach ($dataAllEtudiants as $dataAllEtudiant)
                                        <tr style="">
                                            <td></td>
                                            @foreach ($dataAllEtudiant as $item)
                                                <td
                                                    style=
                                                        "
                                                            border: 5px solid #222;
                                                            text-align:center;
                                                            vertical-align:center;
                                                            word-wrap: break-word;
                                                            @if ($item == 'V' || $item == 'R' || $loop->index == (array_key_last($dataAllEtudiant) - 1))
                                                                background-color: #c7c7c7;
                                                            @endif
                                                        "
                                                    @if ($loop->index == 0)
                                                        width="50em"
                                                    @endif
                                                >
                                                    {{ $item }}
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </table>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>



