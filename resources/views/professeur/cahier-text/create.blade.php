@extends('layouts.professeur.master')

@section('title')Nouvel ajout
 {{ $title }}
@endsection

@push('css')
@endpush

@section('content')
	@component('components.breadcrumb')
		@slot('breadcrumb_title')
			<h3>Nouvel ajout</h3>
		@endslot
		<li class="breadcrumb-item">Cahier de texte</li>
		{{-- <li class="breadcrumb-item">Data Tables</li> --}}
		<li class="breadcrumb-item active">Nouvel ajouter</li>
	@endcomponent
	
	<div class="container-fluid">
	    <div class="row">
	        <div class="col-sm-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <h5>Remplir les champs</h5>
                    </div>
                    <form class="form theme-form" action="{{ route('prof.cahier-texte-store') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">Matière</label>
                                        <div class="col-sm-9">
                                            <input type="hidden" name="classe" value="{{ $classe->id }}">
                                            <select class="form-select digits @error('matiere') is-invalid @enderror" id="matiere" name="matiere" >
                                                <option selected value="">Choisir une matière</option>
                                                @foreach (Auth::user()->matieres->where('classe_id', $classe->id) as $matiere)
                                                    <option value="{{ $matiere->id }}">{{ $matiere->nom }}</option>
                                                @endforeach
                                            </select>
                                            @error('matiere')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">Date</label>
                                        <div class="col-xl-5 col-sm-7 col-lg-8">
                                            <input class="form-control datetimepicker-input digits" name="date" id="dt-noicon" type="text" value="{{ old('date') }}" placeholder="Date" data-toggle="datetimepicker" data-target="#dt-noicon">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">Durée (Heure)</label>
                                        <div class="col-sm-9">
                                            <input class="form-control @error('duree') is-invalid @enderror" type="number" name="duree" value="{{ old("duree") }}" placeholder="Durée du cours" />
                                            @error('duree')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">Contenu</label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control @error('contenu') is-invalid @enderror" name="contenu" rows="5" cols="5" placeholder="contenu">{{ old('contenu') }}</textarea>
                                            @error('contenu')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-sm-3 col-form-label">Bibliographie</label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control @error('bibliographie') is-invalid @enderror" name="bibliographie" rows="5" cols="5" placeholder="Bibliographie">{{ old('bibliographie') }}</textarea>
                                            @error('bibliographie')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
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
    <script src="{{ asset('assets/js/datepicker/date-time-picker/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/datepicker/date-time-picker/tempusdominus-bootstrap-4.min.js') }}"></script>
    <script src="{{ asset('assets/js/datepicker/date-time-picker/datetimepicker.custom.js') }}"></script>
	@endpush

@endsection