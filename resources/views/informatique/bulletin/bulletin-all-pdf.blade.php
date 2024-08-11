<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bulletins étudiants</title>
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
        .ministere {
            text-align: center;
            width: 60%;
            position: fixed;
            left: 45%;
            top: -40px
        }
        .annee-session {
            margin-top: -65px;
        }
        .annee-session > .numero-semestre {
            margin-left: 40%;
        }
        .faculte {
            width: 100%;
            vertical-align: middle;
            height: 60px;
            background-color: #BABABA /*#1a0a8f */;
            color: #222;
            /* border-radius: 0.25rem; */
            text-align: center;
            font-size: 1rem;
            margin-top: -50px;
        }
        .releve-note {
            width: 100%;
            vertical-align: middle;
            height: 60px;
            background-color: #1a0a8f;
            color: #fff;
            /* border-radius: 0.25rem; */
            text-align: center;
            font-size: 1rem;
            margin-top: -76px;
        }
        .information {
            margin-top: -40px;
        }
        .id-bulletin {
            font-size: 1.1rem;
        }
        .libelle {
            margin-left: 25%;
            font-size: 1.2rem;
            text-decoration: underline;
        }
        .information-etudiant {
            margin-top: 10px;
            font-size: 0.8rem

        }
        table {
            width: 100%;
            margin-top: 20px;
            margin-bottom: 0px;
            border: 1px solid #e6edef;
            border-radius: 0.5rem;
            /* vertical-align: top; */
            font-size: 0.9rem;
        }
        /* th { background-color : #557CBA; }*/
		td {
            background-color : #fff;
        } 
		tr,td {
            /* padding:0.2em; */
            border-bottom: 1px solid #222;
            /* text-align: center; */
        }
        .text-center {
            text-align: center;
        }
        .mt {
            /* position: fixed; */
            /* top: 30px; */
            /* margin-top: -120px; */
        }
        .mb {
            margin-bottom: 100px;
        }
        .pied-page {
            font-size: 0.8em;
            width: 100%;
            position: fixed;
            bottom: 0;
        }
        .avis-important {
            background-color: rgb(186, 186, 186);
            width: 100%;
            height: 1.5em;
            padding: 0.1em 0 0.1em 1em;
        }
        .ua {
            width: 100%;
            text-align: center;
        }
        .coordonne-ua {
            width: 100%;
            text-align: center;
        }
        .small {
            font-size: 0.7.5rem
        }
        hr {
            border: 5px solid #1a0a8f
        }

        .underline {
            text-decoration: underline;
        }
        .ue-text {
            font-size: 0.8rem
        }
        .background-tab {
            background-color: #bababa;
            font-size: 0.7rem;
        }
        .text-red {
            color: rgb(240, 42, 42)
        }
    </style>
</head>
<body>
    @inject('bulletinService', 'App\Services\BulletinService')

    @foreach ($bulletinDatas as $key => $bulletinData)
        <div class="bloc-header">
            <div class="img">
                <img src="{{ env('LOGO_BULLETIN') }}" @if(env('OWNER') == 'ua_sp') width="300" @else width="450" @endif  alt="LOGO UA">
                <div> ANNEE ACADEMIQUE : {{ $bulletinData['anneeAcademique'] }}</div>
            </div>
            <div class="ministere">
                <span>REPUBLIQUE DE CÔTE D'IVOIRE <br> -------------------------- <br></span>
                <span>UNION - DISCIPLINE - TRAVAIL <br> ---------------------- <br></span>
                <span>MINISTERE DE L'ENSEIGNEMENT SUPÉRIEUR <br> ET DE LA RECHERCHE SCIENTIFIQUE</span>
            </div>
        </div>
        <div class="faculte">
            <h3>{{ $bulletinData['faculte'] }}</h3> 
        </div>
        <div class="releve-note">
            <h3>RELEVE DE NOTES</h3> 
        </div>
        <div class="information">
            <div class="information-etudiant">
                <span style="float: right; font-size:1rem"> <strong>Session {{ $bulletinData['session'] == 1 ? '1' : '2' }} / Semestre {{ $bulletinData['semestre'] == 1 ? '1' : '2' }}</strong></span>
                ETUDIANT(E) : <b> {{ $bulletinData['fullname'] }}</b> <br>
                NÉ(E) LE: <b> {{ $bulletinData['dateNais'] }}</b> A: <strong>{{ $bulletinData['lieuNais'] }}</strong> <br>
                CLASSE : <b>{{ $bulletinData['classe'] }}</b>
                <span style="float: right; font-size:1rem"><strong>Matricule : {{ $bulletinData['matricule_etudiant'] }}</strong></span>
            </div>
        </div>
        <table class="ue-text">
            @foreach ($bulletinData['unite_enseignements'] as $uniteEnseignements)
                @if (count($uniteEnseignements) > 1)
                    @foreach ($uniteEnseignements as $uniteEnseignement)
                        @php
                            $rowspan = count($uniteEnseignements) - 1;
                            $credEu = array_sum(array_column($uniteEnseignements, 'credit'));
                            $moyEu = array_sum(array_column($uniteEnseignements, 'credit_moyenne')) / $credEu;
                            $moyEu = $bulletinService->nombreFormatDeuxDecimal($moyEu);
                            $resultEu = $bulletinService->mention($moyEu);
                            $ueNom = str_replace(' ', '_', $uniteEnseignements['nom'])
                        @endphp
                        @if ($loop->index == 0)
                            <tr class="text-center align-middle">
                                <td class="background-tab">UE</td>
                                <td style="width:30%" class="background-tab">{{ $uniteEnseignement }}</td>
                                <td class="background-tab">MOY.ECUE</td>
                                <td class="background-tab">MOY.UE</td>
                                <td class="background-tab">CRED.UE</td>
                                <td class="background-tab">RESULT.UE</td>
                                <td class="background-tab">MENTION</td>
                                <td class="background-tab">SESSION</td>
                            </tr>
                        @elseif ($loop->index == 1)
                            <tr class="text-center align-middle">
                                <td rowspan="{{ $rowspan }}">ECUE</td>
                                <td>{{ $uniteEnseignement['matiere'] }}</td>
                                <td>{{ $uniteEnseignement['moyenne'] }}</td>
                                <td rowspan="{{ $rowspan }}" style="background-color: rgb(186, 186, 186);">{{ $moyEu }}</td>
                                <td rowspan="{{ $rowspan }}">{{ $credEu }}</td>
                                <td rowspan="{{ $rowspan }}" class="small" style="background-color: rgb(186, 186, 186);">{{ $moyEu >= 10 ? 'VALIDEE' : 'NON VALIDEE' }}</td>
                                <td rowspan="{{ $rowspan }}" class="small">{{ $resultEu }}</td>
                                <td rowspan="{{ $rowspan }}" style="width:8%" class="small">{{ $uesAnnee[$ueNom][0] }} {{ $uesAnnee[$ueNom][1] }}</td>
                            </tr>
                        @else
                            <tr class="text-center align-middle">
                                <td>{{ $uniteEnseignement['matiere'] }}</td>
                                <td>{{ $uniteEnseignement['moyenne'] }}</td>
                            </tr>
                        @endif
                    @endforeach
                @endif
            @endforeach

            <tr>
                <td colspan="8"></td>
            </tr>
            <tr class="bg-grey {{ $bulletinData['semestre'] == 1 ? 'text-center' : '' }} align-middle">
                <td colspan="2">Crédit(s) Validé(s) : <span class="text-red">{{ $bulletinData['total_credit_validee'] }} / {{ $bulletinData['total_credit'] }}</span></td>
                <td colspan="2">Moy.Semestre : <span class="text-red">{{ $bulletinService->nombreFormatDeuxDecimal($bulletinData['moyenne_finale']) }}</span></td>
                <td colspan="4">Résultats : <span class="text-red">{{ $bulletinData['resultat_final'] }}</span> </td>
            </tr>
            @if ($bulletinData['semestre'] == 2)
                @php
                    $total_credits_valides = $bulletinData['total_credit_validee'] + $bulletinData['credits_validee_semestre_1'];
                    $total_credits = $bulletinData['total_credit'] + $bulletinData['total_credits_semestre_1'];
                    $decision_jury = $total_credits_valides == $total_credits ? 'Admis(e)' : 'Ajourné(e)';
                    $moyenne_annuelle = ($bulletinData['moyenne_finale'] + $bulletinData['moyenne_semestre_1']) / 2;
                @endphp
                <tr class="bg-grey align-middle">
                    <td colspan="2">Crédit(s) Validé(s) Semestre 1 : <span class="text-red">{{ $bulletinData['credits_validee_semestre_1'] }} / {{ $bulletinData['total_credits_semestre_1'] }}</span></td>
                    <td colspan="2">Moy.Semestre 1 : <span class="text-red">{{ $bulletinService->nombreFormatDeuxDecimal($bulletinData['moyenne_semestre_1']) }}</span></td>
                    <td colspan="4">Résultat semestre 1 : <span class="text-red">{{ $bulletinData['resultat_semestre_1'] }}</span> </td>
                </tr>
                <tr class="bg-grey align-middle">
                    <td colspan="2">Crédit(s) Validé(s) : <span class="text-red">{{ $total_credits_valides }} / {{ $total_credits }}</span></td>
                    <td colspan="2">Moy.Semestre : <span class="text-red">{{ $bulletinService->nombreFormatDeuxDecimal($moyenne_annuelle) }}</span></td>
                    <td colspan="4">Résultats : <span class="text-red">{{ $decision_jury }}</span> </td>
                </tr>
            @endif
            <tr>
                <td colspan="8" style="padding-bottom: 3em">
                    <p>
                        Fait à @if(env('OWNER') == 'ua_abidjan') Abidjan,
                            @elseif(env('OWNER') == 'ua_bouake') Bouaké,
                            @elseif(env('OWNER') == 'ua_bassam') Grand-Bassam,
                            @elseif(env('OWNER') == 'ua_sp') San-Pedro,
                            @endif le {{ date('d/m/Y') }} <br>
                    </p>
                    <p style="margin-left:30rem">
                        {{ $signataire->fonction ?? 'Le Président du Conseil Scientifique' }}
                    </p>
                    <p style="margin-left: 30rem; margin-top:4rem">
                        {{ $signataire->fullname ?? 'Prof. HAUHOUOT Asseypo Antoine' }}
                    </p>
                </td>
            </tr>
        </table>
        <div class="pied-page">
            <div class="avis-important">
                <b>Avis important: </b> Il ne peut être délivré qu'un seul exemplaire du présent relevé. Aucun autre duplicata ne sera fourni
            </div>
            <hr>
            @if (env('OWNER') == 'ua_bouake')
                <div class="coordonne-ua">
                    Administration, Faculté et instituts : <br>
                    Bouaké - Rue Centre Commerce le Capitol  <br>
                    Tel : 2731658301 / 0749159961 / 0779816010 / 0709126473 <br>
                    <span style="text-decoration: underline"> Arreté d'ouverture n°06157 du 06 Avril 2009</span>  <br>
                    E-mail : uatlantique.bouake@groupeatlantique.com / web : uatlantique.org
                </div>
            @elseif(env('OWNER') == 'ua_bassam')
                <div class="coordonne-ua">
                    Administration, Faculté et instituts : <br>
                    Grand-Bassam - Mockey ville, Carr Château  <br>
                    Tel : 0758399851 / 0171083223<br>
                    <span style="text-decoration: underline"> Arreté d'ouverture n°650 du 18 Juin 2019</span>  <br>
                    E-mail : infos@groupeatlantique.com
                </div>
            @elseif(env('OWNER') == 'ua_sp')
                <div class="coordonne-ua">
                    Administration, Faculté et instituts : <br>
                    San Pedro - Quartier Balmer  <br>
                    Tel : 0585795454 / 0703739898<br>
                    <span style="text-decoration: underline"> Arreté d'ouverture n°608 du 18 Juin 2019</span>  <br>
                    E-mail : infos@groupeatlantique.com
                </div>
            @else
                <div class="ua">UNIVERSITÉ DE L'ATLANTIQUE</div>
                <div class="coordonne-ua">
                    Cocody - 2 plateaux, Saint Jacques, derrière l'ENA, Rue J17 <br>
                    06 BP 6631 ABIDJAN 06 - Tel : +225 01 02 02 46 46 / 01 42 33 85 85 <br>
                    E-mail : scolarite@groupeatlantique.com / Site Web : uatlantique.org <br>
                    <span> Arreté d'ouverture n°0210 du 11 Sept. 2000</span>
                </div>
            @endif
        </div>

        <div class="pagebreak"></div>
    @endforeach
</body>
</html>
