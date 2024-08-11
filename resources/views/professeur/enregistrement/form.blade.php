@extends('layouts.professeur.master')

@section('title')Enregistrement
 {{ ($title) }}
@endsection

@push('css')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/scrollable.css')}}">
@endpush

@section('content')
	@component('components.breadcrumb')
		@slot('breadcrumb_title')
			<h3>Inscritpion</h3>
		@endslot
		{{-- <li class="breadcrumb-item">Forms</li> --}}
		<li class="breadcrumb-item">Accueil</li>
		<li class="breadcrumb-item active">Enregistrement</li>
	@endcomponent
	
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <h5>Formulaire d'enregistrement</h5>
                        <span>
                            @if (Auth::user()->valide == 0 && Auth::user()->raison == null && Auth::user()->soumettre == 0)
                                Statut :<span class="badge badge-warning">Non soumis</span>
                            @elseif (Auth::user()->valide == 0 && Auth::user()->raison == null && Auth::user()->soumettre == 1)
                                Statut :<span class="badge badge-warning">En attente</span>
                            @elseif (Auth::user()->valide == 0 && Auth::user()->raison !== null && Auth::user()->soumettre == 1)
                                Statut : <span class="badge badge-danger">Refusé</span><br>
                                <div class="alert alert-warning dark mt-3" role="alert">
                                    <p>Motif : {{ Auth::user()->raison }}</p>
                                </div>
                            @else
                                Statut : <span class="badge badge-success">Validé</span>
                            @endif
                        </span>
                    </div>
                    <div class="card-body">
                        <form class="f1" action="{{ route('prof.post-enregistrement') }}" enctype="multipart/form-data" method="post">
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
                                    <p>Statut</p>
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
                                            <label for="nom_prenom">Nom & Prénom <span style="color: red">*</span></label>
                                            <input class="form-control @error('nom_prenom') is-invalid @enderror" id="nom_prenom" type="text" value="{{ old('nom_prenom') ?? Auth()->user()->fullname }}" name="nom_prenom" placeholder="Nom & Prénom" required>
                                            @error('nom_prenom')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="numero">Numero <span style="color: red">*</span></label>
                                            <input class="form-control @error('numero') is-invalid @enderror" id="numero" type="number" value="{{ old('numero') ?? (Auth::user()->numero ?? 0102030405) }}" name="numero" placeholder="Numéro" required>
                                            @error('numero')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 mb-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">Email <span style="color: red">*</span></label>
                                            <input class="form-control @error('email') is-invalid @enderror" id="email" type="text" value="{{ old('email') ?? Auth()->user()->email }}" name="email" placeholder="Email" required>
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="postale">Adresse postal</label>
                                            <input class="form-control @error('postale') is-invalid @enderror" id="postale" type="text" value="{{ old('postale') ?? (Auth::user()->postale ?? 'AB 01 BP 06') }}" name="postale" placeholder="Adresse postale" required>
                                            @error('postale')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 mb-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="date_naissance">Date de naissance <span style="color: red">*</span></label>
                                            <input class="form-control @error('date_naissance') is-invalid @enderror" id="date_naissance" type="date" value="{{ old('date_naissance') ?? (Auth::user()->date_naissance ?? '1980-02-25') }}" name="date_naissance" placeholder="Date de naissance" required>
                                            @error('date_naissance')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="profession">Profession <span style="color: red">*</span></label>
                                            <input class="form-control @error('profession') is-invalid @enderror" id="profession" type="text" value="{{ old('profession') ?? (Auth::user()->profession ?? 'Interimaire') }}" name="profession" placeholder="Profession" required>
                                            @error('profession')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="f1-buttons">
                                    <button class="btn btn-primary btn-next" type="button">Suivant</button>
                                </div>
                            </fieldset>
                            <fieldset>
                                <div class="row g-3 mb-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="statut">Statut <span style="color: red">*</span></label>
                                            <select class="form-select @error('statut') is-invalid @enderror text-center" name="statut">
                                                <option value="fonctionnaire" {{ (old('statut') ?? Auth::user()->statut) == 'fonctionnaire' ? 'selected' : '' }}>Fonctionnaire</option>
                                                <option value="salarié" {{ (old('statut') ?? Auth::user()->statut) == 'salarié' ? 'selected' : '' }}>Salarié</option>
                                            </select>
                                            @error('statut')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="anciennete"> Année Ancienneté (en année) <span style="color: red">*</span></label>
                                            <input class="form-control @error('anciennete') is-invalid @enderror" id="anciennete" type="number" value="{{ old('anciennete') ?? (Auth::user()->anciennete ?? 5) }}" name="anciennete" placeholder="Année d'ancienneté" required>
                                            @error('anciennete')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 mb-3">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="numero_cnps">Numero CNPS (Si fonctionnaire)</label>
                                            <input class="form-control" id="numero_cnps" type="text" value="{{ old('numero_cnps') ?? (Auth::user()->cnps ?? 'A45C10') }}" name="numero_cnps" placeholder="Numéro" required>
                                            @error('numero_cnps')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="g-3 mb-3">
                                    <h5 style="color: #24695c">Modules enseignés</h5>
                                </div>
                                <div class="row g-3 mb-3">
                                    @foreach ($facultes as $faculte)
                                        @if ($faculte->matieres()->count() > 0)
                                            <div class="col-md-4">
                                                <h6>{{ $faculte->nom }}</h6>
                                                <div class="vertical-scroll scroll-demo">
                                                    <div class="animate-chk">
                                                        <div class="row">
                                                            <div class="col">
                                                                <div class="form-group m-t-15">
                                                                    @foreach ($faculte->matieres() as $matiere)
                                                                        <div class="checkbox checkbox-primary">
                                                                            <input id="{{ $matiere->id }}" value="{{ $matiere->nom }}"
                                                                                {{ old('matieres') ? (in_array($matiere->nom, old('matieres')) ? 'checked' : '') : (Auth::user()->modules_enseignes ? (in_array($matiere->nom, Auth::user()->modules_enseignes) ? 'checked' : '') : '') }} 
                                                                                type="checkbox" name="matieres[]"
                                                                            >
                                                                            <label for="{{ $matiere->id }}">{{ $matiere->nom }}</label>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                                <div class="f1-buttons">
                                    <button class="btn btn-primary btn-previous" type="button">Précédent</button>
                                    <button class="btn btn-primary btn-next" type="button">Suivant</button>
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
                                        <label>CNI/CC/Passeport</label>
                                        <div class="mb-3">
                                            <input class="form-control @error('piece_indentite') is-invalid @enderror" type="file" name="piece_indentite" aria-label="file example"/>
                                            @error('piece_indentite')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <label>CV</label>
                                        <div class="mb-3">
                                            <input class="form-control @error('cv') is-invalid @enderror" type="file" name="cv" aria-label="file example"/>
                                            @error('cv')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <label>Diplômes</label>
                                        <div class="mb-3">
                                            <input class="form-control @error('diplomes') is-invalid @enderror" type="file" name="diplomes" aria-label="file example"/>
                                            @error('diplomes')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <label>Autorisation d'enseigner</label>
                                        <div class="mb-3">
                                            <input class="form-control @error('autorisation_enseigner') is-invalid @enderror" type="file" name="autorisation_enseigner" aria-label="file example"/>
                                            @error('autorisation_enseigner')
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
                                    <button class="btn btn-primary btn-submit" {{ Auth::user()->valide == 1 ? 'disabled' : '' }} type="submit">Valider</button>
                                </div>
                            </fieldset>
                        </form>
                      </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Vertically centered modal-->
    <div class="modal fade" id="enregistrerModel" tabindex="-1" role="dialog" aria-labelledby="enregistrerModel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Informations enrégistrées</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Les informations ont été enrégistrées mais pas soumis.</p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="soumettreModal" tabindex="-1" role="dialog" aria-labelledby="soumettreModal" aria-hidden="true">
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
    <script src="{{asset('assets/js/scrollable/perfect-scrollbar.min.js')}}"></script>
    <script src="{{asset('assets/js/scrollable/scrollable-custom.js')}}"></script>
    <script src="{{asset('assets/js/tooltip-init.js')}}"></script>
    @if (Session('success') == 'success')
            <script>
                $(function() {
                    $('#soumettreModal').modal('show');
                });
            </script>            
        @endif

        @if (Session('success') == 'fail' )
            <script>
                $(function() {
                    $('#enregistrerModel').modal('show');
                });
            </script>
        @endif
    @endpush

@endsection
