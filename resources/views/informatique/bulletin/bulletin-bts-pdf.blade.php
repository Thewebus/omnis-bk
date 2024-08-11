<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bulletin étudiant</title>
    <style>
        body {
            font-size: 0.8rem
        }
        .bloc-header .annee-session .titre{
            display: inline-block;
            font-size: 1rem;
        }
        .img {
            margin-bottom: 1em;
            /* border: 1px solid #e6edef; */
            width: 30%;
            height: 11.5%;
            margin-top: -60px;
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
        .annee-academique, .numero-semestre {
            font-size: 1.1rem;
        }
        .faculte {
            width: 100%;
            vertical-align: middle;
            height: 60px;
            background-color: #1a0a8f;
            color: #fff;
            border-radius: 0.25rem;
            text-align: center;
            font-size: 1rem;
            margin-top: -60px;
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
            margin-top: 30px;
            font-size: 0.8rem

        }
        table {
            width: 100%;
            margin-top: 10px;
            margin-bottom: 0px;
            border: 1px solid #222;
            border-radius: 0.5rem;
            /* vertical-align: top; */
            font-size: 0.9rem;
        }
        /* th { background-color : #557CBA; }*/
		td {
            background-color : #fff;
        } 
		th,td {
            /* padding:0.5em; */
            border-bottom: 1px solid #222;
            border-right: 1px solid #222;
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
            bottom: -3%;
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
            background-color: rgb(186, 186, 186)
        }
    </style>
</head>
<body>
    @if ($anneeAcademique->id == 1)
        <div class="bloc-header">
            <div class="img">
                <img src="{{ env('LOGO_BULLETIN') }}" @if(env('OWNER') == 'ua_sp') width="300" @else width="450" @endif  alt="LOGO UA">
            </div>
            <div class="ministere">
                <span>REPUBLIQUE DE CÔTE D'IVOIRE <br> -------------------------- <br></span>
                <span>UNION - DISCIPLINE - TRAVAIL <br> ---------------------- <br></span>
                <span>MINISTERE DE L'ENSEIGNEMENT SUPÉRIEUR <br> ET DE LA RECHERCHE SCIENTIFIQUE</span>
            </div>
        </div>
        <div class="annee-session" style="margin: 1px 0;">
            <span class="annee-academique">Année Académique {{ $bulletinData['anneeAcademique'] }}</span>
            <span class="numero-semestre">{{ $bulletinData['semestre'] == 1 ? '1er' : '2ème' }} Semestre </span>
        </div>
        <div class="faculte">
            <h3>{{ $bulletinData['faculte'] }}</h3> 
        </div>
        <div class="information">
            <div class="titre">
                <span class="id-bulletin">{{ $bulletinData['identifiant_bulletin'] }}</span>
                <span class="libelle">RELEVE DE NOTES BTS</span>
                <div class="information-etudiant">
                    ETUDIANT(E) : <b>{{ $bulletinData['fullname'] }}</b> <br>
                    NÉ(E) LE: <b>{{ $bulletinData['dateNais'] }}</b> A: <strong>{{ $bulletinData['lieuNais'] }}</strong> <br>
                    MATRICULE : <b>{{ $bulletinData['matricule_etudiant'] }} </b> <br>
                    CLASSE : <b>{{ $bulletinData['classe'] }}</b>
                </div>
            </div>
        </div>
        <table class="ue-text">
            <thead>
                <tr>
                    <th>Unités d'enseignement</th>
                    <th>Moy</th>
                    <th>Coef</th>
                    <th>Moy*Co</th>
                    <th>Rang</th>
                    <th>Mention</th>
                    <th>Enseignant</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($bulletinData['unite_enseignements'] as $uniteEnseignements)
                    @foreach ($uniteEnseignements as $uniteEnseignement)
                        @if ($loop->index == 0)
                            <tr>
                                <td style="background-color: rgb(186, 186, 186)" colspan="7">{{ $uniteEnseignement }}</td>
                            </tr>
                        @else
                            <tr>    
                                <td>{{ $uniteEnseignement['matiere'] }}</td>
                                <td class="text-center">{{ $uniteEnseignement['moyenne'] }}</td>
                                <td class="text-center">{{ $uniteEnseignement['coefficient'] }}</td>
                                <td class="text-center">{{ floatval($uniteEnseignement['moyenne']) *  $uniteEnseignement['coefficient'] }}</td>
                                @php
                                    $moyenneMatiere = $uniteEnseignement['credit_moyenne'] / $uniteEnseignement['coefficient'];
                                    $rangMatiere = $dataArray[str_replace(' ', '_', $uniteEnseignement['matiere'])] ;
                                @endphp
                                <td class="text-center">{{ $rangMatiere == 1 ? $rangMatiere . 'er' : $rangMatiere . 'e' }}</td>
                                <td class="text-center">{{ $uniteEnseignement['mention'] }}</td>
                                <td class="text-center">{{ $uniteEnseignement['nom_professeur'] }}</td>
                            </tr>
                        @endif
                    @endforeach
                @endforeach
                <tr>
                    <td colspan="7" style="height: 25px"></td>
                </tr>
                @if ($bulletinData['semestre'] == 1)
                    <tr>
                        <td class="text-center" colspan="3">
                            <span><u>SEMESTRE 1</u></span>
                            <div>
                                Moy. : {{ number_format($bulletinData['moyenne_finale'], 2) }} <br>
                                Rang : {{ $dataArray['rang'] == 1 ? $dataArray['rang'] . 'er' : $dataArray['rang'] . 'e' }} <br>
                                Absence : 00 <br>
                                Mention : {{ $bulletinData['mention_finale'] }}
                            </div>
                        </td>
                        <td class="text-center" colspan="4">
                            <span><u>BILAN DE CLASSE</u></span>
                            <div>
                                Moy de la classe : {{ $dataArray['moyClass'] }} <br>
                                Moy. du 1er : {{ $dataArray['moyMax'] }} <br>
                                Moy du dernier : {{ $dataArray['moyMin'] }}
                            </div>
                        </td>
                    </tr>
                @else
                    <tr>
                        <td style="background-color: rgb(186, 186, 186);" colspan="2"><div>PRIEMIER SEMESTRE </div></td>
                        <td style="background-color: rgb(186, 186, 186);" colspan="3"><div>DEUXIEME SEMESTRE </div></td>
                        <td style="background-color: rgb(186, 186, 186);" colspan="2"><div>BILAN ANNUEL </div></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            Moyenne : {{ number_format($bulletinData['moyenne_semestre_1'], 2) }} <br>
                            Rang : {{ $dataArray['rangSemestre1'] == 1 ? $dataArray['rangSemestre1'] . 'er' : $dataArray['rangSemestre1'] . 'e' }}
                        </td>
                        <td colspan="3">
                            Moyenne : {{ number_format($bulletinData['moyenne_finale'], 2) }} <br>
                            Absence : 00
                        </td>
                        <td colspan="2">
                            Moy. Ann. : {{ $dataArray['moyAnnuelle'] }}  <br>
                            Moyenne de la classe : {{ $dataArray['moyAnnuelleClasse'] }}  <br>
                            Moyenne du 1er : {{ $dataArray['moyAnnuelle1er'] }}  <br>
                            Moyenne du dernier : {{ $dataArray['moyAnnuelleDer'] }} 
                        </td>
                    </tr>
                @endif
                <tr>
                    @if ($bulletinData['semestre'] == 2)
                        <td colspan="2"> <strong><u>Décision de fin d'année</u></strong> </td>
                    @endif
                    <td class="text-center" colspan="{{ $bulletinData['semestre'] == 1 ? '7' : '5' }}">
                        <div class="mt">
                            <div style="margin-left:60%; margin-top:1%">
                                Fait à @if(env('OWNER') == 'ua_abidjan') Abidjan,
                                @elseif(env('OWNER') == 'ua_bouake') Bouaké,
                                @elseif(env('OWNER') == 'ua_bassam') Grand-Bassam,
                                @elseif(env('OWNER') == 'ua_sp') San-Pedro,
                                @endif le {{ date('d/m/Y') }} <br><br>

                                <strong> {{ $signataire->fonction ?? 'LE DOYEN DES FACULTÉS' }}</strong> <br><br><br><br>
                                <strong><span class="small">{{ $signataire->fullname ?? 'DR. SYLLA MAMDOU' }}</span> </strong>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
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
                    06 BP 66 31 ABIDJAN 06 - Tel : (+225) 01 40 06 93 93 / 01 40 06 92 92 <br>
                    <span style="text-decoration: underline"> Arreté d'ouverture n°0210 du 11 Sept. 2000</span>  <br>
                    E-mail : scolarite@groupeatlantique.com / Site Web : uatlantique.org <br>
                </div>
            @endif
        </div>
    @else
        <div class="bloc-header">
            <div style="margin-left: 35%; margin-top:-5%" class="img">
                <img src="{{ env('LOGO_BULLETIN') }}" @if(env('OWNER') == 'ua_sp') width="300" @else width="450" @endif  alt="LOGO UA">
            </div>
        </div>
        <div style="background-color: #b3b3b3; text-align:center" class="annee-session">
            <h2>INSTITUT UNIVERSITAIRE DES HAUTES ETUDES PROFESSIONNELLES</h2>
        </div>
        <div style="width: 100%; font-size:1.2em; margin-top:-2%">
            <div style="background-color: #e2e2e7; text-align:center; width:70%; padding:5px 0; margin-left:10%">
                <span>BREVET DE TECHNICIEN SUPERIEUR </span>
            </div>
            <div style="position:fixed; right:0%; top:13.5%">{{ $bulletinData['anneeAcademique'] }}</div>
        </div>
        <div style="font-size:1.2em; margin-top:5px">
            <div style="margin-left:35%">
                <span>BULLETIN DE NOTES </span>
            </div>
            <div style="position:fixed; right:0%; top:11%">Semestre {{ $bulletinData['semestre'] }}</div>
        </div>
        <table class="ue-text">
            <tr>
                <td colspan="7">Nom et Prénom(s) : {{ $bulletinData['fullname'] }}</td>
            </tr>
            @php
                $effectifClasse = $dataArray['effectif_classe']
            @endphp
            <tr>
                <td colspan="4">
                    Né(e) le : {{ $bulletinData['dateNais'] }} à {{ $bulletinData['lieuNais'] }}  <br>
                    Sexe : {{ $bulletinData['sexe'] }}  <br>
                    Statut :{{ $bulletinData['statut'] }}  <br>
                    Matricule : {{ $bulletinData['matricule_etudiant'] }} <br>
                    Redoublant(e) : NONE <br>
                </td>
                <td colspan="3">
                    <div style="margin-bottom:5%">
                        Classe : {{ $bulletinData['faculte'] }}
                    </div>
                    Effectif : {{ $effectifClasse }}
                </td>
            </tr>
            <tr class="text-center" style="background-color: #b3b3b3">
                <td>Matières</td>
                <td>Moy./20</td>
                <td>Coef</td>
                <td>Moy Coef.</td>
                <td>Rang</td>
                <td>Professeurs</td>
                <td>Appréciations</td>
            </tr>
            @foreach ($bulletinData['unite_enseignements'] as $uniteEnseignements)
                @foreach ($uniteEnseignements as $uniteEnseignement)
                    @if ($loop->index == 0)
                        <tr>
                            <td colspan="7"><strong>{{ $uniteEnseignement }}</strong> </td>
                        </tr> 
                    @else
                        <tr>
                            <td>{{ $uniteEnseignement['matiere'] }}</td>
                            <td class="text-center">{{ $uniteEnseignement['moyenne'] }}</td>
                            <td class="text-center">{{ $uniteEnseignement['coefficient'] }}</td>
                            <td class="text-center">{{ $uniteEnseignement['credit_moyenne'] }}</td>
                            @php
                                $moyenneMatiere = $uniteEnseignement['credit_moyenne'] / $uniteEnseignement['coefficient'];
                                $rangMatiere = $dataArray[str_replace(' ', '_', $uniteEnseignement['matiere'])] ;
                            @endphp
                            <td class="text-center">{{ $rangMatiere == 1 ? $rangMatiere . 'er' : $rangMatiere . 'e' }}</td>
                            <td class="text-center">{{ $uniteEnseignement['nom_professeur'] }}</td>
                            <td class="text-center">{{ $uniteEnseignement['mention'] }}</td>
                        </tr>
                    @endif
                @endforeach
                <tr>
                    @php
                        $moyenneUe = array_sum(array_column($uniteEnseignements, 'credit_moyenne')) / array_sum(array_column($uniteEnseignements, 'coefficient'));
                    @endphp
                    <td colspan="7"><span>BILAN {{ $uniteEnseignements['nom'] }} : TOTAL {{ array_sum(array_column($uniteEnseignements, 'credit_moyenne')) }} / {{ array_sum(array_column($uniteEnseignements, 'coefficient')) * 20 }} - Moyenne : {{ number_format($moyenneUe, 2) }} / 20</span> </td>
                </tr>
            @endforeach

            <tr><td colspan="7"></td></tr>
            <tr><td colspan="7"></td></tr>
            <tr>
                <td colspan="4"> {{ $bulletinData['semestre'] == 1 ? 'TOTAL' : ''}}</td>
                <td colspan="3"></td>
            </tr>
            @php
                $moyMax = $dataArray['moyMax'];
                $moyMin = $dataArray['moyMin'];
                $moyClass = $dataArray['moyClass'];
                $rang = $dataArray['rang'];
            @endphp
            @if ($bulletinData['semestre'] == 2)
                <tr>
                    @php
                        $rangSemestre1 = $dataArray['rangSemestre1'];
                    @endphp
                    <td colspan="4"><strong>Moyenne du 1er  SEMESTRE : {{ number_format($bulletinData['moyenne_semestre_1'], 2) }}</strong> </td>
                    <td colspan="3"><strong>Rang : {{ $rangSemestre1 == 1 ? $rangSemestre1 . 'er' : $rangSemestre1 . 'e' }} sur  {{ $effectifClasse }}</strong> </td>
                    {{-- <td colspan="3"><strong>Rang : {{ $rang == 1 ? $rang . 'er' : $rang . 'e' }} sur  {{ $effectifClasse }}</strong> </td> --}}
                </tr>
            @else
                <tr>
                    <td colspan="4"><strong>Moyenne du 1er  SEMESTRE : {{ number_format($bulletinData['moyenne_finale'], 2) }}</strong> </td>
                    <td colspan="3"><strong>Rang : {{ $rang == 1 ? $rang . 'er' : $rang . 'e' }} sur  {{ $effectifClasse }}</strong> </td>
                </tr>
            @endif
            @if ($bulletinData['semestre'] == 2)
                <tr>
                    <td colspan="4"><strong>Moyenne du 2er  SEMESTRE : {{ number_format($bulletinData['moyenne_finale'], 2) }}</strong> </td>
                    <td colspan="3"><strong>Rang : {{ $rang == 1 ? $rang . 'er' : $rang . 'e' }} sur  {{ $effectifClasse }}</strong> </td>
                </tr>
            @endif
            <tr>
                <td colspan="4">
                    Pus forte moyenne :      <strong>{{ number_format($moyMax, 2) }}</strong> <br>
                    Pus faible  moyenne :    <strong>{{ number_format($moyMin, 2) }}</strong> <br>
                    Moyenne de la classe: <strong>{{ number_format($moyClass, 2) }}</strong> <br>
                </td>
                <td colspan="3">
                    Total des heures d’absence      : 00
                </td>
            </tr>
            <tr class="text-center">
                @php
                    $moyAnnuelle = number_format($bulletinData['moyenne_annelle'], 2);
                    $rangAnnuel = $dataArray['rangAnnuel'];
                @endphp
                <td colspan="4"><strong>{{ $bulletinData['semestre'] == 2 ? 'BILAN ANNUEL : Moy .An : ' . $moyAnnuelle . ' / Rang : ' . $rangAnnuel . 'e' : 'MENTION' }}</strong> </td>
                <td colspan="3" rowspan="4">
                    <div><strong><u>{{ $signataire->fonction ?? 'Le  Président du Conseil Scientifique' }}</u></strong>  </div>
                    <div style="margin-top: 5em"><strong>{{ $signataire->fullname ?? 'Prof. HAUHOUOT Asseypo Antoine' }}</strong></div> 
                </td>
            </tr>
            @if ($bulletinData['semestre'] == 2)
                <tr class="text-center">
                    <td colspan="4"><strong>Décision de fin d’année</strong></td>
                </tr>
                <tr class="text-center">
                    <td class="py-3" colspan="4"><strong>{{ $moyAnnuelle >= 10 ? 'ADMIS(E)' : 'AJOURNÉ(E)' }}</strong></td>
                </tr>
                <tr class="text-center">
                    <td colspan="4"> Appréciation du Conseil Scientifique</td>
                </tr>
            @else
                <tr class="text-center">
                    <td colspan="4" rowspan="3"></td>
                </tr>
            @endif
            
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
                    06 BP 66 31 ABIDJAN 06 - Tel : (+225) 01 40 06 93 93 / 01 40 06 92 92 <br>
                    <span style="text-decoration: underline"> Arreté d'ouverture n°0210 du 11 Sept. 2000</span>  <br>
                    E-mail : scolarite@groupeatlantique.com / Site Web : uatlantique.org <br>
                </div>
            @endif
        </div>
    @endif

</body>
</html>
