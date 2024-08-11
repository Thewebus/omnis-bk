@extends('layouts.informatique.master')

@section('title')Attestation d'admission
 {{ $title }}
@endsection

@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/select2.css') }}">
{{-- @livewireStyles --}}
@endpush

@section('content')
	@component('components.informatique.breadcrumb')
		@slot('breadcrumb_title')
			<h3>Attestation d'admission</h3>
		@endslot
		<li class="breadcrumb-item">Attestation d'admission</li>
		{{-- <li class="breadcrumb-item">Data Tables</li> --}}
		<li class="breadcrumb-item active">nouvelle attestation</li>
	@endcomponent
	
	<div class="container-fluid">
	    <div class="row">
	        <div class="col-sm-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="row">
                            <div class="col-md-6">
                                <h5>Entrez les informations</h5>
                            </div>
                            {{-- <div class="col-md-6">
                                <a href="{{ route('admin.import-matiere') }}" class="btn btn-success"><i class="fa fa-import"></i> Importer des matières</a>
                            </div> --}}
                        </div>
                    </div>
                    <form class="form theme-form" action="{{ route('admin.attestation-admission-pdf') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Année Universitaire</label>
                                    <div class="col-sm-9">
                                        <select class="form-select digits @error('annee_universitaire') is-invalid @enderror" id="annee_universitaire" name="annee_universitaire">
                                            <option value="">Choisir l'annee universitaire</option>
                                            @foreach ($anneeAcademiques as $anneeAcademique)
                                                <option {{ old("annee_universitaire") ==  $anneeAcademique->id ? 'selected' : '' }} value="{{ $anneeAcademique->id }}">{{ $anneeAcademique->debut . ' - ' . $anneeAcademique->fin }}</option>
                                            @endforeach
                                        </select>
                                        @error('annee_universitaire')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Etudiant</label>
                                    <div class="col-sm-9">
                                        <select class="js-example-basic-single col-sm-12 @error('etudiant') is-invalid @enderror" id="etudiant" name="etudiant">
                                            <option value="">Choisir l'etudiant</option>
                                            @foreach ($etudiants as $etudiant)
                                                <option value="{{ $etudiant->id }}" {{ old('etudiant') == $etudiant->id ? 'selected' : '' }} >{{ $etudiant->fullname }}</option>
                                            @endforeach
                                        </select>
                                        @error('etudiant')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Session</label>
                                    <div class="col-sm-9">
                                        <select class="form-select digits @error('session') is-invalid @enderror" id="session" name="session">
                                            <option value="">Choisir la session</option>
                                            @foreach ($sessions as $session)
                                                <option {{ old("session") ==  $session ? 'selected' : '' }} value="{{ $session }}">{{ $session }}</option>
                                            @endforeach
                                        </select>
                                        @error('session')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Annee</label>
                                    <div class="col-sm-9">
                                        <input class="form-control @error('annee') is-invalid @enderror" type="number" name="annee" value="{{ old("annee") }}" placeholder="Année" />
                                        @error('annee')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Mention</label>
                                    <div class="col-sm-9">
                                        <select class="form-select digits @error('mention') is-invalid @enderror" id="mention" name="mention">
                                            <option value="">Choisir la mention</option>
                                            @foreach ($mentions as $mention)
                                                <option {{ old("mention") ==  $mention ? 'selected' : '' }} value="{{ $mention }}">{{ $mention }}</option>
                                            @endforeach
                                        </select>
                                        @error('mention')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Pr. conseil Scientifique</label>
                                    <div class="col-sm-9">
                                        <input class="form-control @error('president') is-invalid @enderror" type="text" name="president" value="{{ old("president") ?? 'Prof. HAUHOUOT Asseypo Antoine' }}" placeholder="Président" />
                                        @error('president')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
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
    {{-- @livewireScripts --}}
	@endpush

@endsection