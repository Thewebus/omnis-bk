@extends('layouts.informatique.master')

@section('title')Matières
    {{ $title }}
@endsection

@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datatables.css') }}">
@endpush

@section('content')
	@component('components.informatique.breadcrumb')
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
						<span style="font-size: 1rem">Liste des matières, classe <b>{{ $classe->nom }}</b></span>
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="display" id="basic-2">
								<thead>
									<tr>
										<th>N°</th>
										<th>Nom matière</th>
										<th>N° Ordre</th>
										<th>Coef.</th>
										<th>cred.</th>
										<th>N° Sem.</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									@foreach ($matieres as $matiere)
									<tr>
										<td>{{ $loop->iteration }}</td>
										<td>{{ $matiere->nom }}</td>
										<td>{{ $matiere->numero_ordre }}</td>
										<td>{{ $matiere->coefficient }}</td>
										<td>{{ $matiere->credit }}</td>
										<td>{{ $matiere->semestre }}</td>
										<td>
											<a href="{{ route('admin.notes-matiere', $matiere->id) }}" class="btn btn-success mt-3"><i class="fa fa-eye"></i></a>
											
											<button class="btn btn-danger btn-block mt-3" type="button" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $matiere->id }}"><i class="fa fa-trash-o"></i></button>
											<div class="modal fade" id="deleteModal{{ $matiere->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModal{{ $matiere->id }}" aria-hidden="true">
												<div class="modal-dialog modal-dialog-centered" role="document">
													<div class="modal-content">
														<div class="modal-header">
															<h5 class="modal-title">Suppression Notes</h5>
															<button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
														</div>
														<div class="modal-body">
															<p>
																Vous êtes sur le point de supprimer définitivement toutes les notes de la matière <b>{{ $matiere->nom }}</b>.<br>
																Cette opération est irréversible. <br>
																Voulez-vous vraiment supprimer ?
															</p>
														</div>
														<div class="modal-footer">
															<button class="btn btn-success" type="button" data-bs-dismiss="modal">Fermer</button>
															<form action="{{ route('admin.suppression-notes', $matiere->id) }}" method="POST">
																@method('DELETE')
																@csrf
																<button class="btn btn-danger" type="submit"><i class="fa fa-trash-o"></i> Supprimer</button>
															</form>
														</div>
													</div>
												</div>
											</div>
										</td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	
	@push('scripts')
	<script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}"></script>
	@endpush

@endsection