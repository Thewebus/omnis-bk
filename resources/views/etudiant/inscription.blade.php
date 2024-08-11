@extends('layouts.etudiant.master')

@section('title')Inscription
 {{ ($title) }}
@endsection

@push('css')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/sweetalert2.css')}}">
@livewireStyles
@endpush

@section('content')
    @component('components.etudiant.breadcrumb')
        @slot('breadcrumb_title')
        <h3>Inscription</h3>
        @endslot
        <li class="breadcrumb-item active">Inscription</li>
        {{-- <li class="breadcrumb-item active">Sample Page</li> --}}
    @endcomponent

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <h5>Formulaire d'inscription</h5>
                        <span>Veuillez remplir le formulaire suivant pour poursuivre votre</span>
                    </div>
                    <div class="card-body">
                        @if (Auth::user()->inscriptions->count() == 0)
                            <form action="{{ route('user.store-inscription') }}" enctype="multipart/form-data" method="POST" novalidate>
                                @csrf
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <h5 style="color: #24695c">IDENTITE PERSONNELLE</h5>
                                    </div>
                                </div>
                                <div class="row g-3 mb-3">
                                    <div class="col-md-4">
                                        <label class="form-label" for="nom_complet">Nom & Prénoms <span style="color: red">*</span></label>
                                        <input class="form-control @error('nom_complet') is-invalid @enderror" id="nom_complet" value="{{ old('nom_complet') ?? Auth::user()->fullname }}" name="nom_complet" type="text" placeholder="Nom & Prénom" />
                                        @error('nom_complet')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label" for="date_naissance">Date de naissance <span style="color: red">*</span></label>
                                        <input class="form-control @error('date_naissance') is-invalid @enderror" id="date_naissance" value="{{ old('date_naissance') }}" name="date_naissance" type="date" placeholder="Date de naissance" />
                                        @error('date_naissance')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label" for="lieu_naissance">Lieu de naissance <span style="color: red">*</span></label>
                                        <input class="form-control @error('lieu_naissance') is-invalid @enderror" id="lieu_naissance" value="{{ old('lieu_naissance') }}" name="lieu_naissance" type="text" placeholder="Lieu de naissance" />
                                        @error('lieu_naissance')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row g-3 mb-3">
                                    <div class="col-md-4">
                                        <label class="form-label" for="nationalite">Nationalité <span style="color: red">*</span></label>
                                        <input class="form-control @error('nationalite') is-invalid @enderror" id="nationalite" value="{{ old('nationalite') }}" name="nationalite" type="text" placeholder="Nationalité" />
                                        @error('nationalite')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label" for="sexe">Sexe <span style="color: red">*</span></label>
                                        <select class="form-select @error('sexe') is-invalid @enderror" id="sexe" name="sexe">
                                            <option value="">Choisir...</option>
                                            <option value="masculin" {{ old('sexe') == 'masculin' ? 'selected' : '' }}>Masculin</option>
                                            <option value="feminin" {{ old('sexe') == 'feminin' ? 'selected' : '' }}>Feminin</option>
                                        </select>
                                        @error('sexe')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label" for="domicile">Domicile <span style="color: red">*</span></label>
                                        <input class="form-control @error('domicile') is-invalid @enderror" id="domicile" value="{{ old('domicile') }}" name="domicile" type="text" placeholder="Domicile" />
                                        @error('domicile')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row g-3 mb-3">
                                    <div class="col-md-4">
                                        <label class="form-label" for="numero">Contact</label>
                                        <input class="form-control @error('numero') is-invalid @enderror" id="numero" value="{{ old('numero') ?? Auth::user()->numero_etudiant }}" name="numero" type="number" placeholder="Contact" />
                                        @error('numero')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label" for="email">Email</label>
                                        <input class="form-control @error('email') is-invalid @enderror" id="email" value="{{ old('email') ?? Auth::user()->email }}" name="email" type="text" placeholder="Email" />
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label" for="etablissement_origine">Etablissement d'origine <span style="color: red">*</span></label>
                                        <input class="form-control @error('etablissement_origine') is-invalid @enderror" id="etablissement_origine" value="{{ old('etablissement_origine') }}" name="etablissement_origine" type="text" placeholder="Etablissement d'origine" />
                                        @error('etablissement_origine')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row g-3 mb-3">
                                    <div class="col-md-3">
                                        <label class="form-label" for="adresse_geographique">Adresse Géographique de l'établissement <span style="color: red">*</span></label>
                                        <input class="form-control @error('adresse_geographique') is-invalid @enderror" id="adresse_geographique" value="{{ old('adresse_geographique') }}" name="adresse_geographique" type="text" placeholder="Adresse Géographique" />
                                        @error('adresse_geographique')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label" for="niveau_etude">Niveau d'étude BAC <span style="color: red">*</span></label>
                                        <input class="form-control @error('niveau_etude') is-invalid @enderror" id="niveau_etude" value="{{ old('niveau_etude') }}" name="niveau_etude" type="text" placeholder="Niveau d'étude" />
                                        @error('niveau_etude')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label" for="serie_bac">Serie BAC <span style="color: red">*</span></label>
                                        <input class="form-control @error('serie_bac') is-invalid @enderror" id="serie_bac" value="{{ old('serie_bac') }}" name="serie_bac" type="text" placeholder="Série BAC" />
                                        @error('serie_bac')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label" for="autre_diplome">Autre diplôme </label>
                                        <input class="form-control @error('autre_diplome') is-invalid @enderror" id="autre_diplome" value="{{ old('autre_diplome') }}" name="autre_diplome" type="text" placeholder="Autre diplôme" />
                                        @error('autre_diplome')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>                               
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <h5 style="color: #24695c">ANNEE ACADEMIQUE</h5>
                                    </div>
                                </div>
                                <div class="row g-3 mb-3">
                                    {{-- <div class="col-md-4 mb-3">
                                        <label class="form-label" for="filiere">Statut   <span style="color: red">*</span></label>
                                        <div class="form-group m-t-10 m-checkbox-inline mb-0 custom-radio-ml">
                                            <div class="radio radio-primary">
                                                <input class="radio_animated" id="affecte" type="radio" name="statut" value="affecté" checked>
                                                <label class="mb-0" for="affecte">Affecté</label>
                                            </div>
                                            <div class="radio radio-primary">
                                                <input class="radio_animated" id="non-affecte" type="radio" name="statut" value="non affecté">
                                                <label class="mb-0" for="non-affecte">Non Affecté</label>
                                            </div>
                                            <div class="radio radio-primary">
                                                <input class="radio_animated" id="reaffecte" type="radio" name="statut" value="réaffecté">
                                                <label class="mb-0" for="reaffecte">Réaffecté</label>
                                            </div>
                                        </div>
                                    </div> --}}
                                    <div class="col-md-6">
                                        <label class="form-label" for="niveau_etude_2">Niveau d'étude <span style="color: red">*</span></label>
                                        <select class="form-select digits @error('niveau_etude_2') is-invalid @enderror" id="niveau_etude_2" name="niveau_etude_2" >
                                            <option selected value="">Choisir un niveau</option>
                                            <optgroup label="BTS">
                                                <option value="bts 1" {{ old('niveau_etude_2') == 'bts 1' ? 'selected' : '' }}>BTS 1</option>
                                                <option value="bts 2" {{ old('niveau_etude_2') == 'bts 2' ? 'selected' : '' }}>BTS 2</option>
                                            </optgroup>
                                            <optgroup label="LICENCE">
                                                <option value="licence 1" {{ old('niveau_etude_2') == 'licence 1' ? 'selected' : '' }}>LICENCE 1</option>
                                                <option value="licence 2" {{ old('niveau_etude_2') == 'licence 2' ? 'selected' : '' }}>LICENCE 2</option>
                                                <option value="licence 3" {{ old('niveau_etude_2') == 'licence 3' ? 'selected' : '' }}>LICENCE 3</option>
                                            </optgroup>
                                            <optgroup label="MASTER">
                                                <option value="master 1" {{ old('niveau_etude_2') == 'master 1' ? 'selected' : '' }}>MASTER 1</option>
                                                <option value="master 2" {{ old('niveau_etude_2') == 'master 2' ? 'selected' : '' }}>MASTER 2</option>
                                            </optgroup>
                                        </select>
                                        @error('niveau_etude_2')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    {{-- <div class="col-md-3">
                                        <label class="form-label" for="faculte">Faculté <span style="color: red">*</span></label>
                                        <select class="js-example-basic-single col-sm-12 @error('faculte') is-invalid @enderror" id="faculte" name="faculte">
                                            <option value="">Choisir la faculte</option>
                                            @foreach ($facultes as $faculte)
                                                <option {{ old("faculte") == $faculte->id ? 'selected' : '' }} value="{{ $faculte->id }}">{{ $faculte->nom }}</option>
                                            @endforeach
                                        </select>
                                        @error('faculte')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div> --}}
                                    <div class="col-md-6">
                                        <label class="form-label" for="date_premiere_entree">Date de la 1er rentrée à l'université (année)</label>
                                        <input class="form-control @error('date_premiere_entree') is-invalid @enderror" id="date_premiere_entree" value="{{ old('date_premiere_entree') }}" name="date_premiere_entree" type="number" placeholder="Date de la 1er rentrée à l'université" />
                                        @error('date_premiere_entree')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                {{-- <div class="row mb-3 g-3">
                                    <div class="col-md-6">
                                        <label class="form-label" for="classe">Classe <span style="color: red">*</span></label>
                                        <select class="js-example-basic-single col-sm-12 @error('classe') is-invalid @enderror" id="classe" name="classe">
                                            <option value="">Choisir la classe</option>
                                            @foreach ($classes as $classe)
                                                <option {{ old("classe") == $classe->id ? 'selected' : '' }} value="{{ $classe->id }}">{{ $classe->nom }} | {{ $classe->code }}</option>
                                            @endforeach
                                        </select>
                                        @error('classe')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="matricule">Matricule</label>
                                        <input class="form-control @error('matricule') is-invalid @enderror" id="matricule" value="{{ old('matricule') }}" name="matricule" type="text" placeholder="Matricule" />
                                        @error('matricule')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div> --}}
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <h5 style="color: #24695c">RESPONSABLE LEGAL DE L’ETUDIANT (A APPELER EN CAS D’URGENCE)</h5>
                                    </div>
                                </div>
                                <div class="row mb-3 g-3">
                                    <div class="col-md-5 mb-3">
                                        <label class="form-label" for="filiere">Responsable   <span style="color: red">*</span></label>
                                        <div class="form-group m-t-10 m-checkbox-inline mb-0 custom-radio-ml">
                                            <div class="radio radio-primary">
                                                <input class="radio_animated" id="pere" type="radio" name="responsable_legal" value="pere" checked>
                                                <label class="mb-0" for="pere">Père</label>
                                            </div>
                                            <div class="radio radio-primary">
                                                <input class="radio_animated" id="mere" type="radio" name="responsable_legal" value="mere">
                                                <label class="mb-0" for="mere">Mère</label>
                                            </div>
                                            <div class="radio radio-primary">
                                                <input class="radio_animated" id="vivant seul" type="radio" name="responsable_legal" value="vivant seul">
                                                <label class="mb-0" for="vivant seul">Vivant seul</label>
                                            </div>
                                            <div class="radio radio-primary">
                                                <input class="radio_animated" id="autre" type="radio" name="responsable_legal" value="autre">
                                                <label class="mb-0" for="autre">Autre</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label" for="responsable_legal_precision">Précision si autre <span style="color: red">*</span></label>
                                        <input class="form-control @error('responsable_legal_precision') is-invalid @enderror" id="responsable_legal_precision" value="{{ old('responsable_legal_precision') }}" name="responsable_legal_precision" type="text" placeholder="Précision autre" />
                                        @error('responsable_legal_precision')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label" for="responsable_legal_fullname">Nom & Prénom</label>
                                        <input class="form-control @error('responsable_legal_fullname') is-invalid @enderror" id="responsable_legal_fullname" value="{{ old('responsable_legal_fullname') }}" name="responsable_legal_fullname" type="text" placeholder="Nom & Prénom" />
                                        @error('responsable_legal_fullname')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3 g-3">
                                    <div class="col-md-3">
                                        <label class="form-label" for="responsable_legal_profession">Profession</label>
                                        <input class="form-control @error('responsable_legal_profession') is-invalid @enderror" id="responsable_legal_profession" value="{{ old('responsable_legal_profession') }}" name="responsable_legal_profession" type="text" placeholder="Profession" />
                                        @error('responsable_legal_profession')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label" for="responsable_legal_adresse">Adresse</label>
                                        <input class="form-control @error('responsable_legal_adresse') is-invalid @enderror" id="responsable_legal_adresse" value="{{ old('responsable_legal_adresse') }}" name="responsable_legal_adresse" type="text" placeholder="Adresse" />
                                        @error('responsable_legal_adresse')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label" for="responsable_legal_domicile">Domicile</label>
                                        <input class="form-control @error('responsable_legal_domicile') is-invalid @enderror" id="responsable_legal_domicile" value="{{ old('responsable_legal_domicile') }}" name="responsable_legal_domicile" type="text" placeholder="Domicile" />
                                        @error('responsable_legal_domicile')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label" for="responsable_legal_numero">Téléphone</label>
                                        <input class="form-control @error('responsable_legal_numero') is-invalid @enderror" id="responsable_legal_numero" value="{{ old('responsable_legal_numero') }}" name="responsable_legal_numero" type="text" placeholder="Téléphone" />
                                        @error('responsable_legal_numero')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                {{-- <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <h5 style="color: #24695c">PERSONNE EN CHARGE DU PAIEMENT DE LA SCOLARITE (A APPELER EN CAS DE BESOIN)</h5>
                                    </div>
                                </div>
                                <div class="row mb-3 g-3">
                                    <div class="col-md-6">
                                        <label class="form-label" for="responsable_scolarite_fullname">Nom & Prénom</label>
                                        <input class="form-control @error('responsable_scolarite_fullname') is-invalid @enderror" id="responsable_scolarite_fullname" value="{{ old('responsable_scolarite_fullname') }}" name="responsable_scolarite_fullname" type="text" placeholder="Nom & Prénom" />
                                        @error('responsable_scolarite_fullname')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="responsable_scolarite_profession">Profession</label>
                                        <input class="form-control @error('responsable_scolarite_profession') is-invalid @enderror" id="responsable_scolarite_profession" value="{{ old('responsable_scolarite_profession') }}" name="responsable_scolarite_profession" type="text" placeholder="Profession" />
                                        @error('responsable_scolarite_profession')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3 g-3">
                                    <div class="col-md-4">
                                        <label class="form-label" for="responsable_scolarite_adresse">Adresse</label>
                                        <input class="form-control @error('responsable_scolarite_adresse') is-invalid @enderror" id="responsable_scolarite_adresse" value="{{ old('responsable_scolarite_adresse') }}" name="responsable_scolarite_adresse" type="text" placeholder="Adresse" />
                                        @error('responsable_scolarite_adresse')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label" for="responsable_scolarite_domicile">Domicile</label>
                                        <input class="form-control @error('responsable_scolarite_domicile') is-invalid @enderror" id="responsable_scolarite_domicile" value="{{ old('responsable_scolarite_domicile') }}" name="responsable_scolarite_domicile" type="text" placeholder="Domicile" />
                                        @error('responsable_scolarite_domicile')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label" for="responsable_scolarite_numero">Téléphone</label>
                                        <input class="form-control @error('responsable_scolarite_numero') is-invalid @enderror" id="responsable_scolarite_numero" value="{{ old('responsable_scolarite_numero') }}" name="responsable_scolarite_numero" type="text" placeholder="Téléphone" />
                                        @error('responsable_scolarite_numero')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div> --}}
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <h5 style="color: #24695c">DOSSIERS</h5>
                                    </div>
                                </div>
                                <div class="row g-3 mb-3">
                                    <div class="col-md-4">
                                        <label class="form-label @error('fiche_inscription') is-invalid @enderror" for="fiche_inscription">Fiche d'inscription</label>
                                        <input class="form-control" type="file" name="fiche_inscription" aria-label="file example"/>
                                        @error('fiche_inscription')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label @error('fiche_oriantation') is-invalid @enderror" for="fiche_oriantation">Fiche d'orientation</label>
                                        <input class="form-control" type="file" name="fiche_oriantation" aria-label="file example"/>
                                        @error('fiche_oriantation')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label @error('extrait_naissance') is-invalid @enderror" for="numero_recu_scolarite">Extrait de naissance</label>
                                        <input class="form-control" type="file" name="extrait_naissance" aria-label="file example"/>
                                        @error('extrait_naissance')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row g-3 mb-3">
                                    <div class="col-md-4">
                                        <label class="form-label @error('bac_legalise') is-invalid @enderror" for="bac_legalise">Phcpie BAC légalisé</label>
                                        <input class="form-control" type="file" name="bac_legalise" aria-label="file example"/>
                                        @error('bac_legalise')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label @error('cp_note_bac') is-invalid @enderror" for="cp_note_bac">Phcpie relevé notes BAC</label>
                                        <input class="form-control" type="file" name="cp_note_bac" aria-label="file example"/>
                                        @error('cp_note_bac')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label @error('photo') is-invalid @enderror" for="photo">Photo couleur</label>
                                        <input class="form-control" type="file" name="photo" aria-label="file example"/>
                                        @error('photo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <button class="btn btn-primary" type="submit">Valider</button>
                            </form>
                        @else
                            <h1>Votre inscription est en cours de traitement</h1>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Vertically centered modal-->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenter" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Informations enrégistrées</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p> Vos informations on été enrégistrées. Patientez pendant le traitement </p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        @livewireScripts
        <script src="{{asset('assets/js/sweet-alert/sweetalert.min.js')}}"></script>
        <script src="{{asset('assets/js/sweet-alert/app.js')}}"></script>
        @if (Session('success'))
            <script>
                $(function() {
                    $('#exampleModalCenter').modal('show');
                });
            </script>
        @endif
    @endpush

@endsection
