@extends('layouts.professeur.master')

@section('title')Nouvelles ressources
 {{ $title }}
@endsection

@push('css')
@endpush

@section('content')
	@component('components.professeur.breadcrumb')
		@slot('breadcrumb_title')
			<h3>Nouvelles ressources</h3>
		@endslot
		{{-- <li class="breadcrumb-item">Apps</li> --}}
		<li class="breadcrumb-item active">Nouvelles ressources</li>
	@endcomponent
	
	<div class="container-fluid">
	    <div class="row">
	        <div class="col-sm-12">
	            <div class="card">
	                <div class="card-body">
	                    <div class="form theme-form">
							<form action="{{ route('prof.ressource-upload-form-post') }}" enctype="multipart/form-data" method="post">
								@csrf
								<div class="row">
									<div class="col">
										<div class="mb-3">
											<label>Matières</label>
											<select class="form-select @error('matiere') is-invalid @enderror" name="matiere">
												<option value="">Choisir la matière</option>
												@foreach ($matieres as $id => $matiere)
													<option value="{{ $id }}" {{ old('matiere') == $id ? 'selected' : '' }}>{{ $matiere }}</option>
												@endforeach
											</select>
											@error('matiere')
												<span class="invalid-feedback" role="alert">
													<strong>{{ $message }}</strong>
												</span>
											@enderror
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col">
										<div class="mb-3">
											<label>Nom du document</label>
											<input class="form-control @error('nom') is-invalid @enderror" type="text" placeholder="Nom du document" value="{{ old('nom') }}" name="nom" />
											@error('nom')
												<span class="invalid-feedback" role="alert">
													<strong>{{ $message }}</strong>
												</span>
											@enderror
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col">
										<div class="mb-3">
											<label for="description">Description</label>
											<textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description" rows="3">{{ old('description') }}</textarea>
											@error('description')
												<span class="invalid-feedback" role="alert">
													<strong>{{ $message }}</strong>
												</span>
											@enderror
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col">
										<div class="mb-3">
											<input class="form-control @error('document') is-invalid @enderror" name="document" type="file" aria-label="file example" />
											@error('document')
												<span class="invalid-feedback" role="alert">
													<strong>{{ $message }}</strong>
												</span>
											@enderror
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col">
										<div class="text-end"><button class="btn btn-success me-3">Valider</button></div>
										{{-- <div class="text-end"><a class="btn btn-secondary me-3" href="#">Valider</a></div> --}}
									</div>
								</div>
							</form>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>

	
	@push('scripts')
	@endpush

@endsection