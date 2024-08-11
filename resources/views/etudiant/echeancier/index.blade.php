@extends('layouts.etudiant.master')

@section('title')Echéancier
 {{ $title }}
@endsection

@push('css')
@endpush

@section('content')
	@component('components.breadcrumb')
		@slot('breadcrumb_title')
			<h3>Echéancier</h3>
		@endslot
		{{-- <li class="breadcrumb-item">Bootstrap Tables</li> --}}
		<li class="breadcrumb-item active">Echéancier</li>
	@endcomponent
	
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-12">
				<div class="card">
					<div class="card-header">
						<h5>Echéancier</h5>
						<span>
							Example of <code>horizontal</code> table borders. This is a default table border style attached to <code> .table</code> class.All borders have the same grey color and style, table itself doesn't have a border, but
							you can add this border using<code> .table-bordered</code>class added to the table with <code>.table</code>class.
						</span>
						<div class="row">
							<div class="col-md-3">
								@if (!$echeancier)
									<a class="btn btn-success mt-3" href="{{ route('user.echeancier.create') }}">Remplir l'échéancier</a>
								@else
									@if ($echeancier->statut !== 'validé')
										<a class="btn btn-success mt-3" href="{{ route('user.echeancier.edit', $echeancier->id) }}">Modilier l'échéancier</a>										
									@endif
								@endif
							</div>
							<div class="col-md-3">
								@if (!is_null($echeancier))
									@if ($echeancier->statut == 'validé')
										<button class="btn mt-3 btn-primary" type="button">Statut : {{ $echeancier->statut }}</button>
									@elseif($echeancier->statut == 'en attente')
										<button class="btn mt-3 btn-warning" type="button">Statut : {{ $echeancier->statut }}</button>
									@else
										<button class="btn mt-3 btn-danger" type="button">Statut : {{ $echeancier->statut }}</button>
									@endif
								@else
									<button class="btn btn-danger mt-3" type="button">{{ __('Aucun') }}</button>
								@endif
							</div>
							<div class="col-md-6">
								
							</div>
						</div>
					</div>
					<div class="table-responsive">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th scope="col">#</th>
									<th scope="col">Nbr Versements</th>
									<th scope="col">Dates</th>
									<th scope="col">Sommes</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<th scope="row">1</th>
									<td>Versement 1</td>
									<td>{{ $echeancier->date_1 ?? '' }}</td>
									<td>{{ $echeancier->versement_1 ?? '' }}</td>
								</tr>
                                <tr>
									<th scope="row">2</th>
									<td>Versement 2</td>
									<td>{{ $echeancier->date_2 ?? '' }}</td>
									<td>{{ $echeancier->versement_2 ?? '' }}</td>
								</tr>
                                <tr>
									<th scope="row">3</th>
									<td>Versement 3</td>
									<td>{{ $echeancier->date_3 ?? '' }}</td>
									<td>{{ $echeancier->versement_3 ?? '' }}</td>
								</tr>
                                <tr>
									<th scope="row">4</th>
									<td>Versement 4</td>
									<td>{{ $echeancier->date_4 ?? '' }}</td>
									<td>{{ $echeancier->versement_4 ?? '' }}</td>
								</tr>
                                <tr>
									<th scope="row">5</th>
									<td>Versement 5</td>
									<td>{{ $echeancier->date_5 ?? '' }}</td>
									<td>{{ $echeancier->versement_5 ?? '' }}</td>
								</tr>
                                <tr>
									<th scope="row">6</th>
									<td>Versement 6</td>
									<td>{{ $echeancier->date_6 ?? '' }}</td>
									<td>{{ $echeancier->versement_6 ?? '' }}</td>
								</tr>
                                <tr>
									<th scope="row">7</th>
									<td>Versement 7</td>
									<td>{{ $echeancier->date_7 ?? '' }}</td>
									<td>{{ $echeancier->versement_7 ?? '' }}</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>

			@if (!is_null($echeancier))
				@if ($echeancier->statut == 'non validé')
					<div class="col-md-12">
						<div class="alert alert-danger dark" role="alert">
							<p>Motif du réfus : {{ $echeancier->observation }}</p>
						</div>
					</div>
				@elseif ($echeancier->statut == 'validé')
					<div class="text-center mb-3">
						<a href="{{ route('echeancier-download') }}" class="btn btn-primary"><i class="fa fa-download"></i> Télécharger</a>
					</div>
				@endif
			@endif
		</div>
	</div>	
	
	@push('scripts')
	@endpush

@endsection