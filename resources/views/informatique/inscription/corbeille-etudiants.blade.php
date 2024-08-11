@extends("layouts.$master.master")

@section('title')Corbail Etudiants
 {{ $title }}
@endsection

@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datatables.css') }}">
@endpush

@section('content')
  @component("components.$master.breadcrumb")
    @slot('breadcrumb_title')
      <h3>Corbail Etudiants</h3>
    @endslot
    {{-- <li class="breadcrumb-item">Resultats</li> --}}
    <li class="breadcrumb-item active">Corbail Etudiants</li>
  @endcomponent

  <div class="container-fluid">
      <div class="row">
          <!-- Default ordering (sorting) Starts-->
	        <div class="col-sm-12">
	            <div class="card">
	                <div class="card-header">
	                    <h5>Corbail des étudiants inscrits</h5>
	                    {{-- <span>
	                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Illum odio pariatur mollitia sunt temporibus dicta inventore asperiores praesentium quae, autem velit assumenda non exercitationem laborum. Distinctio sed architecto dolorem alias. <br>
	                    </span> --}}
	                    {{-- <span>
	                        The<code class="option" title="DataTables initialisation option">order:Option</code> parameter is an array of arrays where the first value of the inner array is the column to order on, and the second is
	                        <code class="string" title="String">'asc':String</code> (ascending ordering) or <code class="string" title="String">'desc':String</code> (descending ordering) as required.
	                        <code class="option" title="DataTables initialisation option">order:String</code> is a 2D array to allow multi-column ordering to be defined.
	                    </span> --}}
	                </div>
	                <div class="card-body">
	                    <div class="table-responsive">
	                        <table class="display dataTable" id="basic-3">
	                            <thead>
	                                <tr>
                                        <th>N°</th>
	                                    <th>Nom & Prénoms</th>
	                                    <th>Classe</th>
	                                    <th>Filière</th>
	                                    <th>Actions</th>
	                                </tr>
	                            </thead>
	                            <tbody>
                                    @foreach ($etudiants as $etudiant)
	                                <tr>
                                        <td>{{ $loop->iteration }}</td>
	                                    <td>{{ $etudiant->fullname }}</td>
	                                    <td>{{ $etudiant->classe->nom ?? 'NONE'}}</td>
	                                    <td>{{ $etudiant->classe->niveauFaculte->faculte->nom ?? "NONE"}}</td>
                                        <td>
											<button class="btn btn-success btn-block mt-3" type="button" data-bs-toggle="modal" data-bs-target="#restoreModal{{ $etudiant->id }}"><i class="fa fa-upload"></i></button>
											<div class="modal fade" id="restoreModal{{ $etudiant->id }}" tabindex="-1" role="dialog" aria-labelledby="restoreModal{{ $etudiant->id }}" aria-hidden="true">
												<div class="modal-dialog modal-dialog-centered" role="document">
													<div class="modal-content">
														<div class="modal-header">
															<h5 class="modal-title">Restoration</h5>
															<button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
														</div>
														<div class="modal-body">
															<p>
																Vous êtes sur le point de restorer l'étudiant <b>{{ $etudiant->fullname }}</b>. <br>
																Voulez-vous vraiment restorer ?
															</p>
														</div>
														<div class="modal-footer">
															<button class="btn btn-success" type="button" data-bs-dismiss="modal">Fermer</button>
															<form action="{{ route('admin.restoration-etudiant', $etudiant) }}" method="POST">
																@csrf
																<button class="btn btn-primary" type="submit"><i class="fa fa-upload"></i> Restorer</button>
															</form>
														</div>
													</div>
												</div>
											</div>		
											
											<button class="btn btn-danger btn-block mt-3" type="button" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $etudiant->id }}"><i class="fa fa-trash-o"></i></button>
											<div class="modal fade" id="deleteModal{{ $etudiant->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModal{{ $etudiant->id }}" aria-hidden="true">
												<div class="modal-dialog modal-dialog-centered" role="document">
													<div class="modal-content">
														<div class="modal-header">
															<h5 class="modal-title">Suppression définitive</h5>
															<button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
														</div>
														<div class="modal-body">
															<p>
																Vous êtes sur le point de supprimer définitivement l'étudiant <b>{{ $etudiant->fullname }}</b>. <br>
																Cette opération est irréversible. <br>
																Voulez-vous vraiment supprimer ?
															</p>
														</div>
														<div class="modal-footer">
															<button class="btn btn-success" type="button" data-bs-dismiss="modal">Fermer</button>
															<form action="{{ route('admin.post-corbeille-etudiant', $etudiant) }}" method="POST">
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
	                            <tfoot>
	                                <tr>
                                        <th>N°</th>
	                                    <th>Nom & Prénoms</th>
	                                    <th>Filière</th>
	                                    <th>Cursus</th>
	                                    <th>Actions</th>
	                                </tr>
	                            </tfoot>
	                        </table>
	                    </div>
	                </div>
	            </div>
	        </div>
	        <!-- Default ordering (sorting) Ends-->
      </div>
  </div>


  @push('scripts')
  <script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}"></script>
  @endpush

@endsection
