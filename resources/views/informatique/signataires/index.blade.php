@extends('layouts.informatique.master')

@section('title')Liste Signataires
 {{ $title }}
@endsection

@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datatables.css') }}">
@endpush

@section('content')
	@component('components.breadcrumb')
		@slot('breadcrumb_title')
			<h3>Liste Signataires</h3>
		@endslot
		<li class="breadcrumb-item active">Signataires</li>
		{{-- <li class="breadcrumb-item">Data Tables</li> --}}
		{{-- <li class="breadcrumb-item active">Liste des services</li> --}}
	@endcomponent
	
	<div class="container-fluid">
	    <div class="row">
	        <!-- Feature Unable /Disable Order Starts-->
	        <div class="col-sm-12">
	            <div class="card">
	                <div class="card-header">
	                    <h5>Liste des Signataires</h5>
	                    {{-- <span>Disabling features that you don't wish to use for a particular table is easily done by setting a variable in the initialisation object</span>
	                    <span>In the following example only the search feature is left enabled (which it is by default).</span> --}}
	                </div>
	                <div class="card-body">
	                    <div class="table-responsive">
	                        <table class="display" id="basic-2">
	                            <thead>
	                                <tr>
	                                    <th>N°</th>
	                                    <th>Nom & Prénoms</th>
	                                    <th>Fonction</th>
	                                    <th>Signataire</th>
	                                    <th>Action</th>
	                                </tr>
	                            </thead>
	                            <tbody>
                                    @foreach ($signataires as $signataire)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $signataire->fullname }}</td>
                                        <td>{{ $signataire->fonction }}</td>
                                        <td>
											@if ($signataire->signataire)
												<span class="badge badge-primary">Oui</span>
											@else
												<span class="badge badge-danger">Non</span>
											@endif
										</td>
										<td>
                                            <a href="{{ route('admin.signataires.edit', $signataire->id) }}" class="btn btn-warning mt-3"><i class="fa fa-pencil-square-o"></i></a>
											
											<button class="btn btn-danger btn-block mt-3" type="button" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $signataire->id }}"><i class="fa fa-trash-o"></i></button>
											<div class="modal fade" id="deleteModal{{ $signataire->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModal{{ $signataire->id }}" aria-hidden="true">
												<div class="modal-dialog modal-dialog-centered" role="document">
													<div class="modal-content">
														<div class="modal-header">
															<h5 class="modal-title">Suppression Signataire {{ $signataire->fullname }}</h5>
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
															<form action="{{ route('admin.signataires.destroy', $signataire) }}" method="POST">
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