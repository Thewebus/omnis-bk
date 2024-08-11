@extends('layouts.informatique.master')

@section('title')Bulletin
 {{ $title }}
@endsection

@push('css')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/prism.css')}}">
<style>
    .background-tab {
        background-color: rgb(186, 186, 186)
    }
</style>
@endpush

@section('content')
    @component('components.informatique.breadcrumb')
        @slot('breadcrumb_title')
            <h3>Bulletin</h3>
        @endslot
        <li class="breadcrumb-item">Accueil</li>
        <li class="breadcrumb-item active">Bulletin BTS</li>
    @endcomponent
    @inject('bulletinService', 'App\Services\BulletinService')

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <h5>Bulletin Faculté : {{ $classe->niveauFaculte->faculte->nom }} - Classe : {{ $classe->nom }} - Session {{ $session }}</h5>
                            <div class="col-sm-10">
                                {{-- <span>Use class<code>.table-primary</code> inside thead tr element.</span> --}}
                            </div>
                            <div class="col-sm-2">
                                {{-- <form action="{{ route('admin.all-bulletin-download', $classe->id) }}" method="post">
                                    @csrf
                                    <input type="hidden" name="semestre" value="{{ $semestre }}">
                                    <input type="hidden" name="session" value="{{ $session }}">
                                    <button type="submit" class="btn btn-success"><i class="fa fa-download"></i> Tous télécharger</button>
                                </form> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @php
            $moyennesMatieres = end($bulletinDatas)['moyennes_matieres'];
            $moyennesAnnuelles = end($bulletinDatas)['moyennes_annelles'];
            $moyennesFinalesSemestre1 = end($bulletinDatas)['moyennes_finales_semestre1'];
        @endphp
        @if ($anneeAcademique->id == 1)
            @foreach ($bulletinDatas as $key => $bulletinData)
                <div class="card p-3">
                    <form action="{{ route('admin.one-bulletin-download', $bulletinData['etudiant_id']) }}" method="post">
                        @csrf
                        <div class="card-block row">
                            <div class="mt-3">
                                <div class="row">
                                    <div class="col-5">
                                        <img src="{{ env('LOGO_BULLETIN') }}" width="350" alt="">
                                    </div>
                                    <div class="col-2"></div>
                                    <div class="col-5 text-center">
                                        <h6>REPUBLIQUE DE COTE D'IVOIRE</h6>
                                        -------------------------------
                                        <h6>UNION - DISCIPLINE - TRAVAIL</h6>
                                        --------------------------
                                        <h6>
                                            MINISTERE DE L'ENSEIGNEMENT SUPERIEUR ET
                                            DE LA RECHERCHE SCIENTIFIQUE
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        
                            <div class="mt-2">
                                <div class="row">
                                    <div class="col-6"><h6>Année Academique {{ $bulletinData['anneeAcademique'] }}</h6></div>
                                    <div class="col-2"></div>
                                    <div class="col-4"><h6> {{ $bulletinData['semestre'] == 1 ? '1er' : '2ème' }} Semestre</h6></div>
                                    <div class="col-12 mt-3 rounded p-3 text-center" style="height: 50px; background-color: #1a0a8f; color:#fff"><h5>{{ $bulletinData['faculte'] }}</h5></div>
                                </div>
                                <div class="row">
                                    <div class="col-3 my-2"><h6>{{ $bulletinData['identifiant_bulletin'] }}</h6></div>
                                    <div class="col-1"></div>
                                    <div class="col-4 text-center my-2"><h3><u>RELEVE DE NOTES</u></h3> </div>
                                    <p>ETUDIANT(E) : <strong>{{ $bulletinData['fullname'] }}</strong></p>
                                    <p>NEE LE: <strong>{{ $bulletinData['dateNais'] }}</strong> A: <strong>{{ $bulletinData['lieuNais'] }}</strong></p>
                                    <p>MATRICULE : <strong>{{ $bulletinData['matricule_etudiant'] }}</strong></p>
                                    <p>CLASSE : <strong>{{ $bulletinData['classe'] }}</strong></p>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-lg-12 col-xl-12">
                                        <div class="table-responsive">
                                            <table class="table border">
                                                <thead class="table-primary">
                                                    <tr>
                                                        <th class="col-md-3">Unités d'enseignement</th>
                                                        <th class="col-md-1 text-center">Moy</th>
                                                        <th class="col-md-1 text-center">Coef</th>
                                                        <th class="col-md-1 text-center">Moy*Co</th>
                                                        <th class="col-md-1 text-center">Rang</th>
                                                        <th class="col-md-1 text-center">Mention</th>
                                                        <th class="col-md-3 text-center">Enseignant</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($bulletinData['unite_enseignements'] as $uniteEnseignements)
                                                        @foreach ($uniteEnseignements as $uniteEnseignement)
                                                            @if ($loop->index == 0)
                                                                <tr>
                                                                    <td style="background-color: rgb(186, 186, 186);" colspan="7">{{ $uniteEnseignement }}</td>
                                                                </tr>    
                                                            @else
                                                                <tr>    
                                                                    <td>{{ $uniteEnseignement['matiere'] }}</td>
                                                                    <td class="text-center">{{ $uniteEnseignement['moyenne'] }}</td>
                                                                    <td class="text-center">{{ $uniteEnseignement['coefficient'] }}</td>
                                                                    <td class="text-center">{{ floatval($uniteEnseignement['moyenne']) *  $uniteEnseignement['coefficient'] }}</td>
                                                                    @php
                                                                        $moyenneMatiere = $uniteEnseignement['credit_moyenne'] / $uniteEnseignement['coefficient'];
                                                                        $rangMatiere = $bulletinService->classementMatiere($moyennesMatieres[$uniteEnseignement['matiere']], $moyenneMatiere);
                                                                    @endphp
                                                                    <td class="text-center">
                                                                        {{ $rangMatiere == 1 ? $rangMatiere . 'er' : $rangMatiere . 'e' }}
                                                                        <input type="hidden" name="{{ $uniteEnseignement['matiere'] }}" value="{{ $rangMatiere }}">
                                                                    </td>
                                                                    <td class="text-center">{{ $uniteEnseignement['mention'] }}</td>
                                                                    <td class="text-center">{{ $uniteEnseignement['nom_professeur'] }}</td>
                                                                </tr>
                                                            @endif
                                                        @endforeach
                                                    @endforeach
                                                    @php
                                                        $moyMax = max(array_column($bulletinDatas, 'moyenne_finale'));
                                                        $moyMin = min(array_column($bulletinDatas, 'moyenne_finale'));
                                                        $moyClass = array_sum(array_column($bulletinDatas, 'moyenne_finale')) / count($bulletinDatas);
                                                        $rang = $bulletinService->classementMoyenne($bulletinDatas, $bulletinData['moyenne_finale']);
                                                    @endphp
                                                    @if ($bulletinData['semestre'] == 1)
                                                        <tr>
                                                            <td class="text-center" colspan="3">
                                                                <h6><u>SEMESTRE 1</u></h6>
                                                                <p>
                                                                    Moy. : {{ number_format($bulletinData['moyenne_finale'], 2) }} <br>
                                                                    Rang : {{ $rang == 1 ? $rang . 'er' : $rang . 'e' }} <br>
                                                                    Absence : 00 <br>
                                                                    Mention : {{ $bulletinData['mention_finale'] }}
                                                                    <input type="hidden" name="rang" value="{{ $rang }}">
                                                                </p>
                                                            </td>
                                                            <td class="text-center" colspan="4">
                                                                <h6><u>BILAN DE CLASSE</u></h6>
                                                                <p>
                                                                    Moy de la classe : {{ number_format($moyClass, 2) }} <br>
                                                                    Moy. du 1er : {{ number_format($moyMax, 2) }} <br>
                                                                    Moy du dernier : {{ number_format($moyMin, 2) }}
                                                                    <input type="hidden" name="moyClass" value="{{ number_format($moyClass, 2) }}">
                                                                    <input type="hidden" name="moyMax" value="{{ number_format($moyMax, 2) }}">
                                                                    <input type="hidden" name="moyMin" value="{{ number_format($moyMin, 2) }}">
                                                                </p>
                                                            </td>
                                                        </tr>
                                                    @else
                                                        <tr>
                                                            <td colspan="7" style="height: 30px"></td>
                                                        </tr>
                                                        <tr>
                                                            <td style="background-color: rgb(186, 186, 186);" colspan="2"><h6>PRIEMIER SEMESTRE </h6></td>
                                                            <td style="background-color: rgb(186, 186, 186);" colspan="3"><h6>DEUXIEME SEMESTRE </h6></td>
                                                            <td style="background-color: rgb(186, 186, 186);" colspan="2"><h6>BILAN ANNUEL </h6></td>
                                                        </tr>
                                                        <tr>
                                                            @php
                                                                $rangSemestre1 = $bulletinService->classementMatiere($moyennesFinalesSemestre1, $bulletinData['moyenne_semestre_1']);
                                                                $moyAnnuelle = number_format($bulletinData['moyenne_annelle'], 2);
                                                                $moyAnnuelleClasse = array_sum($moyennesAnnuelles) / count($bulletinDatas);
                                                                $moyAnnuelle1er = max($moyennesAnnuelles);
                                                                $moyAnnuelleDer = min($moyennesAnnuelles);
                                                            @endphp
                                                            <td colspan="2">
                                                                Moyenne : {{ number_format($bulletinData['moyenne_semestre_1'], 2) }} <br>
                                                                Rang : {{ $rangSemestre1 == 1 ? $rangSemestre1 . 'er' : $rangSemestre1 . 'e' }}
                                                                <input type="hidden" name="rangSemestre1" value="{{ $rangSemestre1 }}">
                                                            </td>
                                                            <td colspan="3">
                                                                Moyenne : {{ number_format($bulletinData['moyenne_finale'], 2) }} <br>
                                                                Absence : 00
                                                            </td>
                                                            <td colspan="2">
                                                                Moy. Ann. : {{ $moyAnnuelle }} <br>
                                                                Moyenne de la classe : {{ number_format($moyAnnuelleClasse, 2) }} <br>
                                                                Moyenne du 1er : {{ number_format($moyAnnuelle1er, 2) }} <br>
                                                                Moyenne du dernier : {{ number_format($moyAnnuelleDer, 2) }}
                                                                <input type="hidden" name="moyAnnuelle" value="{{ $moyAnnuelle }}">
                                                                <input type="hidden" name="moyAnnuelleClasse" value="{{ number_format($moyAnnuelleClasse, 2) }}">
                                                                <input type="hidden" name="moyAnnuelle1er" value="{{ number_format($moyAnnuelle1er, 2) }}">
                                                                <input type="hidden" name="moyAnnuelleDer" value="{{ number_format($moyAnnuelleDer, 2) }}">
                                                            </td>
                                                        </tr>
                                                    @endif
                                                    <tr>
                                                        @if ($bulletinData['semestre'] == 2)
                                                            <td colspan="2"> <strong><u>Décision de fin d'année</u></strong> </td>
                                                        @else
                                                            <td colspan="2"></td>
                                                        @endif
                                                        <td class="text-center" colspan="5">
                                                            <p class="text-end">
                                                                Fait à @if(env('OWNER') == 'ua_abidjan') Abidjan,
                                                                    @elseif(env('OWNER') == 'ua_bouake') Bouaké,
                                                                    @elseif(env('OWNER') == 'ua_bassam') Grand-Bassam,
                                                                    @elseif(env('OWNER') == 'ua_sp') San-Pedro,
                                                                    @endif le {{ date('d/m/Y') }} <br>
                                            
                                                                <strong class="mb-5">{{ $signataire->fonction ?? 'LE DOYEN DES FACULTÉS' }}</strong><br>
                                                                <strong>{{ $signataire->fullname ?? 'DR. SYLLA MAMDOU' }}</strong>
                                                            </p>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 mt-3 mb-3 text-center">
                            <input type="hidden" name="semestre" value="{{ $bulletinData['semestre'] }}">
                            <input type="hidden" name="session" value="{{ $bulletinData['session'] }}">
                            <button type="submit" class="btn btn-success"><i class="fa fa-download"></i> Télécharger</button>
                        </div>
                    </form>
                </div>
            @endforeach
        @else
            @foreach ($bulletinDatas as $bulletinData)
                <div class="card p-3">
                    <form action="{{ route('admin.one-bulletin-download', $bulletinData['etudiant_id']) }}" method="post">
                        @csrf
                        <div class="card-block row">
                            <div class="mt-3">
                                <div class="row">
                                    <div class="col-12 text-center">
                                        <img src="{{ env('LOGO_BULLETIN') }}" width="350" alt="">
                                    </div>
                                </div>
                            </div>
                        
                            <div class="mt-2">
                                <div class="row">
                                    <div class="col-12 text-center" style="background-color: #b3b3b3"><h1>INSTITUT UNIVERSITAIRE DES HAUTES ETUDES PROFESSIONNELLES</h1></div>
                                </div>
                                <div class="row">
                                    <div class="col-10 text-center mt-2" style="background-color: #e2e2e7">
                                        <h2>BREVET DE TECHNICIEN SUPERIEUR</h2>
                                    </div>
                                    <div class="col-2 mt-3"><h3>{{ $bulletinData['anneeAcademique'] }}</h3> </div>
                                </div>
                                <div class="row">
                                    <div class="col-10 mt-3 text-center">
                                        <h3>BULLETIN DE NOTES</h3>
                                    </div>
                                    <div class="col-2 mt-3"><h4>Semestre {{ $bulletinData['semestre'] }}</h4></div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12 col-lg-12 col-xl-12">
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <tr>
                                                    <td colspan="7">Nom et Prénom(s) : {{ $bulletinData['fullname'] }}</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4">
                                                        Né(e) le : {{ $bulletinData['dateNais'] }} à {{ $bulletinData['lieuNais'] }}  <br>
                                                        Sexe : {{ $bulletinData['sexe'] }}  <br>
                                                        Statut :{{ $bulletinData['statut'] }}  <br>
                                                        Matricule : {{ $bulletinData['matricule_etudiant'] }} <br>
                                                        Redoublant(e) : NONE <br>
                                                    </td>
                                                    <td colspan="3">
                                                        <div class="mb-5">
                                                            Classe : {{ $bulletinData['faculte'] }}
                                                        </div>
                                                        Effectif : {{ count($bulletinDatas) }}
                                                        <input type="hidden" name="effectif_classe" value="{{ count($bulletinDatas) }}">
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
                                                                <td colspan="7"><h5>{{ $uniteEnseignement }}</h5> </td>
                                                            </tr> 
                                                        @else
                                                            <tr>
                                                                <td>{{ $uniteEnseignement['matiere'] }}</td>
                                                                <td class="text-center">{{ $uniteEnseignement['moyenne'] }}</td>
                                                                <td class="text-center">{{ $uniteEnseignement['coefficient'] }}</td>
                                                                <td class="text-center">{{ $uniteEnseignement['credit_moyenne'] }}</td>
                                                                @php
                                                                    $moyenneMatiere = $uniteEnseignement['credit_moyenne'] / $uniteEnseignement['coefficient'];
                                                                    $rangMatiere = $bulletinService->classementMatiere($moyennesMatieres[$uniteEnseignement['matiere']], $moyenneMatiere);
                                                                @endphp
                                                                <td class="text-center">
                                                                    {{ $rangMatiere == 1 ? $rangMatiere . 'er' : $rangMatiere . 'e' }}
                                                                    <input type="hidden" name="{{ $uniteEnseignement['matiere'] }}" value="{{ $rangMatiere }}">
                                                                </td>
                                                                <td class="text-center">{{ $uniteEnseignement['nom_professeur'] }}</td>
                                                                <td class="text-center">{{ $uniteEnseignement['mention'] }}</td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                    <tr>
                                                        @php
                                                            $moyenneUe = array_sum(array_column($uniteEnseignements, 'credit_moyenne')) / array_sum(array_column($uniteEnseignements, 'coefficient'));
                                                        @endphp
                                                        <td colspan="7"><h5>BILAN {{ $uniteEnseignements['nom'] }} : TOTAL {{ array_sum(array_column($uniteEnseignements, 'credit_moyenne')) }} / {{ array_sum(array_column($uniteEnseignements, 'coefficient')) * 20 }} - Moyenne : {{ number_format($moyenneUe, 2) }} / 20</h5> </td>
                                                    </tr>
                                                @endforeach
                                                
                                                <tr><td colspan="7"></td></tr>
                                                <tr><td colspan="7"></td></tr>
                                                <tr>
                                                    <td colspan="4"> {{ $semestre == 1 ? 'TOTAL' : ''}}</td>
                                                    <td colspan="3"></td>
                                                </tr>
                                                @php
                                                    $moyMax = max(array_column($bulletinDatas, 'moyenne_finale'));
                                                    $moyMin = min(array_column($bulletinDatas, 'moyenne_finale'));
                                                    $moyClass = array_sum(array_column($bulletinDatas, 'moyenne_finale')) / count($bulletinDatas);
                                                    $rang = $bulletinService->classementMoyenne($bulletinDatas, $bulletinData['moyenne_finale']);
                                                @endphp
                                                @if ($semestre == 2)
                                                    <tr>
                                                        @php
                                                            $rangSemestre1 = $bulletinService->classementMatiere($moyennesFinalesSemestre1, $bulletinData['moyenne_semestre_1']);
                                                        @endphp
                                                        <td colspan="4"><strong>Moyenne du 1er  SEMESTRE : {{ number_format($bulletinData['moyenne_semestre_1'], 2) }}</strong> </td>
                                                        <td colspan="3">
                                                            <strong>Rang : {{ $rangSemestre1 == 1 ? $rangSemestre1 . 'er' : $rangSemestre1 . 'e' }} sur  {{ count($bulletinDatas) }}</strong>
                                                            <input type="hidden" name="rangSemestre1" value="{{ $rangSemestre1 }}">
                                                        </td>
                                                    </tr>
                                                @else
                                                    <tr>
                                                        <td colspan="4"><strong>Moyenne du 1er  SEMESTRE : {{ number_format($bulletinData['moyenne_finale'], 2) }}</strong> </td>
                                                        <td colspan="3">
                                                            <strong>Rang : {{ $rang == 1 ? $rang . 'er' : $rang . 'e' }} sur  {{ count($bulletinDatas) }}</strong>
                                                            <input type="hidden" name="rang" value="{{ $rang }}">
                                                        </td>
                                                    </tr>
                                                @endif
                                                @if ($semestre == 2)
                                                    <tr>
                                                        <td colspan="4"><strong>Moyenne du 2er  SEMESTRE : {{ number_format($bulletinData['moyenne_finale'], 2) }}</strong> </td>
                                                        <td colspan="3">
                                                            <strong>Rang : {{ $rang == 1 ? $rang . 'er' : $rang . 'e' }} sur  {{ count($bulletinDatas) }}</strong>
                                                            <input type="hidden" name="rang" value="{{ $rang }}">
                                                        </td>
                                                    </tr>
                                                @endif
                                                <tr>
                                                    <td colspan="3">
                                                        Pus forte moyenne :      <strong>{{ number_format($moyMax, 2) }}</strong> <br>
                                                        Pus faible  moyenne :    <strong>{{ number_format($moyMin, 2) }}</strong> <br>
                                                        Moyenne de la classe: <strong>{{ number_format($moyClass, 2) }}</strong> <br>
                                                        <input type="hidden" name="moyMax" value="{{ number_format($moyMax, 2) }}">
                                                        <input type="hidden" name="moyMin" value="{{ number_format($moyMin, 2) }}">
                                                        <input type="hidden" name="moyClass" value="{{ number_format($moyClass, 2) }}">
                                                    </td>
                                                    <td colspan="3">
                                                        Total des heures d’absence      : 00
                                                    </td>
                                                </tr>
                                                <tr class="text-center">
                                                    @php
                                                        $moyAnnuelle = number_format($bulletinData['moyenne_annelle'], 2);
                                                        $rangAnnuel = $bulletinService->classementMatiere($moyennesAnnuelles, $bulletinData['moyenne_annelle']);
                                                    @endphp
                                                    <input type="hidden" name="rangAnnuel" value="{{ $rangAnnuel }}">
                                                    <td colspan="3"><strong>{{ $semestre == 2 ? 'BILAN ANNUEL : Moy .An : ' . $moyAnnuelle . ' / Rang : ' . $rangAnnuel . 'e' : 'MENTION' }}</strong> </td>
                                                    <td colspan="4" rowspan="4">
                                                        <div class="mb-5"><strong><u>{{ $signataire->fonction ?? 'Le  Président du Conseil Scientifique' }}</u></strong>  </div>
                                                        <div style="margin-top: 10em"><strong>{{ $signataire->fullname ?? 'Prof. HAUHOUOT Asseypo Antoine' }}</strong></div> 
                                                    </td>
                                                </tr>
                                                @if ($semestre == 2)
                                                    <tr class="text-center">
                                                        <td colspan="3"><strong>Décision de fin d’année</strong></td>
                                                    </tr>
                                                    <tr class="text-center">
                                                        <td class="py-3" colspan="3"><h3>{{ $moyAnnuelle >= 10 ? 'ADMIS(E)' : 'AJOURNÉ(E)' }}</h3></td>
                                                    </tr>
                                                    <tr class="text-center">
                                                        <td colspan="3"> Appréciation du Conseil Scientifique</td>
                                                    </tr>
                                                @endif
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 mt-3 mb-3 text-center">
                            <input type="hidden" name="semestre" value="{{ $bulletinData['semestre'] }}">
                            <input type="hidden" name="session" value="{{ $bulletinData['session'] }}">
                            <button type="submit" class="btn btn-success"><i class="fa fa-download"></i> Télécharger</button>
                        </div>
                    </form>
                </div>
            @endforeach
        @endif
    </div>

@endsection