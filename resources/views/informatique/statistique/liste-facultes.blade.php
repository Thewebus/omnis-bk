@extends("layouts.informatique.master")

@section('title')Statistiques Liste Faculté
 {{ $title }}
@endsection

@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datatables.css') }}">
@endpush

@section('content')
	@component("components.informatique.breadcrumb")
		@slot('breadcrumb_title')
			<h3>Statistiques Liste faculté</h3>
		@endslot
		<li class="breadcrumb-item"><a href="{{ route('admin.facultes.index') }}">Facultés</a> </li>
		{{-- <li class="breadcrumb-item">Data Tables</li> --}}
		<li class="breadcrumb-item active">Statistiques Liste des Faculté</li>
	@endcomponent
	
	<div class="container-fluid">
	    <div class="row">
	        <!-- Feature Unable /Disable Order Starts-->
	        <div class="col-sm-12">
	            <div class="card">
	                <div class="card-header">
	                    <h5>Statistiques Liste des Faculté</h5>
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
	                                    <th>Action</th>
	                                </tr>
	                            </thead>
	                            <tbody>
									@foreach ($facultes as $faculte)
	                                <tr>
	                                    <td>{{ $loop->iteration }}</td>
	                                    <td>{{ $faculte->nom }}</td>
	                                    <td style="width: 11vw">
											<button class="btn btn-warning btn-block mb-3" type="button" data-bs-toggle="modal" data-bs-target="#createModal{{ $faculte->id }}"><i class="fa fa-plus"></i> Statistique</button>
											<div class="modal fade" id="createModal{{ $faculte->id }}" tabindex="-1" role="dialog" aria-labelledby="createModal{{ $faculte->id }}" aria-hidden="true">
												<div class="modal-dialog modal-dialog-centered" role="document">
													<form class="form theme-form" action="{{ route('admin.statisques-facultes-post') }}" method="POST">
														@csrf
														<div class="modal-content">
															<div class="modal-header">
																<h5 class="modal-title">Option statistique</h5>
																<button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
															</div>
															<div class="modal-body">
																<div class="card-body">
																	<div class="row">
																		<div class="col">
																			<div class="mb-3 row">
																				<label for="option_stat" class="col-form-label text-center">Niveau / Cycle</label>
																				<div class="col-sm-12">
																					<select class="form-select digits @error('option_stat') is-invalid @enderror" id="option_stat" name="option_stat" >
																						<optgroup label="LICENCE">
																							<option value="licence 1" {{ old('option_stat') == 'licence 1' ? 'selected' : '' }}>LICENCE 1</option>
																							<option value="licence 2" {{ old('option_stat') == 'licence 2' ? 'selected' : '' }}>LICENCE 2</option>
																							<option value="licence 3" {{ old('option_stat') == 'licence 3' ? 'selected' : '' }}>LICENCE 3</option>
																						</optgroup>
																						<optgroup label="MASTER">
																							<option value="master 1" {{ old('option_stat') == 'master 1' ? 'selected' : '' }}>MASTER 1</option>
																							<option value="master 2" {{ old('option_stat') == 'master 2' ? 'selected' : '' }}>MASTER 2</option>
																						</optgroup>
																						<optgroup label="CYCLE">
																							<option value="licence" {{ old('option_stat') == 'licence' ? 'selected' : '' }}>CYCLE LICENCE</option>
																							<option value="master" {{ old('option_stat') == 'master' ? 'selected' : '' }}>CYCLE MASTER</option>
																						</optgroup>
																					</select>

																					<input type="hidden" name="faculte_id" value="{{ $faculte->id }}">
																					@error('option_stat')
																						<span class="invalid-feedback" role="alert">
																							<strong>{{ $message }}</strong>
																						</span>
																					@enderror
																				</div>
																			</div>
																			<div class="mb-3 row">
																				<label for="session" class="col-form-label text-center">Session</label>
																				<div class="col-sm-12">
																					<select class="form-select digits @error('session') is-invalid @enderror" id="session" name="session">
																						<option value="1" {{ old('session') == '1' ? 'selected' : '' }}>SESSION 1</option>
																						<option value="2" {{ old('session') == '2' ? 'selected' : '' }}>SESSION 2</option>
																					</select>
																					@error('session')
																						<span class="invalid-feedback" role="alert">
																							<strong>{{ $message }}</strong>
																						</span>
																					@enderror
																				</div>
																			</div>
																			<div class="mb-3 row">
																				<label for="semestre" class="col-form-label text-center">Semestre</label>
																				<div class="col-sm-12">
																					<select class="form-select digits @error('semestre') is-invalid @enderror" id="semestre" name="semestre">
																						<option value="1" {{ old('semestre') == '1' ? 'selected' : '' }}>SEMESTRE 1</option>
																						<option value="2" {{ old('semestre') == '2' ? 'selected' : '' }}>SEMESTRE 2</option>
																					</select>
																					@error('semestre')
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
																<button class="btn btn-primary" type="submit"><i class="fa fa-save"></i> Satistiques</button>
																<button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
															</div>
														</div>
													</form>													
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