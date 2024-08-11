<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reçu Professeur</title>
    <style>
        body {
            font-size: 0.8rem
        }
        .bloc-header .annee-session .titre{
            display: inline-block;
            font-size: 1rem;
        }
        .img {
            margin-bottom: 2em;
            /* border: 1px solid #e6edef; */
            width: 30%;
            height: 11.5%;
            margin-top: -50px;
        }
        .universite-altentique {
            text-align: center;
            width: 70%;
            position: fixed;
            left: 38%;
            top: -40px
        }
        .universite-altentique-bottom {
            text-align: center;
            width: 70%;
            position: relative;
            left: 38%;
            top: -200px
        }
        .titre {
            /* display:flex; */
            width: 100%;
            vertical-align: middle;
            height: 50px;
            background-color: #1a0a8f;
            color: #fff;
            border-radius: 0.25rem;
            /* text-align: center; */
            font-size: 1rem;
            margin-top: -50px;
        }
        .titre-bottom {
            /* display:flex; */
            width: 100%;
            vertical-align: middle;
            height: 50px;
            background-color: #1a0a8f;
            color: #fff;
            border-radius: 0.25rem;
            /* text-align: center; */
            font-size: 1rem;
            margin-top: -180px;
        }
        .in-titre {
            margin-left: 10%;
        }
        .row {
            /* align-items: center; */
            vertical-align: middle;
            width: 100%;
            border-bottom: 2px solid #e6edef;
            height: 50px;
        }
        .row-max {
            display: inline-flex;
            /* vertical-align: middle; */
            width: 100%;
            border-bottom: 2px solid #e6edef;
            height: 150px;
        }
        .text {
            font-size: 1.2em;
        }
        .information {
            position: fixed;
            top: 20%;
            border: 2px solid #e6edef;
            text-align: center;
            padding: 10px 0;
        }
        .somme-versement {
            position: fixed;
            top: 21.5%;
        }
        .information-bottom {
            position: fixed;
            top: 74%;
            border: 2px solid #e6edef;
            text-align: center;
            padding: 10px 0;
        }
        .somme-versement-bottom {
            position: fixed;
            top: 76%;
        }
        .titre-bas {
            /* display:flex; */
            width: 100%;
            vertical-align: middle;
            height: 50px;
            background-color: #1a0a8f;
            color: #fff;
            border-radius: 0.25rem;
            /* text-align: center; */
            font-size: 1rem;
            /* margin-top: -50px; */
        }
        .in-titre-bas {
            margin-left: 2%;
        }
        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="bloc">
        <div class="bloc-header">
            <div class="img">
                <img src="{{ env('LOGO_BULLETIN') }}" @if(env('OWNER') == 'ua_sp') width="300" @else width="450" @endif  alt="LOGO UA">
            </div>
            <div class="universite-altentique">
                <h3>UNIVERSITE DE L'ATLANTIQUE</h3>
                <p>
                    Cocody - 2 Plateaux, derrière le Commissariat du 12ème Arrondissement <br>
                    06 BP 6631 Abidjan 06 Tel : +225 01 40 06 93 93/01 40 06 92 92 / 01 02 16 66 66 <br>
                    E mail : uatl@aviso.ci
                </p>
            </div>
        </div>
        <div class="titre">
            <span style="margin-left:30%" class="text-center">REÇU PAIEMENT PROFESSEUR</span>
        </div>
        <div class="row">
            <span class="text" style="margin-left: 5%">Date : {{ explode('-' ,$paiement->date_paiement)[2] . '/' . explode('-' ,$paiement->date_paiement)[1] . '/' . explode('-' ,$paiement->date_paiement)[0] }}</span>
            <span class="text" style="margin-left: 60%">Reçu n° : {{ $paiement->numero_recu }}</span>
        </div>
        <div class="row">
            <span class="text" style="margin-left: 5%">Reçu de {{ $paiement->professeur->fullname }}</span>
        </div>
        <div class="row">
            <span class="text" style="margin-left: 5%">Objet : {{ $paiement->objet }}</span>
        </div>
        <div class="row">
            <span class="text" style="margin-left: 5%">Montant du paiement : {{ App\Services\OtherDataService::nombreEnLettres($paiement->montant_paiement) }} FCFA</span>
        </div>
        <div class="row">
            <span class="text" style="margin-left: 80%">{{ $paiement->montant_paiement }} FCFA</span>
        </div>
        <div style="margin-left:40%">
            <h2>Mode de paiement</h2>
        </div>
        <div class="row">
            <span class="text" style="margin-left: 5%">Faculté : {{ $paiement->faculte->nom }}</span>
            <span class="text" style="margin-left: 20%">Mode de paiement : {{ strtoupper($paiement->mode_paiement) }}</span>
        </div>
        <div class="row">
            <span class="text" style="margin-left: 5%">Ville : {{ $paiement->ville }}</span>
            <span class="text" style="margin-left: 30%">Reçu par : {{ $paiement->personnel->fullname }}</span>
        </div>
        <div class="row">
            <span class="text" style="margin-left: 5%">Entité : {{ $paiement->entite }}</span>
            <span class="text" style="margin-left: 30%">Téléphone : {{ $paiement->personnel->numero }}</span>
        </div>
        <div class="row">
            <span class="text" style="margin-left: 5%">Note : {{ $paiement->note }}</span>
        </div>
    </div>  <br> <br>
    <hr> <br> <br>

    <div class="bloc">
        <div class="bloc-header">
            <div class="img">
                <img src="{{ env('LOGO_BULLETIN') }}" @if(env('OWNER') == 'ua_sp') width="300" @else width="450" @endif  alt="LOGO UA">
            </div>
            <div class="universite-altentique-bottom">
                <h3>UNIVERSITE DE L'ATLANTIQUE</h3>
                <p>
                    Cocody - 2 Plateaux, derrière le Commissariat du 12ème Arrondissement <br>
                    06 BP 6631 Abidjan 06 Tel : +225 01 40 06 93 93/01 40 06 92 92 / 01 02 16 66 66 <br>
                    E mail : uatl@aviso.ci
                </p>
            </div>
        </div>
        <div class="titre-bottom">
            <span style="margin-left:30%" class="text-center">REÇU PAIEMENT PROFESSEUR</span>
        </div>
        <div class="row">
            <span class="text" style="margin-left: 5%">Date : {{ explode('-' ,$paiement->date_paiement)[2] . '/' . explode('-' ,$paiement->date_paiement)[1] . '/' . explode('-' ,$paiement->date_paiement)[0] }}</span>
            <span class="text" style="margin-left: 60%">Reçu n° : {{ $paiement->numero_recu }}</span>
        </div>
        <div class="row">
            <span class="text" style="margin-left: 5%">Reçu de {{ $paiement->professeur->fullname }}</span>
        </div>
        <div class="row">
            <span class="text" style="margin-left: 5%">Objet : {{ $paiement->objet }}</span>
        </div>
        <div class="row">
            <span class="text" style="margin-left: 5%">Montant du paiement : {{ App\Services\OtherDataService::nombreEnLettres($paiement->montant_paiement) }} FCFA</span>
        </div>
        <div class="row">
            <span class="text" style="margin-left: 80%">{{ $paiement->montant_paiement }} FCFA</span>
        </div>
        <div style="margin-left:40%">
            <h2>Mode de paiement</h2>
        </div>
        <div class="row">
            <span class="text" style="margin-left: 5%">Faculté : {{ $paiement->faculte->nom }}</span>
            <span class="text" style="margin-left: 20%">Mode de paiement : {{ strtoupper($paiement->mode_paiement) }}</span>
        </div>
        <div class="row">
            <span class="text" style="margin-left: 5%">Ville : {{ $paiement->ville }}</span>
            <span class="text" style="margin-left: 30%">Reçu par : {{ $paiement->personnel->fullname }}</span>
        </div>
        <div class="row">
            <span class="text" style="margin-left: 5%">Entité : {{ $paiement->entite }}</span>
            <span class="text" style="margin-left: 30%">Téléphone : {{ $paiement->personnel->numero }}</span>
        </div>
        <div class="row">
            <span class="text" style="margin-left: 5%">Note : {{ $paiement->note }}</span>
        </div>
    </div>

</body>
</html>