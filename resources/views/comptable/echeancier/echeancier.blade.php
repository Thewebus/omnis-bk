@extends('layouts.comptable.master')

@section('title', 'Echéancier')

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
						<h5>Echéancier étudiant : {{ $etudiant->fullname }}</h5>
						{{-- <span>
							Example of <code>horizontal</code> table borders. This is a default table border style attached to <code> .table</code> class.All borders have the same grey color and style, table itself doesn't have a border, but
							you can add this border using<code> .table-bordered</code>class added to the table with <code>.table</code>class.
						</span> --}}
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
									<td>{{ $etudiant->echeancier($anneeAcademique->id)->date_1 ?? '' }}</td>
									<td>{{ $etudiant->echeancier($anneeAcademique->id)->versement_1 ?? '' }}</td>
								</tr>
                                <tr>
									<th scope="row">2</th>
									<td>Versement 2</td>
									<td>{{ $etudiant->echeancier($anneeAcademique->id)->date_2 ?? '' }}</td>
									<td>{{ $etudiant->echeancier($anneeAcademique->id)->versement_2 ?? '' }}</td>
								</tr>
                                <tr>
									<th scope="row">3</th>
									<td>Versement 3</td>
									<td>{{ $etudiant->echeancier($anneeAcademique->id)->date_3 ?? '' }}</td>
									<td>{{ $etudiant->echeancier($anneeAcademique->id)->versement_3 ?? '' }}</td>
								</tr>
                                <tr>
									<th scope="row">4</th>
									<td>Versement 4</td>
									<td>{{ $etudiant->echeancier($anneeAcademique->id)->date_4 ?? '' }}</td>
									<td>{{ $etudiant->echeancier($anneeAcademique->id)->versement_4 ?? '' }}</td>
								</tr>
                                <tr>
									<th scope="row">5</th>
									<td>Versement 5</td>
									<td>{{ $etudiant->echeancier($anneeAcademique->id)->date_5 ?? '' }}</td>
									<td>{{ $etudiant->echeancier($anneeAcademique->id)->versement_5 ?? '' }}</td>
								</tr>
                                <tr>
									<th scope="row">6</th>
									<td>Versement 6</td>
									<td>{{ $etudiant->echeancier($anneeAcademique->id)->date_6 ?? '' }}</td>
									<td>{{ $etudiant->echeancier($anneeAcademique->id)->versement_6 ?? '' }}</td>
								</tr>
                                <tr>
									<th scope="row">7</th>
									<td>Versement 7</td>
									<td>{{ $etudiant->echeancier($anneeAcademique->id)->date_7 ?? '' }}</td>
									<td>{{ $etudiant->echeancier($anneeAcademique->id)->versement_7 ?? '' }}</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<div class="text-center mb-3">
			@if (!is_null($etudiant->echeancier($anneeAcademique->id)))
				<form action="{{ route('admin.valide-echeancier', $etudiant->echeancier($anneeAcademique->id)->id) }}" method="post" style="display: inline-block">
					@csrf
					<button class="btn btn-success" type="submit"><i class="fa fa-check"></i> Valider</button>
				</form>
				
				<a href="{{ route('admin.modifier-echeancier', $etudiant->id) }}" class="btn btn-warning"><i class="fa fa-edit"></i> Modifier</a>
				
				<button class="btn btn-danger" type="button" data-bs-toggle="modal" data-bs-target="#denieModal{{ $etudiant->echeancier($anneeAcademique->id)->id }}"><i class="icon-close"></i> Réfuser</button>
				<div class="modal fade" id="denieModal{{ $etudiant->echeancier($anneeAcademique->id)->id }}" tabindex="-1" role="dialog" aria-labelledby="denieModal{{ $etudiant->echeancier($anneeAcademique->id)->id }}" aria-hidden="true">
					<div class="modal-dialog modal-dialog-centered" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title">Refus échéancier</h5>
								<button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
							</div>
							<form class="form theme-form" action="{{ route('admin.refus-echeancier', $etudiant->echeancier($anneeAcademique->id)->id) }}" method="POST">
								<div class="modal-body">
									@csrf
									<div class="card-body">
										<div class="row">
											<div class="col">
												<div class="mb-3 row">
													<label class="col-sm-3 col-form-label">Motif</label>
													<div class="col-sm-9">
														<textarea class="form-control @error('motif') is-invalid @enderror" name="motif" rows="5" cols="5" placeholder="Motif du réfus">{{ old('motif') }}</textarea>
														@error('motif')
															<span class="invalid-feedback" role="alert">
																<strong>{{ $message }}</strong>
															</span>
														@enderror
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="modal-footer">
									<button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
									<button class="btn btn-primary" type="submit"><i class="fa fa-save"></i> Valider</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			@else
				<button class="btn btn-warning" type="button">Echéancier non rempli </button>
			@endif

		</div>
	</div>	
	
	@push('scripts')
	@endpush

@endsection