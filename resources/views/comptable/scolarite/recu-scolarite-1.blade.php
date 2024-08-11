<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Reçu Scolarité</title>
</head>
<body>
    <div class="container border mt-3 mb-5">
        <div class="mt-3">
            <div class="row">
                <div class="col-4">
                    <img src="{{ asset('assets/images/logo_ua.png') }}" alt="">
                </div>
                <div class="col-8">
                    <h6>UNIVERSITE DE L'ATLANTIQUE</h6>
                    <p>
                        Cocody - 2 Plateaux, derrière le Commissariat du 12ème Arrondissement <br>
                        06 BP 6631 Abidjan 06 Tel : +225 01 40 06 93 93/01 40 06 92 92 / 01 02 16 66 66 <br>
                        E mail : uatl@aviso.ci
                    </p>
                </div>
            </div>
        </div>
    
        <div class="grid-wrrapper mt-2">
            <div class="row mt-3 rounded p-3" style="height: 50px; background-color: #1a0a8f; color:#fff">
                <div class="col-4"><h5>N° DE CAISSE : {{ $scolarite->numero_recu }}</h5></div>
                <div class="col-4"><h5>{{ $scolarite->anneeAcademique->debut }} - {{ $scolarite->anneeAcademique->fin }}</h5></div>
                <div class="col-4"><h5>{{ strtoupper($scolarite->etudiant->statut) }}</h5>  </div>
            </div>
            <div class="row p-3 border-bottom" style="height: 50px;">
                <div class="col-12"><h5>Nom & Prénoms : {{ $scolarite->etudiant->fullname }}</h5></div>
                {{-- <div class="col-4"></div>
                <div class="col-4"> </div>
                <div class="col-4"> </div> --}}
            </div>
            <div class="row p-3 border-bottom" style="height: 50px;">
                <div class="col-6"><h5>Code : {{ $scolarite->code_caisse }}</h5></div>
                <div class="col-6"><h5>Matricule : {{ $scolarite->etudiant->matricule_etudiant }}</h5></div>
            </div>
            <div class="row p-3 border-bottom" style="height: 50px;">
                <div class="col-4"><h5>Classe : </h5></div>
                <div class="col-8"><h5>{{ $scolarite->etudiant->classe($anneeAcademique->id)->nom ?? __('NEANT') }}</h5></div>
            </div>
            <div class="row p-3 border-bottom" style="height: 130px;">
                <div class="col-6 text-center pt-4"><h1>Versement : {{ $scolarite->versement }} FR CFA</h1></div>
                <div class="col-6 text-center rounded rounded-5 border border-2" style="height: 100px;">
                    <h6>INFORMATION</h6>
                    <p>
                        UA VOUS SOUHAITE UNE BONNE ET HEUREUSE <br>
                        ANNEE UNIVERSITAIRE
                    </p>
                </div>
            </div>
            <div class="row p-3 border-bottom" style="height: 50px;">
                <div class="col-12 text-center">
                    <h5>
                        "SOMME EN LETTRE" FR CFA PAR VERSEMENT 
                        {{ explode('-', $scolarite->date_versement)[2] }} / {{ explode('-', $scolarite->date_versement)[1] }} / {{ explode('-', $scolarite->date_versement)[0] }}
                        ref {{ strtoupper($scolarite->numero_bordereau) }}
                    </h5>
                </div>
            </div>
            <div class="row rounded p-3" style="height: 50px; background-color: #1a0a8f; color:#fff">
                <div class="col-4"><h5>TOTAL À PAYER : {{ $scolarite->montant_scolarite }} FR CFA</h5></div>
                <div class="col-4"><h5>TOTAL PAYÉ : {{ $scolarite->payee }} FR CFA</h5></div>
                <div class="col-4"><h5>SOLDE : {{ $scolarite->reste }} FR CFA</h5></div>
            </div>
            <div class="row rounded p-3 border-bottom" style="height: 50px;">
                <div class="col-4">Date prochaine relance : </div>
                <div class="col-4">Montant prochaine relance: </div>
                <div class="col-4">Le </div>
            </div>
            <div class="row rounded">
                <div class="col-4"></div>
                <div class="col-4"></div>
                <div class="col-4 text-center"><strong>Visa Caisse</strong>  <br><br><br><br> <h5>{{ Auth::user()->fullname }}</h5></div>
            </div>
        </div>
    </div>
</body>
</html>