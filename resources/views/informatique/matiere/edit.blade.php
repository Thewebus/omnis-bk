@extends('layouts.informatique.master')

@section('title')Modification matière
 {{ $title }}
@endsection

@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/select2.css') }}">
@endpush

@section('content')
	@component('components.informatique.breadcrumb')
		@slot('breadcrumb_title')
			<h3>Modification matière</h3>
		@endslot
		<li class="breadcrumb-item"><a href="{{ route('admin.matiere.index') }}">matières</a></li>
		{{-- <li class="breadcrumb-item">Data Tables</li> --}}
		<li class="breadcrumb-item active">Modification Classe</li>
	@endcomponent
	
	<div class="container-fluid">
	    <div class="row">
	        <div class="col-sm-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <h5>Modifiez les informations</h5>
                    </div>
                    <form class="form theme-form" action="{{ route('admin.matiere.update', $matiere) }}" method="POST">
                        @method('PUT')
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Unité d'Enseignement</label>
                                    <div class="col-sm-9">
                                        <select class="js-example-basic-single col-sm-12 @error('unite_enseignement') is-invalid @enderror" id="unite_enseignement" name="unite_enseignement">
                                            <option value="">Choisir l'Unité d'Enseignement</option>
                                            @foreach ($uniteEnseignements as $uniteEnseignement)
                                                <option value="{{ $uniteEnseignement->id }}" {{ (old('unite_enseignement') ?? ($matiere->uniteEnseignement ? $matiere->uniteEnseignement->id : '')) == $uniteEnseignement->id ? 'selected' : '' }} >{{ $uniteEnseignement->nom }}</option>
                                            @endforeach
                                        </select>
                                        @error('unite_enseignement')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Classe</label>
                                    <div class="col-sm-9">
                                        <select class="js-example-basic-single col-sm-12 @error('classe') is-invalid @enderror" id="classe" name="classe">
                                            <option value="">Choisir la classe</option>
                                            @foreach ($classes as $classe)
                                                <option {{ (old("classe") ?? ($matiere->classe ? $matiere->classe->id : '')) == $classe->id ? 'selected' : '' }} value="{{ $classe->id }}">{{ $classe->nom }}</option>
                                            @endforeach
                                        </select>
                                        @error('classe')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Professeur</label>
                                    <div class="col-sm-9">
                                        <select class="js-example-basic-single col-sm-12 @error('professeur') is-invalid @enderror" id="professeur" name="professeur">
                                            <option value="">Choisir le professeur</option>
                                            @foreach ($profs as $prof)
                                                <option value="{{ $prof->id }}" {{ (old('professeur') ?? ($professeur ? $professeur->id : '')) == $prof->id ? 'selected' : '' }} >{{ $prof->fullname }}</option>
                                            @endforeach
                                        </select>
                                        @error('professeur')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Numero d'orde</label>
                                    <div class="col-sm-9">
                                        <input class="form-control @error('numero_ordre') is-invalid @enderror" type="number" name="numero_ordre" value="{{ old("numero_ordre") ?? $matiere->numero_ordre }}" placeholder="numero ordre matière" />
                                        @error('numero_ordre')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Nom</label>
                                    <div class="col-sm-9">
                                        <input class="form-control @error('nom') is-invalid @enderror" type="text" name="nom" value="{{ old("nom") ?? $matiere->nom }}" placeholder="Nom matière" />
                                        @error('nom')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Semestre</label>
                                    <div class="col-sm-9">
                                        <select class="form-select digits @error('semestre') is-invalid @enderror" id="semestre" name="semestre">
                                            <option value="">Choisir le semestre</option>
                                            <option {{ (old("semestre") ?? $matiere->semestre) ==  '1' ? 'selected' : '' }} value="1">Semestre 1</option>
                                            <option {{ (old("semestre") ?? $matiere->semestre) ==  '2' ? 'selected' : '' }} value="2">Semestre 2</option>
                                        </select>
                                        @error('semestre')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Coefficient</label>
                                    <div class="col-sm-9">
                                        <input class="form-control @error('coefficient') is-invalid @enderror" type="number" name="coefficient" value="{{ old("coefficient") ?? $matiere->coefficient }}" placeholder="Coefficient matière" />
                                        @error('coefficient')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Credit</label>
                                    <div class="col-sm-9">
                                        <input class="form-control @error('credit') is-invalid @enderror" type="number" name="credit" value="{{ old("credit") ?? $matiere->credit }}" placeholder="credit matière" />
                                        @error('credit')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Volume Horaire</label>
                                    <div class="col-sm-9">
                                        <input class="form-control @error('volume_horaire') is-invalid @enderror" type="number" name="volume_horaire" value="{{ old("volume_horaire") ?? $matiere->volume_horaire }}" placeholder="Volume horaire" />
                                        @error('volume_horaire')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-sm-3 col-form-label">Description</label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="5" cols="5" placeholder="Description matière">{{ old('description') ?? $matiere->description }}</textarea>
                                        @error('description')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                {{-- <livewire:matiere-niveau :matiere="$matiere" /> --}}
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <div class="col-sm-9 offset-sm-3">
                                <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i> Enregistrer</button>
                            </div>
                        </div>
                    </form>
                </div>
	        </div>
	    </div>
	</div>

	
	@push('scripts')
    <script src="{{ asset('assets/js/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/js/select2/select2-custom.js') }}"></script>
	@endpush

@endsection