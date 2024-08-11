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
						<span style="font-size: 1rem">Liste des matières pour liste de présence</span>
					</div>
				</div>
			</div>
			@foreach ($matiereProfesseurs as $matiereProfesseur)
				{{-- @foreach ($matiere->professeurs->where('id', Auth::id()) as $professeur) --}}
				@if (!is_null($matiereProfesseur->matiere))
					<div class="col-sm-6 col-xl-3 col-lg-6">
						<a href="{{ route('prof.liste-presence', $matiereProfesseur->matiere->id) }}">
							<div class="card o-hidden border-0">
								<div class="bg-primary b-r-4 card-body">
									<div class="media static-top-widget">
										<div class="align-self-center text-center"><i data-feather="message-circle"></i></div>
										<div class="media-body">
											<span class="m-0">{{ $matiereProfesseur->matiere->nom }}</span>
											{{-- <h4 class="mb-0 counter">{{ Auth::user()->classes->count() }}</h4> --}}
											<i class="icon-bg" data-feather="message-circle"></i>
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