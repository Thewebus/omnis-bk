@extends('layouts.informatique.master')

@section('title')Affectations etudiant
    {{ $title }}
@endsection

@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/select2.css') }}">
@endpush

@section('content')
	@component('components.informatique.breadcrumb')
		@slot('breadcrumb_title')
			<h3>Affectations etudiant</b></h3>
		@endslot
		<li class="breadcrumb-item">Etudiants</li>
		{{-- <li class="breadcrumb-item">Data Tables</li> --}}
		<li class="breadcrumb-item active">Affectations</b></li>
	@endcomponent
	
	<div class="container-fluid">
	    <div class="row">
	        <!-- Feature Unable /Disable Order Starts-->
	        <div class="col-sm-12">
	            <div class="card">
	                <div class="card-header">
	                    <h5>Affectations étudiants</b></h5>
	                    {{-- <span>Disabling features that you don't wish to use for a particular table is easily done by setting a variable in the initialisation object</span>
	                    <span>In the following example only the search feature is left enabled (which it is by default).</span> --}}
	                </div>
	                <div class="card-body">
						@if (session('error'))
							<div class="alert alert-danger text-center" role="alert">
								{{ session('error') }}
							</div>
						@endif
						<form action="{{ route('admin.post-affectation-etudiant') }}" method="post">
							@csrf
							<div class="mb-3 row">
								<label class="col-sm-3 col-form-label">Classe</label>
								<div class="col-sm-9">
									<select class="form-select digits @error('classe') is-invalid @enderror" name="classe">
											<option value="">Choisir la classe</option>
											@foreach ($classes as $classe)
												<option value="{{ $classe->id }}" {{ old('classe') == $classe->id ? 'selected' : '' }}>{{ $classe->nom }}</option>
											@endforeach
									</select>
									@error('classe')
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
									@enderror
								</div>
							</div>
							<div class="row mb-2">
								<label class="col-sm-3 col-form-label">Selection Etudiants</label>
								<div class="col-sm-9">
									<select name="etudiants[]" class="js-example-basic-multiple col-sm-12 @error('etudiants[]') is-invalid @enderror" multiple="multiple">
										@foreach ($etudiants as $etudiant)
											@if (is_null($etudiant->inscriptions->where('annee_academique_id', $anneeAcademique->id)->first()->classe))
												<option value="{{ $etudiant->id }}">{{ $etudiant->fullname }} | {{ $etudiant->classe->nom ?? 'Pas de classe' }}</option>
											@endif
										@endforeach
									</select>
									@error('etudiants[]')
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
									@enderror
								</div>
                            </div>
							<div class="row mb-2">
								<label class="col-sm-3 col-form-label"></label>
								<div class="col-sm-9">
									<button style="width: 50%" class="btn btn-block btn-primary">Affecter</button>
								</div>
							</div>
						</form>
	                </div>
	            </div>
	        </div>
	        <!-- Feature Unable /Disable Ends-->
	    </div>
	</div>

	
	@push('scripts')
    <script src="{{ asset('assets/js/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/js/select2/select2-custom.js') }}"></script>
	@endpush

@endsection