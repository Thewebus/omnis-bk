@extends('layouts.informatique.master')

@section('title')Formulaire d'Inscription d'etudiants existant
 {{ ($title) }}
@endsection

@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/select2.css') }}">
{{-- @livewireStyles --}}
@endpush

@section('content')
    @component('components.informatique.breadcrumb')
        @slot('breadcrumb_title')
        <h3>Formulaire d'Inscription d'etudiants existant</h3>
        @endslot
        <li class="breadcrumb-item active">Formulaire d'Inscription d'etudiants existant</li>
        {{-- <li class="breadcrumb-item active">Sample Page</li> --}}
    @endcomponent

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <h5>Formulaire d'inscription d'etudiants existant</h5>
                        {{-- <span>Veuillez remplir le formulaire suivant pour poursuivre votre</span> --}}
                    </div>
                    <div class="card-body">
                        {{-- <div class="float-end">
                            <a href="{{ route('admin.etudiant-import') }}" class="btn btn-primary"><i class="fa fa-download"></i> Importer</a>
                        </div> --}}
                        <form class="form theme-form" action="{{ route('admin.inscription-etudiant-existant-post') }}" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">Etudiant</label>
                                        <div class="col-sm-9">
                                            <select class="js-example-basic-single col-sm-12 @error('etudiant') is-invalid @enderror" id="etudiant" name="etudiant">
                                                <option value="">Choisir l'étudiant</option>
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
                                        <label class="col-sm-3 col-form-label">Classe</label>
                                        <div class="col-sm-9">
                                            <select class="js-example-basic-single col-sm-12 @error('classe') is-invalid @enderror" id="classe" name="classe">
                                                <option value="">Choisir la classe</option>
                                                @foreach ($classes as $classe)
                                                    <option {{ old("classe") == $classe->id ? 'selected' : '' }} value="{{ $classe->id }}">{{ $classe->nom }} | {{ $classe->code }}</option>
                                                @endforeach
                                            </select>
                                            @error('classe')
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
    </div>

    @push('scripts')
        {{-- @livewireScripts --}}
        <script src="{{ asset('assets/js/select2/select2.full.min.js') }}"></script>
        <script src="{{ asset('assets/js/select2/select2-custom.js') }}"></script>
    @endpush
@endsection
