@extends('layouts.informatique.master')

@section('title')Liste cours
 {{ $title }}
@endsection

@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datatables.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/select2.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/timepicker.css') }}">
@endpush

@section('content')
	@component('components.breadcrumb')
		@slot('breadcrumb_title')
			<h3>Liste cours</h3>
		@endslot
		<li class="breadcrumb-item">cours</li>
		{{-- <li class="breadcrumb-item">Data Tables</li> --}}
		<li class="breadcrumb-item active">Liste des cours</li>
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
	                                    <th>Jour</th>
	                                    <th>Matière</th>
	                                    <th>salle</th>
	                                    <th>Début</th>
	                                    <th>Fin</th>
	                                    <th>Action</th>
	                                </tr>
	                            </thead>
	                            <tbody>
									@foreach ($classe->cours as $cours)
	                                <tr>
	                                    <td>{{ $loop->iteration }}</td>
	                                    <td>
											@if ($cours->jour == 1)
												Lundi
											@elseif ($cours->jour == 2)
												Mardi
											@elseif ($cours->jour == 3)
												Mercredi
											@elseif ($cours->jour == 4)
												Jeudi
											@elseif ($cours->jour == 5)
												Vendredi
											@elseif ($cours->jour == 6)
												Samedi
											@else
												Dimanche
											@endif
										</td>
	                                    <td>{{ $cours->matiere->nom }}</td>
	                                    <td>{{ $cours->salle->nom }}</td>
	                                    <td>{{ substr($cours->heure_debut, 0, 5) }}</td>
	                                    <td>{{ substr($cours->heure_fin, 0, 5) }}</td>
	                                    <td style="width: 13vw">
											<button class="btn btn-warning mt-3" type="button" data-bs-toggle="modal" data-bs-target="#changeModal{{ $cours->id }}"><i class="fa fa-pencil-square-o"></i></button>
                                            <div class="modal fade" id="changeModal{{ $cours->id }}" tabindex="-1" role="dialog" aria-labelledby="changeModal{{ $cours->id }}" aria-hidden="true">
												<div class="modal-dialog modal-dialog-centered" role="document">
													<div class="modal-content">
														<div class="modal-header">
															<h5 class="modal-title">Remplir les champs</h5>
															<button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
														</div>
                                                        <form action="{{ route('admin.emploi-du-temps.update', $cours->id) }}" method="POST">
															@method('PUT')
                                                            @csrf
                                                            <div class="modal-body">
                                                                <div class="row">
																	<div class="col">
																		<div class="mb-3 row">
																			<label class="col-sm-3 col-form-label">Jour</label>
																			<div class="col-sm-9">
																				<input type="hidden" name="classe" value="{{ $classe->id }}">
																				<select class="form-select" name="jour" aria-label="Default select example" >
																					@foreach ($jours as $index => $jour)
																						<option value="{{ $index }}" {{ $cours->jour == $index ? 'selected' : '' }}>{{ $jour }}</option>
																					@endforeach
																				</select>                                            
																				@error('jour')
																					<span class="invalid-feedback" role="alert">
																						<strong>{{ $message }}</strong>
																					</span>
																				@enderror
																			</div>
																		</div>
																		<div class="mb-3 row">
																			<label class="col-sm-3 col-form-label">Matière</label>
																			<div class="col-sm-9">
																				<select class="form-select" id="validationCustom04" name="matiere">
																					@foreach ($classe->niveauFiliere->matieres as $matiere)
																						<option value="{{ $matiere->id }}" {{ ($cours->matiere_id ?? old('matiere')) == $matiere->id ? 'selected' : '' }}>{{ $matiere->nom }}</option>
																					@endforeach
																				</select>                                              
																				@error('matiere')
																					<span class="invalid-feedback" role="alert">
																						<strong>{{ $message }}</strong>
																					</span>
																				@enderror
																			</div>
																		</div>
																		<div class="mb-3 row">
																			<label class="col-sm-3 col-form-label">Salle</label>
																			<div class="col-sm-9">
																				<select class="form-select" id="validationCustom04" name="salle">
																					@foreach ($salles as $salle)
																						<option value="{{ $salle->id }}" {{ ( $cours->salle_id ?? old('salle')) == $salle->id ? 'selected' : '' }}>{{ $salle->nom }}</option>
																					@endforeach
																				</select>                                              
																				@error('salle')
																					<span class="invalid-feedback" role="alert">
																						<strong>{{ $message }}</strong>
																					</span>
																				@enderror
																			</div>
																		</div>
																		<div class="mb-3 row clockpicker">
																			<label class="col-sm-3 col-form-label">Heure Debut</label>
																			<div class="col-sm-9">
																				<input class="form-control @error('heure_debut') is-invalid @enderror" value="{{ substr($cours->heure_debut, 0 ,5) ?? old('heure_debut') }}" type="time"  name="heure_debut" /><span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
																				@error('heure_debut')
																					<span class="invalid-feedback" role="alert">
																						<strong>{{ $message }}</strong>
																					</span>
																				@enderror
																			</div>
																		</div>
																		<div class="mb-3 row clockpicker">
																			<label class="col-sm-3 col-form-label">Heure Fin</label>
																			<div class="col-sm-9">
																				<input class="form-control @error('heure_fin') is-invalid @enderror" type="time"  value="{{ substr($cours->heure_fin, 0, 5) ?? old('heure_fin') }}" name="heure_fin"/><span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
																				@error('heure_fin')
																					<span class="invalid-feedback" role="alert">
																						<strong>{{ $message }}</strong>
																					</span>
																				@enderror
																			</div>
																		</div>
																	</div>
																</div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Fermer</button>
                                                                <button class="btn btn-primary" type="submit">Valider</button>
                                                            </div>
                                                        </form>
													</div>
												</div>
											</div>

											<button class="btn btn-danger mt-3" type="button" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $cours->id }}"><i class="fa fa-trash-o"></i></button>
											<div class="modal fade" id="deleteModal{{ $cours->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModal{{ $cours->id }}" aria-hidden="true">
												<div class="modal-dialog modal-dialog-centered" role="document">
													<div class="modal-content">
														<div class="modal-header">
															<h5 class="modal-title">Suppression cours</h5>
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
															<form action="{{ route('admin.emploi-du-temps.destroy', $cours->id) }}" method="POST">
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
	<script src="{{ asset('assets/js/form-validation-custom.js') }}"></script>
    <script src="{{ asset('assets/js/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/js/select2/select2-custom.js') }}"></script>
    <script src="{{ asset('assets/js/time-picker/jquery-clockpicker.min.js') }}"></script>
    <script src="{{ asset('assets/js/time-picker/highlight.min.js') }}"></script>
    <script src="{{ asset('assets/js/time-picker/clockpicker.js') }}"></script>
	@endpush

@endsection