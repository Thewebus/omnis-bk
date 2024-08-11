@extends('layouts.informatique.master')

@section('title')Note Rattrapage
 {{ $title }}
@endsection

@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datatables.css') }}">
@endpush

@section('content')
	@component('components.informatique.breadcrumb')
		@slot('breadcrumb_title')
			<h3>Note Rattrapage</h3>
		@endslot
		<li class="breadcrumb-item">Rattrapage</li>
		{{-- <li class="breadcrumb-item">Data Tables</li> --}}
		<li class="breadcrumb-item active">Note Rattrapage</li>
	@endcomponent
	
	<div class="container-fluid">
	    <div class="row">
	        <div class="col-sm-12">
	            <div class="card">
	                <div class="card-header">
	                    <h5>Note Rattrapage</b></h5>
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
	                                    <th>Matière</th>
	                                    <th>classe</th>
	                                    <th>Note</th>
										@if (Auth::user()->email == "v.bourgou2@gmail.com" || Auth::user()->email == "youssouf.sidick.ys@outlook.com")
	                                    	<th>Actions</th>
										@endif
	                                </tr>
	                            </thead>
	                            <tbody>
									@foreach ($rattrapages as $rattrapage)
	                                <tr>
	                                    <td>{{ $loop->iteration }}</td>
	                                    <td>{{ $rattrapage->etudiant->fullname }}</td>	                                    
	                                    <td>{{ $rattrapage->matiere->nom }}</td>	                                    
	                                    <td>{{ $rattrapage->matiere->classe->nom }}</td>	                                    
	                                    <td>{{ $rattrapage->note }}</td>
										@if (Auth::user()->email == "v.bourgou2@gmail.com" || Auth::user()->email == "youssouf.sidick.ys@outlook.com")											
											<td style="width: 5vw">
												<a href="{{ route('admin.rattrapage.modification', $rattrapage->id) }}"><button class="btn btn-primary"><i class="fa fa-edit"></i></button></a>

												<button class="btn btn-danger btn-block" type="button" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $rattrapage->id }}"><i class="fa fa-trash-o"></i></button>
												<div class="modal fade" id="deleteModal{{ $rattrapage->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModal{{ $rattrapage->id }}" aria-hidden="true">
													<div class="modal-dialog modal-dialog-centered" role="document">
														<div class="modal-content">
															<div class="modal-header">
																<h5 class="modal-title">Suppression {{ $rattrapage->etudiant->fullname }} </h5>
																<button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
															</div>
															<div class="modal-body">
																<p>
																	Vous êtes sur le point de supprimer définitivement cet élément. <br>
																	Cette opération est irréversible. <br>
																	{{ $rattrapage->matiere->nom }} <br>
																	{{ $rattrapage->matiere->classe->nom }} <br>
																	{{ $rattrapage->note }} <br>
																	Voulez-vous vraiment supprimer ?
																</p>
															</div>
															<div class="modal-footer">
																<button class="btn btn-success" type="button" data-bs-dismiss="modal">Fermer</button>
																<form action="{{ route('admin.rattrapage.suppression-rattrapage', $rattrapage->id) }}" method="POST">
																	@csrf
																	<button class="btn btn-danger" type="submit"><i class="fa fa-trash-o"></i> Supprimer</button>
																</form>
															</div>
														</div>
													</div>
												</div>
											</td>
										@endif                                   
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