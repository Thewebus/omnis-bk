@extends('layouts.informatique.master')

@section('title')Liste Etudiants
 {{ $title }}
@endsection

@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datatables.css') }}">
@endpush

@section('content')
  @component('components.informatique.breadcrumb')
    @slot('breadcrumb_title')
      <h3>Liste Etudiants</h3>
    @endslot
    {{-- <li class="breadcrumb-item">Resultats</li> --}}
    <li class="breadcrumb-item active">Liste Etudiants</li>
  @endcomponent

  <div class="container-fluid">
      <div class="row">
          <!-- Default ordering (sorting) Starts-->
	        <div class="col-sm-12">
	            <div class="card">
	                <div class="card-header">
	                    <h5>Liste des étudiants inscrits</h5>
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
							<div class="float-end">
								<a href="{{ route('admin.etudiant-export') }}" class="btn btn-primary mb-3"><i class="fa fa-upload"></i> Exporté la liste</a>
							</div>
	                        <table class="display dataTable" id="basic-3">
	                            <thead>
	                                <tr>
                                        <th>N°</th>
	                                    <th>Nom & Prénoms</th>
	                                    <th>Classe</th>
	                                    <th>Faculté</th>
	                                    <th>Actions</th>
	                                </tr>
	                            </thead>
	                            <tbody>
                                    @foreach ($etudiants as $etudiant)
	                                <tr>
                                        <td>{{ $loop->iteration }}</td>
	                                    <td>{{ $etudiant->fullname }}</td>
	                                    <td>{{ $etudiant->classe($anneeAcademique->id)->nom ?? 'NONE'}}</td>
	                                    <td>{{ $etudiant->classe($anneeAcademique->id)->niveauFaculte->faculte->nom ?? "NONE"}}</td>
                                        <td style="width: 8vw">
											<a href="{{ route('admin.inscritpion-detail', $etudiant->inscription($anneeAcademique->id)->id) }}" class="btn btn-success"><i class="fa fa-eye"></i></a>
											
											<button class="btn btn-danger btn-block" type="button" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $etudiant->id }}"><i class="fa fa-trash-o"></i></button>
											<div class="modal fade" id="deleteModal{{ $etudiant->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModal{{ $etudiant->id }}" aria-hidden="true">
												<div class="modal-dialog modal-dialog-centered" role="document">
													<div class="modal-content">
														<div class="modal-header">
															<h5 class="modal-title">Suppression étudiant</h5>
															<button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
														</div>
														<div class="modal-body">
															<p>
																Vous êtes sur le point de supprimer définitivement l'étudiant <b>{{ $etudiant->fullname }}</b>.<br>
																Cette opération est irréversible. <br>
																Voulez-vous vraiment supprimer ?
															</p>
														</div>
														<div class="modal-footer">
															<button class="btn btn-success" type="button" data-bs-dismiss="modal">Fermer</button>
															<form action="{{ route('admin.etudiant-suppression', $etudiant->id) }}" method="POST">
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
	                            <tfoot>
	                                <tr>
                                        <th>N°</th>
	                                    <th>Nom & Prénoms</th>
	                                    <th>Classe</th>
	                                    <th>Faculté</th>
	                                    <th>Actions</th>
	                                </tr>
	                            </tfoot>
	                        </table>
	                    </div>
						<div class="text-center mt-3">
							<a href="{{ route('admin.corbeille-etudiant') }}" class="btn btn-danger"><i class="fa fa-trash"></i> Corbeille </a>
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
