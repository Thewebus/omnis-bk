@extends('layouts.informatique.master')

@section('title')Liste cours
 {{ $title }}
@endsection
@push('css')
@livewireStyles
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/select2.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/timepicker.css') }}">
@endpush

@section('content')
    @component('components.breadcrumb')
		@slot('breadcrumb_title')
			<h3>Emploi du temps</h3>
		@endslot
		{{-- <li class="breadcrumb-item">Forms</li>
		<li class="breadcrumb-item">Form Controls</li> --}}
        <li class="breadcrumb-item active">Liste des cours</li>
	@endcomponent
	
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-12">
				<div class="card">
					<div class="card-header pb-0">
						<h5>Emploi du temps</h5>
						{{-- <span>
							For custom Bootstrap form validation messages, you’ll need to add the <code class="text-danger">novalidate</code> boolean attribute to your <code class="text-danger">&lt;form&gt;</code>. This disables the browser
							default feedback tooltips, but still provides access to the form validation APIs in JavaScript. Try to submit the form below; our JavaScript will intercept the submit button and relay feedback to you.
						</span>
						<span>When attempting to submit, you’ll see the <code class="text-danger">:invalid </code> and <code class="text-danger">:valid </code> styles applied to your form controls.</span> --}}
					</div>
					<div class="col-md-8 offset-2">
						<form class="form theme-form" action="{{ route('admin.emploi-du-temps.store') }}" method="POST">
							@csrf
							<div class="card-body">
								<div class="row">
									<div class="col">
										<div class="mb-3 row">
											<label class="col-sm-3 col-form-label">Jour</label>
											<div class="col-sm-9">
												<input type="hidden" name="classe" value="{{ $classe->id }}">
												<select class="form-select" name="jour" aria-label="Default select example" >
													<option value="1" selected>Lundi</option>
													<option value="2">Mardi</option>
													<option value="3">Mercredi</option>
													<option value="4">Jeudi</option>
													<option value="5">Vendredi</option>
													<option value="6">Samedi</option>
													<option value="7">Dimanche</option>
												</select>                                            
												@error('jour')
													<span class="invalid-feedback" role="alert">
														<strong>{{ $message }}</strong>
													</span>
												@enderror
											</div>
										</div>
										<div class="mb-3 row">
											<label class="col-sm-3 col-form-label">Matière</label>
											<div class="col-sm-9">
												<select class="form-select" id="validationCustom04" name="matiere">
													@foreach ($classe->niveauFaculte->matieres as $matiere)
														<option value="{{ $matiere->id }}" {{ old('matiere') == $matiere->id ? 'selected' : '' }}>{{ $matiere->nom }}</option>
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
											<label class="col-sm-3 col-form-label">Salle</label>
											<div class="col-sm-9">
												<select class="form-select" id="validationCustom04" name="salle">
													@foreach ($salles as $salle)
														<option value="{{ $salle->id }}" {{ old('salle') == $salle->id ? 'selected' : '' }}>{{ $salle->nom }}</option>
													@endforeach
												</select>                                              
												@error('salle')
													<span class="invalid-feedback" role="alert">
														<strong>{{ $message }}</strong>
													</span>
												@enderror
											</div>
										</div>
										<div class="mb-3 row clockpicker">
											<label class="col-sm-3 col-form-label">Heure Debut</label>
											<div class="col-sm-9">
												<input class="form-control @error('heure_debut') is-invalid @enderror" value="{{ old('heure_debut') ?? '08:00'}}" type="text"  name="heure_debut" /><span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
												@error('heure_debut')
													<span class="invalid-feedback" role="alert">
														<strong>{{ $message }}</strong>
													</span>
												@enderror
											</div>
										</div>
										<div class="mb-3 row clockpicker">
											<label class="col-sm-3 col-form-label">Heure Fin</label>
											<div class="col-sm-9">
												<input class="form-control @error('heure_fin') is-invalid @enderror" type="text"  value="{{ old('heure_fin') ?? '10:00'}}" name="heure_fin"/><span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
												@error('heure_fin')
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
	</div>
	
	
	@push('scripts')
	<script src="{{ asset('assets/js/form-validation-custom.js') }}"></script>
    <script src="{{ asset('assets/js/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/js/select2/select2-custom.js') }}"></script>
    <script src="{{ asset('assets/js/time-picker/jquery-clockpicker.min.js') }}"></script>
    <script src="{{ asset('assets/js/time-picker/highlight.min.js') }}"></script>
    <script src="{{ asset('assets/js/time-picker/clockpicker.js') }}"></script>
    @livewireScripts
	@endpush

@endsection