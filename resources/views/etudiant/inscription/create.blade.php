@extends('layouts.etudiant.master')

@section('title')Inscription
 {{ ($title) }}
@endsection

@push('css')
@endpush

@section('content')
	@component('components.breadcrumb')
		@slot('breadcrumb_title')
			<h3>Inscritpion</h3>
		@endslot
		{{-- <li class="breadcrumb-item">Forms</li> --}}
		<li class="breadcrumb-item">Accueil</li>
		<li class="breadcrumb-item active">Inscription</li>
	@endcomponent
	
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <h5>Formulaire d'inscription</h5>
                    </div>
                    <div class="card-body">
                        <form class="f1" action="{{ route('user.post-inscription') }}" enctype="multipart/form-data" method="post">
                            @csrf
                            <div class="f1-steps">
                                <div class="f1-progress">
                                    <div class="f1-progress-line" data-now-value="16.66" data-number-of-steps="3"></div>
                                </div>
                                <div class="f1-step active">
                                    <div class="f1-step-icon"><i class="fa fa-user"></i></div>
                                    <p>Identification</p>
                                </div>
                                <div class="f1-step">
                                    <div class="f1-step-icon"><i class="fa fa-road"></i></div>
                                    <p>Cursus antérieure</p>
                                </div>
                                <div class="f1-step">
                                    <div class="f1-step-icon"><i class="fa fa-upload"></i></div>
                                    <p>Dépot de dossier</p>
                                </div>
                            </div>
                            <fieldset>
                                <div class="row g-3 mb-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="date_inscription">Date d'inscription <span style="color: red">*</span></label>
                                            <input class="form-control @error('date_inscription') is-invalid @enderror" id="date_inscription" type="date" value="{{ old('date_inscription') ?? date('Y-m-d') }}" name="date_inscription" placeholder="Date d'inscription" required>
                                            @error('date_inscription')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="nationalite">Nationalité <span style="color: red">*</span></label>
                                            <input class="form-control" id="nationalite" type="text" value="{{ old('nationalite') ?? 'Ivoirienne' }}" name="nationalite" placeholder="Nationalité" required>
                                            @error('nationalite')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 mb-3">
                                    <h5 style="color: #24695c">Information sur le père</h5>
                                </div>
                                <div class="row g-3 mb-3">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="nom_prenom_pere">Nom & Prénom <span style="color: red">*</span></label>
                                            <input class="form-control @error('nom_prenom_pere') is-invalid @enderror" id="nom_prenom_pere" value="{{ old('nom_prenom_pere') ?? 'Super Papa' }}" type="text" name="nom_prenom_pere" placeholder="Nom & Prenom du père" required="">
                                            @error('nom_prenom_pere')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="profession_pere">Profession</label>
                                            <input class="form-control" id="profession_pere" type="text" name="profession_pere" value="{{ old('profession_pere') ?? 'NEANT' }}" placeholder="Profession du père">
                                            @error('profession_pere')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="lieu_service_pere">Lieu de service</label>
                                            <input class="form-control" id="lieu_service_pere" type="text" name="lieu_service_pere" value="{{ old('lieu_service_pere') ?? 'NEANT' }}" placeholder="Lieu de service du père">
                                            @error('lieu_service_pere')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 mb-3">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="boite_postale_pere">Boite Postale</label>
                                            <input class="form-control" id="boite_postale_pere" type="text" name="boite_postale_pere" value="{{ old('boite_postale_pere') ?? 'NEANT' }}" placeholder="Boite postale du père">
                                            @error('boite_postale_pere')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="tel_service_pere">Tel. Service</label>
                                            <input class="form-control" id="tel_service_pere" type="number" name="tel_service_pere" value="{{ old('tel_service_pere') ?? 000000000 }}" placeholder="Tel. de service du père">
                                            @error('tel_service_pere')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="cel_pere">Cel.</label>
                                            <input class="form-control" id="cel_pere" type="number" name="cel_pere" value="{{ old('cel_pere') ?? 000000000 }}" placeholder="Cel. du père">
                                            @error('cel_pere')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 mb-3">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="email_pere">Email</label>
                                            <input class="form-control" id="email_pere" type="email" name="email_pere" value="{{ old('email_pere') ?? 'nean@nean.com' }}" placeholder="Email du père">
                                            @error('email_pere')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="lieu_habitation_pere">Lieu d'habitation</label>
                                            <input class="form-control" id="lieu_habitation_pere" value="{{ old('lieu_habitation_pere') ?? 'NEANT' }}" type="text" name="lieu_habitation_pere" placeholder="Lieu d'habitation du père">
                                            @error('lieu_habitation_pere')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="numero_appartement_pere">N° Appartement.</label>
                                            <input class="form-control" id="numero_appartement_pere" value="{{ old('numero_appartement_pere') ?? 'NEANT' }}" type="text" name="numero_appartement_pere" placeholder="Numero appartement du père">
                                            @error('numero_appartement_pere')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="tel_pere">Tel.</label>
                                            <input class="form-control" id="tel_pere" type="number" value="{{ old('tel_pere') ?? 000000000 }}" name="tel_pere" placeholder="Cel. du père">
                                            @error('tel_pere')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 mb-3">
                                    <h5 style="color: #24695c">Information sur la mère</h5>
                                </div>
                                <div class="row g-3 mb-3">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="nom_prenom_mere">Nom & Prénom <span style="color: red">*</span></label>
                                            <input class="form-control @error('nom_prenom_mere') is-invalid @enderror" id="nom_prenom_mere" type="text" value="{{ old('nom_prenom_mere') ?? 'Super Maman' }}" name="nom_prenom_mere" placeholder="Nom & Prenom de la mère" required="">
                                            @error('nom_prenom_mere')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="profession_mere">Profession</label>
                                            <input class="form-control" id="profession_mere" type="text" name="profession_mere" value="{{ old('profession_mere') ?? 'NEANT' }}" placeholder="Profession de la mère">
                                            @error('profession_mere')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="lieu_service_mere">Lieu de service</label>
                                            <input class="form-control" id="lieu_service_mere" type="text" name="lieu_service_mere" value="{{ old('lieu_service_mere') ?? 'NEANT' }}" placeholder="Lieu de service de la mère">
                                            @error('lieu_service_mere')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 mb-3">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="boite_postale_mere">Boite Postale</label>
                                            <input class="form-control" id="boite_postale_mere" type="text" name="boite_postale_mere" value="{{ old('boite_postale_mere') ?? 'NEANT' }}" placeholder="Boite postale de la mère">
                                            @error('boite_postale_mere')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="tel_service_mere">Tel. Service</label>
                                            <input class="form-control" id="tel_service_mere" type="number" name="tel_service_mere" value="{{ old('tel_service_mere') ?? 000000000 }}" placeholder="Tel. de service de la mère">
                                            @error('tel_service_mere')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="cel_mere">Cel.</label>
                                            <input class="form-control" id="cel_mere" type="number" value="{{ old('cel_mere') ?? 000000000 }}" name="cel_mere" placeholder="Cel. de la mère">
                                            @error('cel_mere')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 mb-3">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="email_mere">Email</label>
                                            <input class="form-control" id="email_mere" type="email" name="email_mere" value="nean@nean.com" placeholder="Email de la mère">
                                            @error('email_mere')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="lieu_habitation_mere">Lieu d'habitation</label>
                                            <input class="form-control" id="lieu_habitation_mere" type="text" name="lieu_habitation_mere" value="{{ old('lieu_habitation_mere') ?? 'NEANT' }}" placeholder="Lieu d'habitation de la mère">
                                            @error('lieu_habitation_mere')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="numero_appartement_mere">N° Appartement.</label>
                                            <input class="form-control" id="numero_appartement_mere" type="text" name="numero_appartement_mere" value="{{ old('numero_appartement_mere') ?? 'NEANT' }}" placeholder="Numero appartement de la mère">
                                            @error('numero_appartement_mere')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="tel_mere">Tel.</label>
                                            <input class="form-control" id="tel_mere" type="number" name="tel_mere" value="{{ old('tel_mere') ?? 000000000 }}"" placeholder="Cel. de la mère">
                                            @error('tel_mere')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 mb-3">
                                    <h5 style="color: #24695c">Cadre reservé aux étrangers</h5>
                                </div>
                                <div class="row g-3 mb-3">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="adresse_pays_origine">Adresse pays d'origine</label>
                                            <input class="form-control @error('adresse_pays_origine') is-invalid @enderror" value="{{ old('adresse_pays_origine') ?? 'NEANT' }}" id="adresse_pays_origine" type="text" name="adresse_pays_origine" placeholder="BP :">
                                            @error('adresse_pays_origine')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="tel_origine">Tel. à l'étranger</label>
                                            <input class="form-control" id="tel_origine" type="number" value="{{ old('tel_origine') ?? 000000000 }}" name="tel_origine" placeholder="Tel. à l'étranger" required="">
                                            @error('tel_origine')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="cel_origine">Cel. à l'étranger</label>
                                            <input class="form-control" id="cel_origine" type="number" value="{{ old('cel_origine') ?? 000000000 }}" name="cel_origine" placeholder="Cel. à l'étranger" required="">
                                            @error('cel_origine')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="f1-buttons">
                                    <button class="btn btn-primary btn-next" type="button">Next</button>
                                </div>
                            </fieldset>
                            <fieldset>
                                <div class="col-sm-12">
                                    <div class="card">
                                        <div class="card-header text-center">
                                            <h5>CURSUS ANTERIEUR PENDANT LES TROIS DERNIERES ANNEES</h5>
                                        </div>
                                        <div>
                                            <div class="card-block row">
                                                <div class="col-sm-12 col-lg-12 col-xl-12">
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered checkbox-td-width">
                                                            <tbody>
                                                                <tr>
                                                                    <td class="w-45"><h6 class="text-center">Ecole Fréquentées</h6></td>
                                                                    <td class="w-10"><h6 class="text-center">Années</h6></td>
                                                                    <td class="w-45"><h6 class="text-center">Formation suivies</h6></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <input class="form-control @error('ecole_1') is-invalid @enderror input-primary" name="ecole_1" type="text" value="{{ old('ecole_1') ?? 'Ecole Antérieure 1' }}" placeholder="Ecole" />
                                                                        @error('ecole_1')
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                        @enderror
                                                                    </td>
                                                                    <td>
                                                                        <input class="form-control @error('annee_1') is-invalid @enderror input-primary" type="number" min="1900" max="2099" step="1" value="{{ old('annee_1') ?? 2014 }}" value="2016" name="annee_1"  placeholder="Année" />
                                                                        @error('annee_1')
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                        @enderror
                                                                    </td>
                                                                    <td>
                                                                        <input class="form-control @error('formation_1') is-invalid @enderror input-primary" type="text" value="{{ old('formation_1') ?? 'Formation Antérieure 1' }}" name="formation_1" placeholder="Formation" />
                                                                        @error('formation_1')
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                        @enderror
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <input class="form-control @error('ecole_2') is-invalid @enderror input-primary" name="ecole_2" type="text" value="{{ old('ecole_2') ?? 'Ecole Antérieure 2' }}" placeholder="Ecole" />
                                                                        @error('ecole_2')
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                        @enderror
                                                                    </td>
                                                                    <td>
                                                                        <input class="form-control @error('annee_2') is-invalid @enderror input-primary" type="number" min="1900" max="2099" step="1" value="{{ old('annee_2') ?? 2015 }}" value="2016" name="annee_2"  placeholder="Année" />
                                                                        @error('annee_2')
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                        @enderror
                                                                    </td>
                                                                    <td>
                                                                        <input class="form-control @error('formation_2') is-invalid @enderror input-primary" type="text" value="{{ old('formation_2') ?? 'Formation Antérieure 2' }}" name="formation_2" placeholder="Formation" />
                                                                        @error('formation_2')
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                        @enderror
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <input class="form-control @error('ecole_3') is-invalid @enderror input-primary" name="ecole_3" type="text" value="{{ old('ecole_3') ?? 'Ecole Antérieure 3' }}" placeholder="Ecole" />
                                                                        @error('ecole_3')
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                        @enderror
                                                                    </td>
                                                                    <td>
                                                                        <input class="form-control @error('annee_3') is-invalid @enderror input-primary" type="number" min="1900" max="2099" step="1" value="{{ old('annee_3') ?? 2016 }}" value="2016" name="annee_3"  placeholder="Année" />
                                                                        @error('annee_3')
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                        @enderror
                                                                    </td>
                                                                    <td>
                                                                        <input class="form-control @error('formation_3') is-invalid @enderror input-primary" type="text" value="{{ old('formation_3') ?? 'Formation Antérieure 3' }}" name="formation_3" placeholder="Formation" />
                                                                        @error('formation_3')
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                        @enderror
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <label class="form-label col-md-6 m-t-10 m-l-10 mb-0" for="maladie"><h6>Souffrez vous d'une maladie qui entraine des crises ?</h6></label>
                                                <div class="col-md-4 mb-3">
                                                    <div class="form-group m-t-10 m-checkbox-inline mb-0 custom-radio-ml">
                                                        <div class="radio radio-primary">
                                                            <input class="radio_animated" id="oui" type="radio" name="maladie" value="oui">
                                                            <label class="mb-0" for="oui">Oui</label>
                                                        </div>
                                                        <div class="radio radio-primary">
                                                            <input class="radio_animated" id="non" type="radio" name="maladie" value="non" checked>
                                                            <label class="mb-0" for="non">Non</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <label class="form-label col-md-6 m-t-10 m-l-10 mb-0"><h6>Si oui, précisez laquelle</h6></label>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <input class="form-control @error('precision_maladie') is-invalid @enderror" value="{{ old('precision_maladie') ?? 'NEANT' }}" id="precision_maladie" type="text" name="precision_maladie" placeholder="Maladie">
                                                        @error('precision_maladie')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row g-3 m-l-10 mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="nom_medecin">Nom médecin trantant</label>
                                                        <input class="form-control @error('nom_medecin') is-invalid @enderror" value="{{ old('nom_medecin') ?? 'NEANT' }}" id="nom_medecin" type="text" name="nom_medecin" placeholder="Nom médecin">
                                                        @error('nom_medecin')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="tel_medecin">Numéro médecin</label>
                                                        <input class="form-control" id="tel_medecin" type="number" value="{{ old('tel_medecin') ?? 000000000 }}" name="tel_medecin" placeholder="Tel. médecin">
                                                        @error('tel_medecin')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row g-3 m-l-10 mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="nom_cas_urgent">Nom personne à contacter en cas d'urgence</label>
                                                        <input class="form-control @error('nom_cas_urgent') is-invalid @enderror" value="{{ old('nom_cas_urgent') ?? 'NEANT' }}" id="nom_cas_urgent" type="text" name="nom_cas_urgent" placeholder="Nom d'urgene">
                                                        @error('nom_cas_urgent')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="tel_cas_urgent">Numéro de la personne</label>
                                                        <input class="form-control" id="tel_cas_urgent" type="number" value="{{ old('tel_cas_urgent') ?? 000000000 }}" name="tel_cas_urgent" placeholder="Tel. médecin">
                                                        @error('tel_cas_urgent')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="f1-buttons">
                                    <button class="btn btn-primary btn-previous" type="button">Previous</button>
                                    <button class="btn btn-primary btn-next" type="button">Next</button>
                                </div>
                            </fieldset>
                            <fieldset>
                                <div class="card">
                                    <div class="card-header pb-0">
                                        <h5>Charger les fichiers</h5>
                                        <span>
                                            Not interested in custom validation feedback messages or writing JavaScript to change form behaviors? All good, you can use the browser defaults. Try submitting the form below. Depending on your browser and OS,
                                            you’ll see a slightly different style of feedback.
                                        </span>
                                        <span>While these feedback styles cannot be styled with CSS, you can still customize the feedback text through JavaScript.</span>
                                    </div>
                                    <div class="card-body">
                                        <label>Extrait de naissance</label>
                                        <div class="mb-3">
                                            <input class="form-control" type="file" name="extrait_naissance" aria-label="file example"/>
                                            @error('extrait_naissance')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <label>Photocopie légalisée du BAC</label>
                                        <div class="mb-3">
                                            <input class="form-control" type="file" name="bac_legalise" aria-label="file example"/>
                                            @error('bac_legalise')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <label>Photocopie des bulletins</label>
                                        <div class="mb-3">
                                            <input class="form-control" type="file" name="photocopie_bulletin" aria-label="file example"/>
                                            @error('photocopie_bulletin')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <label>Photocopie BTS</label>
                                        <div class="mb-3">
                                            <input class="form-control" type="file" name="photocopie_bts" aria-label="file example"/>
                                            @error('photocopie_bts')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <label>Photocopie autre diplôme</label>
                                        <div class="mb-3">
                                            <input class="form-control" type="file" name="autre_diplome" aria-label="file example"/>
                                            @error('autre_diplome')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <label>Actions</label>
                                        <div class="mb-3">
                                            <select class="form-select @error('soumettre') is-invalid @enderror text-center" name="soumettre">
                                                <option selected value="0">Enrégistrer et quitter</option>
                                                <option value="1">Soumettre le formulaire d'inscription</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="f1-buttons">
                                    <button class="btn btn-primary btn-previous" type="button">Précédant</button>
                                    <button class="btn btn-primary btn-submit" type="submit">Valider</button>
                                </div>
                            </fieldset>
                        </form>
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
                    <p>Les informations ont été enrégistrées et sont en attente de validation. </p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
	<script src="{{ asset('assets/js/form-validation-custom.js') }}"></script>
    <script src="{{asset('assets/js/form-wizard/form-wizard-three.js')}}"></script>
    <script src="{{asset('assets/js/form-wizard/jquery.backstretch.min.js')}}"></script>
    @if (Session('success'))
            <script>
                $(function() {
                    $('#exampleModalCenter').modal('show');
                });
            </script>
        @endif
    @endpush

@endsection
