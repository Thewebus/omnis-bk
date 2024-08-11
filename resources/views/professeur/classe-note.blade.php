@extends('layouts.professeur.master')

@section('title')Détails classe
    {{ $title }}
@endsection

@section('content')
	@component('components.professeur.breadcrumb')
		@slot('breadcrumb_title')
			<h3>Liste des matières</h3>
		@endslot
		<li class="breadcrumb-item">Liste</li>
		<li class="breadcrumb-item active">Liste des matières</li>
	@endcomponent
	
	<div class="container-fluid">
	    <div class="row">
			<div class="col-sm-12">
				<div class="card">
					<div class="card-header">
						<span style="font-size: 1rem">Liste des matières pour les notes</span>
					</div>
				</div>
			</div>
			@foreach ($matiereProfesseurs as $matiereProfesseur)
				@if (!is_null($matiereProfesseur->matiere))
					<div class="col-sm-6 col-xl-3 col-lg-6">
						<a href="{{ route('prof.notes', $matiereProfesseur->matiere->id) }}">
							<div class="card o-hidden border-0">
								<div class="bg-primary b-r-4 card-body">
									<div class="media static-top-widget">
										<div class="align-self-center text-center"><i data-feather="users"></i></div>
										<div class="media-body">
											<input type="hidden" name="matiere_id" value="{{ $matiereProfesseur->matiere->id ?? '#' }}">
											<button class="btn" style="color: #fff" type="submit">{{ $matiereProfesseur->matiere->nom ?? 'NONE' }}</button>
											<i class="icon-bg" data-feather="users"></i>
										</div>
									</div>
								</div>
							</div>
						</a>
					</div>
				@endif
			@endforeach
		</div>
	</div>

	
	@push('scripts')
	@endpush

@endsection