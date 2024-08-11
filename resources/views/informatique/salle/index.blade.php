@extends("layouts.$master.master")

@section('title')Salles de classe
{{ $title }}
@endsection

@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datatables.css') }}">
@endpush

@section('content')
	@component("components.$master.breadcrumb")
		@slot('breadcrumb_title')
			<h3>Salles de classe</h3>
		@endslot
		{{-- <li class="breadcrumb-item">Filières</li> --}}
		{{-- <li class="breadcrumb-item">Data Tables</li> --}}
		<li class="breadcrumb-item active">Salles de classe</li>
	@endcomponent
	
	<div class="container-fluid">
	    <div class="row">
	        <!-- Feature Unable /Disable Order Starts-->
	        <div class="col-sm-12">
	            <div class="card">
	                <div class="card-header">
	                    <h5>Salles de classe</h5>
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
	                                    <th>Capacité (places)</th>
	                                    <th>Batiment</th>
	                                    <th>Action</th>
	                                </tr>
	                            </thead>
	                            <tbody>
									@foreach ($salles as $salle)
	                                <tr>
	                                    <td>{{ $loop->iteration }}</td>
	                                    <td>{{ $salle->nom }}</td>
	                                    <td>{{ $salle->capacite }}</td>
	                                    <td>{{ $salle->batiment }}</td>
	                                    <td style="width: 11vw">
											<button class="btn btn-primary btn-block mt-3" type="button" data-bs-toggle="modal" data-bs-target="#seeModal{{ $salle->id }}"><i class="fa fa-eye"></i></button>
											<div class="modal fade" id="seeModal{{ $salle->id }}" tabindex="-1" role="dialog" aria-labelledby="seeModal{{ $salle->id }}" aria-hidden="true">
												<div class="modal-dialog modal-dialog-centered" role="document">
													<div class="modal-content">
														<div class="modal-header">
															<h5 class="modal-title">Salle {{ $salle->nom }}</h5>
															<button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
														</div>
														<div class="modal-body">
															<p>
																Nom salle : <b>{{ $salle->nom }}</b> <br>
																Capacité : <b>{{ $salle->capacite }}</b> <br>
																Batiment : <b>{{ $salle->batiment }}</b> <br>
															</p>														
														</div>
														<div class="modal-footer">
															<button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
															<button class="btn btn-primary" type="button">OK</button>
														</div>
													</div>
												</div>
											</div>

											<a href="{{ route('admin.salle.edit', $salle) }}" class="btn btn-warning mt-3"><i class="fa fa-pencil-square-o"></i></a>

											<button class="btn btn-danger btn-block mt-3" type="button" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $salle->id }}"><i class="fa fa-trash-o"></i></button>
											<div class="modal fade" id="deleteModal{{ $salle->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModal{{ $salle->id }}" aria-hidden="true">
												<div class="modal-dialog modal-dialog-centered" role="document">
													<div class="modal-content">
														<div class="modal-header">
															<h5 class="modal-title">Suppression salle {{ $salle->nom }}</h5>
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
															<form action="{{ route('admin.salle.destroy', $salle) }}" method="POST">
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