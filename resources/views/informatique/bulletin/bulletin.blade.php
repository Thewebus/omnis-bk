@extends('layouts.informatique.master')

@section('title')Bulletin
 {{ $title }}
@endsection

@push('css')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/prism.css')}}">
<style>
    .bg-grey {
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
        <li class="breadcrumb-item active">Bulletin LMD</li>
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
                            {{-- <div class="col-sm-2">
                                <form action="{{ route('admin.all-bulletin-download', $classe->id) }}" method="post">
                                    @csrf
                                    <input type="hidden" name="semestre" value="{{ $semestre }}">
                                    <input type="hidden" name="session" value="{{ $session }}">
                                    <button type="submit" class="btn btn-success"><i class="fa fa-download"></i> Tous télécharger</button>
                                </form>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if ($anneeAcademique->id == 1)
            @foreach ($bulletinDatas as $key => $bulletinData)
                <div class="card p-3">
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
                                <div class="col-4"><h6> {{ $bulletinData['semestre'] == 1 ? '1er' : '2ème' }} Semestre - {{ $bulletinData['session'] == 1 ? '1ère' : '2ème' }} Session</h6></div>
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
                                                    <th class="col-md-1 text-center">Coef</th>
                                                    <th class="col-md-1 text-center">Credits</th>
                                                    <th class="col-md-1 text-center">Moy /20</th>
                                                    <th class="col-md-1 text-center">Resultats</th>
                                                    <th class="col-md-1 text-center">Mention</th>
                                                    <th class="col-md-3 text-center">Enseignant</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($bulletinData['unite_enseignements'] as $uniteEnseignements)
                                                    {{-- @if (count($uniteEnseignements) > 1) --}}
                                                        @foreach ($uniteEnseignements as $uniteEnseignement)
                                                            @if ($loop->index == 0)
                                                                <tr>
                                                                    <td style="background-color: rgb(186, 186, 186);" colspan="7">{{ $uniteEnseignement }}</td>
                                                                </tr>    
                                                            @else
                                                                <tr>    
                                                                    <td>{{ $uniteEnseignement['matiere'] }}</td>
                                                                    <td class="text-center">{{ $uniteEnseignement['coefficient'] }}</td>
                                                                    <td class="text-center">{{ $uniteEnseignement['credit'] }}</td>
                                                                    <td class="text-center">{{ $uniteEnseignement['moyenne'] }}</td>
                                                                    <td class="text-center">{{ $uniteEnseignement['resultat'] }}</td>
                                                                    <td class="text-center">{{ $uniteEnseignement['mention'] }}</td>
                                                                    <td class="text-center">{{ $uniteEnseignement['nom_professeur'] }}</td>
                                                                </tr>
                                                            @endif
                                                        @endforeach
                                                    {{-- @endif --}}
                                                @endforeach
                                                {{-- @if ($bulletinData['semestre'] == 1)
                                                    <tr>
                                                        <td>MOYENNE</td>
                                                        <td class="text-center">{{ round($bulletinData['moyenne_finale'], 2) }}</td>
                                                        <td colspan="5"></td>
                                                    </tr>
                                                @endif --}}
                                                {{-- <tr>
                                                    <td>RESULTAT</td>
                                                    <td class="text-center">{{ $bulletinData['resultat_final'] }}</td>
                                                    <td class="text-center">MENTION :</td>
                                                    <td class="text-center"><strong>{{ $bulletinData['mention_finale'] }}</strong></td>
                                                    <td class="text-center">Total crédit validés:</td>
                                                    <td class="text-center">{{ $bulletinData['total_credit_validee'] }} <em class="mr-3">/</em></td>
                                                    <td>{{ $bulletinData['total_credit'] }}</td>
                                                </tr> --}}
                                                <tr class="background-tab">
                                                    <td colspan="3">Crédit(s) Validé(s): {{ $bulletinData['total_credit_validee'] }} / {{ $bulletinData['total_credit'] }} </td>
                                                    <td colspan="2"> Moyenne : {{ round($bulletinData['moyenne_finale'], 2) }} </td>
                                                    <td colspan="2"> Résultat : {{ $bulletinData['resultat_final'] }} </td>
                                                </tr>
                                                @if ($bulletinData['semestre'] == 2)
                                                    @php
                                                        $total_credits_valides = $bulletinData['total_credit_validee'] + $bulletinData['credits_validee_semestre_1'];
                                                        $total_credits = $bulletinData['total_credit'] + $bulletinData['total_credits_semestre_1'];
                                                        $decision_jury = $total_credits_valides == $total_credits ? 'Admis(e)' : 'Ajourné(e)';
                                                        $moyenne_annuelle = ($bulletinData['moyenne_finale'] + $bulletinData['moyenne_semestre_1']) / 2;
                                                    @endphp
                                                    <tr class="background-tab">
                                                        <td colspan="3">Crédit(s) validé(s) semestre 1 : {{ $bulletinData['credits_validee_semestre_1'] }} / {{ $bulletinData['total_credits_semestre_1'] }} </td>
                                                        <td colspan="2">Moy.Semestre 1 : {{ round($bulletinData['moyenne_semestre_1'], 2) }} </td>
                                                        <td colspan="2">Résultat semestre 1 : {{ $bulletinData['resultat_semestre_1'] }}</td>
                                                    </tr>
                                                    <tr class="background-tab">
                                                        <td colspan="3">Total crédit(s) validé(s) : {{ $total_credits_valides }}/{{ $total_credits }}  </td>
                                                        <td colspan="2">Moy.Annuelle : {{ round($moyenne_annuelle, 2) }} </td>
                                                        <td colspan="2">Décision du jury : {{ $decision_jury }}</td>
                                                    </tr>
                                                    {{-- <tr>
                                                        <td style="background-color: rgb(186, 186, 186);" colspan="2"><strong>PRIEMIER SEMESTRE</strong> </td>
                                                        <td style="background-color: rgb(186, 186, 186);" colspan="2"><strong>DEUXIEME SEMESTRE</strong> </td>
                                                        <td colspan="3" class="text-center" style="background-color: rgb(186, 186, 186);"><strong>BILAN ANNUEL</strong></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2"> Moyenne : <strong>{{ round($bulletinData['moyenne_semestre_1'], 2) }}</strong> </td>
                                                        <td colspan="2">Moyenne : <strong>{{ round($bulletinData['moyenne_finale'], 2) }}</strong> </td>
                                                        <td colspan="3" class="text-center">Moy. Ann. : <strong>{{ round($bulletinData['moyenne_annelle'], 2) }}</strong></td>
                                                    </tr> --}}
                                                @endif
                                                <tr>
                                                     {{-- <th style="padding-bottom: 10em" colspan="5">
                                                        @if ($bulletinData['semestre'] == 2)
                                                            <div>
                                                                <span style="text-decoration: underline"> Décision de fin d'année</span>
                                                            </div>
                                                        @endif
                                                    </th> --}}
                                                    <td class="text-center" colspan="7">
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
                        <form action="{{ route('admin.one-bulletin-download', $bulletinData['etudiant_id']) }}" method="post">
                            @csrf
                            <input type="hidden" name="semestre" value="{{ $bulletinData['semestre'] }}">
                            <input type="hidden" name="session" value="{{ $bulletinData['session'] }}">
                            <button type="submit" class="btn btn-success"><i class="fa fa-download"></i> Télécharger</button>
                        </form>
                    </div>
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
                                    <div class="col-5">
                                        <img src="{{ env('LOGO_BULLETIN') }}" width="350" alt="">
                                        <div class="m-5">Année Academique {{ $bulletinData['anneeAcademique'] }}</div>
                                        <div class="m-5">{{ $bulletinData['identifiant_bulletin'] }}</div>
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
                                @php
                                    $creditValides = 0;
                                @endphp
                                <div class="mt-2">
                                    <div class="row">
                                        <div class="col-12 text-center p-1 font-weight-bold bg-grey"><h3>{{ $bulletinData['faculte'] }}</h3></div>
                                        <div class="col-12 text-center p-1 font-weight-bold" style="background-color: rgb(20, 0, 196);"><h4>RELEVE DE NOTES</h4></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-9"></div>
                                        <div class="col-md-3"> <p style="font-size: 1.2em">Session {{ $bulletinData['session'] == 1 ? '1' : '2' }} / Semestre {{ $bulletinData['semestre'] == 1 ? '1' : '2' }} </p></div>
                                        <p class="mt-2">ETUDIANT(E) : <strong>{{ $bulletinData['fullname'] }}</strong></p>
                                        <p>NEE LE: <strong>{{ $bulletinData['dateNais'] }}</strong> A: <strong>{{ $bulletinData['lieuNais'] }}</strong></p>
                                        <p>CLASSE : <strong> {{ $bulletinData['classe'] }}</strong></p>
                                        <div class="col-md-9"></div>
                                        <div class="col-md-3"><h6>Matricule: {{ $bulletinData['matricule_etudiant'] }}</h6></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-lg-12 col-xl-12">
                                            <div class="table-responsive">
                                                <table class="table border table-bordered">
                                                    @foreach ($bulletinData['unite_enseignements'] as $uniteEnseignements)
                                                        @if (count($uniteEnseignements) > 1)
                                                            @foreach ($uniteEnseignements as $uniteEnseignement)
                                                                @php
                                                                    $rowspan = count($uniteEnseignements) - 1;
                                                                    $credEu = array_sum(array_column($uniteEnseignements, 'credit'));
                                                                    $moyEu = array_sum(array_column($uniteEnseignements, 'credit_moyenne')) / $credEu;
                                                                    $moyEu = $bulletinService->nombreFormatDeuxDecimal($moyEu);
                                                                    $resultEu = $bulletinService->mention($moyEu);
                                                                @endphp
                                                                @if ($loop->index == 0)
                                                                    <tr class="bg-grey text-center align-middle">
                                                                        <td>UE</td>
                                                                        <td>{{ $uniteEnseignement }}</td>
                                                                        <td>MOY.ECUE</td>
                                                                        <td>MOY.UE</td>
                                                                        <td>CRED.UE</td>
                                                                        <td>RESULT.UE</td>
                                                                        <td>MENTION</td>
                                                                        <td>SESSION</td>
                                                                    </tr>
                                                                @elseif ($loop->index == 1)
                                                                    <tr class="text-center align-middle">
                                                                        <td rowspan="{{ $rowspan }}">ECUE</td>
                                                                        <td>{{ $uniteEnseignement['matiere'] }}</td>
                                                                        <td>{{ $uniteEnseignement['moyenne'] }}</td>
                                                                        <td rowspan="{{ $rowspan }}" style="background-color: rgb(186, 186, 186);">{{ $moyEu }}</td>
                                                                        <td rowspan="{{ $rowspan }}">{{ $credEu }}</td> 
                                                                        @php 
                                                                            $moyEu >= 10 ? $creditValides += $credEu : $creditValides += 0;
                                                                        @endphp
                                                                        <td rowspan="{{ $rowspan }}" style="background-color: rgb(186, 186, 186);">{{ $moyEu >= 10 ? 'VALIDEE' : 'NON VALIDEE' }}</td>
                                                                        <td rowspan="{{ $rowspan }}">{{ $resultEu }}</td>
                                                                        <td rowspan="{{ $rowspan }}">
                                                                            <div class="row">
                                                                                <div class="col-md-6">
                                                                                    <select class="form-select" name="{{ $uniteEnseignements['nom'] }}[]" id="" required="">
                                                                                        <option value="Janvier">Janvier</option>
                                                                                        <option value="Fevrier">Fevrier</option>
                                                                                        <option value="Mars">Mars</option>
                                                                                        <option selected="Avril" value="Avril">Avril</option>
                                                                                        <option value="Mai">Mai</option>
                                                                                        <option value="Juin">Juin</option>
                                                                                        <option value="Juillet">Juillet</option>
                                                                                        <option value="Aout">Aout</option>
                                                                                        <option value="Septembre">Septembre</option>
                                                                                        <option value="Octobre">Octobre</option>
                                                                                        <option value="Novembre">Novembre</option>
                                                                                        <option value="Decembre">Decembre</option>
                                                                                    </select>
                                                                                </div>
                                                                                <div class="col-md-6">
                                                                                    <select class="form-select" name="{{ $uniteEnseignements['nom'] }}[]" id="" required="">
                                                                                        <option value="2022">2022</option>
                                                                                        <option selected="2023" value="2023">2023</option>
                                                                                        <option  value="2024">2024</option>
                                                                                        <option  value="2025">2025</option>
                                                                                        <option  value="2026">2026</option>
                                                                                        <option  value="2027">2027</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </td>
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
                                                    
                                                    <tr class="bg-grey text-center align-middle">
                                                        <td colspan="3">Crédit(s) Validé(s) : <span class="text-danger">{{ $creditValides }} / {{ $bulletinData['total_credit'] }}</span></td>
                                                        <td colspan="2">Moy.Semestre : <span class="text-danger">{{ $bulletinService->nombreFormatDeuxDecimal($bulletinData['moyenne_finale']) }}</span></td>
                                                        <td colspan="3">Résultats : <span class="text-danger"> {{ $bulletinData['resultat_final'] }}</span> </td>
                                                    </tr>
                                                    @if ($bulletinData['semestre'] == 2)
                                                        @php
                                                            $total_credits_valides = $creditValides + $bulletinData['credits_validee_semestre_1'];
                                                            $total_credits = $bulletinData['total_credit'] + $bulletinData['total_credits_semestre_1'];
                                                            $decision_jury = $total_credits_valides == $total_credits ? 'Admis(e)' : 'Ajourné(e)';
                                                            $moyenne_annuelle = ($bulletinData['moyenne_finale'] + $bulletinData['moyenne_semestre_1']) / 2;
                                                        @endphp
                                                        <tr class="bg-grey text-center align-middle">
                                                            <td colspan="3">Crédit(s) Validé(s) Semestre 1 : <span class="text-danger">{{ $bulletinData['credits_validee_semestre_1'] }} / {{ $bulletinData['total_credits_semestre_1'] }}</span></td>
                                                            <td colspan="2">Moy.Semestre 1 : <span class="text-danger">{{ $bulletinService->nombreFormatDeuxDecimal($bulletinData['moyenne_semestre_1']) }}</span></td>
                                                            <td colspan="3">Résultat semestre 1 : <span class="text-danger"> {{ $bulletinData['resultat_semestre_1'] }}</span> </td>
                                                        </tr>
                                                        <tr class="bg-grey text-center align-middle">
                                                            <td colspan="3">Total Crédit(s) Validé(s) : <span class="text-danger">{{ $total_credits_valides }} / {{ $total_credits }}</span></td>
                                                            <td colspan="2">Moy.Annuelle : <span class="text-danger">{{ $bulletinService->nombreFormatDeuxDecimal($moyenne_annuelle) }}</span></td>
                                                            <td colspan="3">Décision du jury : <span class="text-danger"> {{ $decision_jury }}</span> </td>
                                                        </tr>
                                                    @endif
                                                    <tr>
                                                        <td colspan="8" style="padding-bottom: 5em">
                                                            <p>
                                                                Fait à @if(env('OWNER') == 'ua_abidjan') Abidjan,
                                                                    @elseif(env('OWNER') == 'ua_bouake') Bouaké,
                                                                    @elseif(env('OWNER') == 'ua_bassam') Grand-Bassam,
                                                                    @elseif(env('OWNER') == 'ua_sp') San-Pedro,
                                                                    @endif le {{ date('d/m/Y') }} <br>
                                                            </p>
                                                            <p class="text-end mb-5">
                                                                {{ $signataire->fonction ?? 'Le Président du Conseil Scientifique' }}
                                                            </p>
                                                            <p class="text-end mt-5">
                                                                {{ $signataire->fullname ?? 'Prof. HAUHOUOT Asseypo Antoine' }}
                                                            </p>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
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