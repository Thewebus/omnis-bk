@extends('layouts.informatique.master')

@section('title')Liste Unité d'Enseignement
 {{ $title }}
@endsection

@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datatables.css') }}">
@endpush

@section('content')
	@component('components.informatique.breadcrumb')
		@slot('breadcrumb_title')
			<h3>Liste Unité d'Enseignement</h3>
		@endslot
		{{-- <li class="breadcrumb-item"><a href="{{ route('admin.unite-enseignement.index') }}">Unité d'Enseignement</a></li> --}}
		{{-- <li class="breadcrumb-item">Data Tables</li> --}}
		<li class="breadcrumb-item active">Liste des Unités d'Enseignement</li>
	@endcomponent
	
	<div class="container-fluid">
	    <div class="row">
	        <!-- Feature Unable /Disable Order Starts-->
	        <div class="col-sm-12">
	            <div class="card">
	                <div class="card-header">
	                    <h5>Liste des Unités d'Enseignement</h5>
	                    {{-- <span>Disabling features that you don't wish to use for a particular table is easily done by setting a variable in the initialisation object</span>
	                    <span>In the following example only the search feature is left enabled (which it is by default).</span> --}}
	                </div>
	                <div class="card-body">
	                    <div class="table-responsive">
	                        <table class="display" id="basic-2">
	                            <thead>
	                                <tr>
	                                    <th>N°</th>
	                                    <th>Nom</th>
	                                    <th>code</th>
	                                    <th>Action</th>
	                                </tr>
	                            </thead>
	                            <tbody>
									@foreach ($uniteEnseignements as $uniteEnseignement)
	                                <tr>
	                                    <td>{{ $loop->iteration }}</td>
	                                    <td>{{ $uniteEnseignement->nom }}</td>
	                                    <td>{{ $uniteEnseignement->code }}</td>
	                                    <td style="width: 11vw">
											<button class="btn btn-primary btn-block mt-3" type="button" data-bs-toggle="modal" data-bs-target="#seeModal{{ $uniteEnseignement->id }}"><i class="fa fa-eye"></i></button>
											<div class="modal fade" id="seeModal{{ $uniteEnseignement->id }}" tabindex="-1" role="dialog" aria-labelledby="seeModal{{ $uniteEnseignement->id }}" aria-hidden="true">
												<div class="modal-dialog modal-dialog-centered" role="document">
													<div class="modal-content">
														<div class="modal-header">
															<h5 class="modal-title">UE {{ $uniteEnseignement->nom }}</h5>
															<button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
														</div>
														<div class="modal-body">
															<p>
																Nom UE : <b>{{ $uniteEnseignement->nom }}</b> <br>
																Code UE : <b>{{ $uniteEnseignement->code }}</b> <br>
															</p>														
														</div>
														<div class="modal-footer">
															<button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
															<button class="btn btn-primary" type="button">OK</button>
														</div>
													</div>
												</div>
											</div>

											<a href="{{ route('admin.unite-enseignement.edit', $uniteEnseignement) }}" class="btn btn-warning mt-3"><i class="fa fa-pencil-square-o"></i></a>

											<button class="btn btn-danger btn-block mt-3" type="button" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $uniteEnseignement->id }}"><i class="fa fa-trash-o"></i></button>
											<div class="modal fade" id="deleteModal{{ $uniteEnseignement->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModal{{ $uniteEnseignement->id }}" aria-hidden="true">
												<div class="modal-dialog modal-dialog-centered" role="document">
													<div class="modal-content">
														<div class="modal-header">
															<h5 class="modal-title">Suppression UE {{ $uniteEnseignement->nom }}</h5>
															<button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
														</div>
														<div class="modal-body">
															<p>
																Vous êtes sur le point de supprimer définitivement cet élément. <br>
																Cette opération est irréversible. <br>
																Voulez-vous vraiment supprimer ?
															</p>
														</div>
														<div class="modal-footer">
															<button class="btn btn-success" type="button" data-bs-dismiss="modal">Fermer</button>
															<form action="{{ route('admin.unite-enseignement.destroy', $uniteEnseignement) }}" method="POST">
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
	        <!-- Feature Unable /Disable Ends-->
	    </div>
	</div>

	
	@push('scripts')
	<script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}"></script>
	@endpush

@endsection