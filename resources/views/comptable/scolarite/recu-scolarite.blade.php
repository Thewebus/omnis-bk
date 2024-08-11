<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reçu Scolarité</title>
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
            top: -150px
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
            @php
                $somme = get_class($scolarite) == "App\Models\Inscription" ? $scolarite->frais_inscription : $scolarite->versement;
                $type = get_class($scolarite) == "App\Models\Inscription" ? 'INSCRIPTION' : 'VERSEMENT';
            @endphp
        </div>
        <div class="titre">
            <span class="in-titre">N° DE CAISSE : {{ $scolarite->numero_recu }}</span>
            <span class="in-titre">{{ $scolarite->anneeAcademique->debut }} - {{ $scolarite->anneeAcademique->fin }}</span>
            <span class="in-titre">{{ strtoupper($scolarite->etudiant->statut) }}</span>  
        </div>
        <div class="row">
            <span class="text" style="margin-left: 5%">Nom & Prénoms : {{ $scolarite->etudiant->fullname }}</span>
        </div>
        <div class="row">
            <span class="text" style="margin-left: 5%">Code : {{ $scolarite->code_caisse }}</span>
            <span class="text" style="margin-left: 30%">Matricule : {{ $scolarite->etudiant->matricule_etudiant }}</span>
        </div>
        <div class="row">
            <span class="text" style="margin-left: 5%">Classe : {{ $scolarite->etudiant->classe($anneeAcademique->id)->nom ?? __('NEANT') }}</span>
        </div>
        <div class="row-max">
            <div class="somme-versement" style="font-size: 1.5rem; margin-left: 5%">{{ $type }} : {{ $somme }} FR CFA</div>
            <div style="margin-left: 55%" class="information">
                <span>INFORMATION</span> <br>
                <span>
                    UA VOUS SOUHAITE UNE BONNE ET HEUREUSE <br>
                    ANNEE UNIVERSITAIRE
                </span>
            </div>
        </div>
        <div class="row">
            <h3 style="margin-left: 5%">
                {{ App\Services\OtherDataService::nombreEnLettres($somme) }} FR CFA PAR VERSEMENT LE
                {{ explode('-', $scolarite->date_versement)[2] }} / {{ explode('-', $scolarite->date_versement)[1] }} / {{ explode('-', $scolarite->date_versement)[0] }}
                ref {{ strtoupper($scolarite->numero_bordereau) }}
            </h3>
        </div>
        <div class="titre-bas">
            <span class="in-titre-bas">TOTAL À PAYER : {{ get_class($scolarite) == 'App\Models\Inscription' ? $somme : $scolarite->montant_scolarite }} FR CFA</span>
            <span class="in-titre-bas">TOTAL PAYÉ : {{ get_class($scolarite) == 'App\Models\Inscription' ? $somme : $scolarite->payee }} FR CFA</span>
            @if (get_class($scolarite) == "App\Models\Scolarite")
                <span class="in-titre-bas">SOLDE : {{ $scolarite->reste }} FR CFA</span>  
            @endif
        </div>
        <div class="row">
            <span class="text">Date prochaine relance : </span>
            <span class="text" style="margin-left: 15%">Montant prochaine relance : </span>
            <span style="margin-left: 15%">Le </span>
        </div>
        <div class="row-max">
            <div class="text-center" style="margin-left: 65%"><strong>Visa Caisse</strong>  <br><br><br> <h5>{{ Auth::user()->fullname }}</h5></div>
        </div>
    </div> <br> <br>
    <hr> <br><br>
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
        <div class="titre">
            <span class="in-titre">N° DE CAISSE : {{ $scolarite->numero_recu }}</span>
            <span class="in-titre">{{ $scolarite->anneeAcademique->debut }} - {{ $scolarite->anneeAcademique->fin }}</span>
            <span class="in-titre">{{ strtoupper($scolarite->etudiant->statut) }}</span>  
        </div>
        <div class="row">
            <span class="text" style="margin-left: 5%">Nom & Prénoms : {{ $scolarite->etudiant->fullname }}</span>
        </div>
        <div class="row">
            <span class="text" style="margin-left: 5%">Code : {{ $scolarite->code_caisse }}</span>
            <span class="text" style="margin-left: 30%">Matricule : {{ $scolarite->etudiant->matricule_etudiant }}</span>
        </div>
        <div class="row">
            <span class="text" style="margin-left: 5%">Classe : {{ $scolarite->etudiant->classe($anneeAcademique->id)->nom ?? __('NEANT') }}</span>
        </div>
        <div class="row-max">
            <div class="somme-versement-bottom" style="font-size: 1.5rem; margin-left: 5%">{{ $type }} : {{ $somme }} FR CFA</div>
            <div style="margin-left: 55%" class="information-bottom">
                <span>INFORMATION</span> <br>
                <span>
                    UA VOUS SOUHAITE UNE BONNE ET HEUREUSE <br>
                    ANNEE UNIVERSITAIRE
                </span>
            </div>
        </div>
        <div class="row">
            <h3 style="margin-left: 5%">
                {{ App\Services\OtherDataService::nombreEnLettres($somme) }} FR CFA PAR VERSEMENT LE
                {{ explode('-', $scolarite->date_versement)[2] }} / {{ explode('-', $scolarite->date_versement)[1] }} / {{ explode('-', $scolarite->date_versement)[0] }}
                ref {{ strtoupper($scolarite->numero_bordereau) }}
            </h3>
        </div>
        <div class="titre-bas">
            <span class="in-titre-bas">TOTAL À PAYER : {{ get_class($scolarite) == 'App\Models\Inscription' ? $somme : $scolarite->montant_scolarite }} FR CFA</span>
            <span class="in-titre-bas">TOTAL PAYÉ : {{ get_class($scolarite) == 'App\Models\Inscription' ? $somme : $scolarite->payee }} FR CFA</span>
            @if (get_class($scolarite) == "App\Models\Scolarite")
                <span class="in-titre-bas">SOLDE : {{ $scolarite->reste }} FR CFA</span>  
            @endif  
        </div>
        <div class="row">
            <span class="text">Date prochaine relance : </span>
            <span class="text" style="margin-left: 15%">Montant prochaine relance : </span>
            <span style="margin-left: 15%">Le </span>
        </div>
        <div class="row-max">
            <div class="text-center" style="margin-left: 65%"><strong>Visa Caisse</strong>  <br><br><br> <h5>{{ Auth::user()->fullname }}</h5></div>
        </div>
    </div>
</body>
</html>