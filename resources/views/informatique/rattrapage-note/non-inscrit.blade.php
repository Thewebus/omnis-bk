@extends('layouts.informatique.master')

@section('title')Note Rattrapage Non inscrit
 {{ $title }}
@endsection

@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/select2.css') }}">
@endpush

@section('content')
	@component('components.informatique.breadcrumb')
		@slot('breadcrumb_title')
			<h3>Note Rattrapage Non inscrit</h3>
		@endslot
		<li class="breadcrumb-item">Rattrapage</li>
		{{-- <li class="breadcrumb-item">Data Tables</li> --}}
		<li class="breadcrumb-item active">Note Rattrapage Non inscrit</li>
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
                    <form class="form theme-form" action="{{ route('admin.rattrapage.store-non-inscrit') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Nom Etudiant</label>
                                    <div class="col-sm-9">
                                        <input class="form-control @error('nom_prenom') is-invalid @enderror" type="text" name="nom_prenom" value="{{ old("nom_prenom") }}" placeholder="Nom & Prenoms" />
                                        @error('nom_prenom')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Matière</label>
                                    <div class="col-sm-9">
                                        <select class="js-example-basic-single col-sm-12 @error('matiere') is-invalid @enderror" id="matiere" name="matiere">
                                            <option value="">Choisir la matière</option>
                                            @foreach ($matieres as $matiere)
                                                <option value="{{ $matiere->id }}" {{ old('matiere') == $matiere->id ? 'selected' : '' }} >{{ $matiere->nom }} | {{ $matiere->classe->nom ?? 'pas de classe' }}</option>
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
                                    <label class="col-sm-3 col-form-label">Note</label>
                                    <div class="col-sm-9">
                                        <input class="form-control @error('note') is-invalid @enderror" type="number" name="note" value="{{ old("note") }}" step="0.01" min="0" max="20" onchange="checkMaxNote(this.value)" placeholder="note matière" />
                                        @error('note')
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

	<script>
		function checkMaxNote(value) {
			console.log('changement !!!! ' + value)
			if (value < 0) {
				Swal.fire({
					icon: 'error',
					title: 'Alert',
					text: 'La note saisie ne doit pas être inférieure à 0',
				})
			}
			else if(value > 20) {
				Swal.fire({
					icon: 'error',
					title: 'Alert',
					text: 'La note saisie ne doit pas être supérieure à 20',
				})
			}
			else {
				console.log('Tout est OK');
			}
		}
	</script>
	@endpush

@endsection