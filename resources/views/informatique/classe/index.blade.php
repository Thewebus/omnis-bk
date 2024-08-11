@extends("layouts.$master.master")

@section('title')Liste classes
 {{ $title }}
@endsection

@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datatables.css') }}">
@endpush

@section('content')
	@component("components.$master.breadcrumb")
		@slot('breadcrumb_title')
			<h3>Liste classes</h3>
		@endslot
		<li class="breadcrumb-item">classes</li>
		{{-- <li class="breadcrumb-item">Data Tables</li> --}}
		<li class="breadcrumb-item active">Liste des classes</li>
	@endcomponent
	
	<div class="container-fluid">
	    <div class="row">
	        <!-- Feature Unable /Disable Order Starts-->
	        <div class="col-sm-12">
	            <div class="card">
	                <div class="card-header">
	                    <h5>Liste des classes</h5>
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
	                                    <th>Faculté</th>
	                                    <th>Code classe</th>
	                                    <th>Action</th>
	                                </tr>
	                            </thead>
	                            <tbody>
									@foreach ($classes as $classe)
	                                <tr>
	                                    <td>{{ $loop->iteration }}</td>
	                                    <td><a href="{{ route('admin.liste-classe-etudiants', $classe->id) }}">{{ $classe->nom }}</a></td>
	                                    <td>{{ $classe->niveauFaculte->faculte->nom ?? __('no faculté') }}</td>
	                                    <td>{{ $classe->code }}</td>
	                                    <td style="width: 13vw">
											<button class="btn btn-primary btn-block mt-3" type="button" data-bs-toggle="modal" data-bs-target="#seeModal{{ $classe->id }}"><i class="fa fa-eye"></i></button>
											<div class="modal fade" id="seeModal{{ $classe->id }}" tabindex="-1" role="dialog" aria-labelledby="seeModal{{ $classe->id }}" aria-hidden="true">
												<div class="modal-dialog modal-dialog-centered" role="document">
													<div class="modal-content">
														<div class="modal-header">
															<h5 class="modal-title">Filière {{ $classe->nom }}</h5>
															<button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
														</div>
														<div class="modal-body">
															<p>
																Nom Classe : <b>{{ $classe->nom }}</b> <br>
																Code : <b>{{ $classe->code }}</b> <br>
																Description Classe : <b>{{ $classe->description }}</b> <br>
																Filière : <b>{{ $classe->niveauFaculte->faculte->nom ?? __('no filière') }}</b> <br>
																Niveau : <b>{{ $classe->niveauFaculte->nom ?? __('no niveau filière') }}</b>
															</p>														
														</div>
														<div class="modal-footer">
															<button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
															<button class="btn btn-primary" type="button">OK</button>
														</div>
													</div>
												</div>
											</div>

											<a href="{{ route('admin.classe.edit', $classe) }}" class="btn btn-warning mt-3"><i class="fa fa-pencil-square-o"></i></a>

											<button class="btn btn-danger btn-block mt-3" type="button" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $classe->id }}"><i class="fa fa-trash-o"></i></button>
											<div class="modal fade" id="deleteModal{{ $classe->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModal{{ $classe->id }}" aria-hidden="true">
												<div class="modal-dialog modal-dialog-centered" role="document">
													<div class="modal-content">
														<div class="modal-header">
															<h5 class="modal-title">Suppression faculté {{ $classe->nom }}</h5>
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
															<form action="{{ route('admin.classe.destroy', $classe) }}" method="POST">
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
						<div class="text-center mt-3">
							<a href="{{ route('admin.corbeille-classe') }}" class="btn btn-danger"><i class="fa fa-trash"></i> Corbeille </a>
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