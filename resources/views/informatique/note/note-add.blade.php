@extends('layouts.informatique.master')

@section('title')Nouvelles Notes
    {{ $title }}
@endsection

@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datatables.css') }}">
@endpush

@section('content')
	@component('components.informatique.breadcrumb')
		@slot('breadcrumb_title')
			<h3>Nouvelles notes</h3>
		@endslot
		<li class="breadcrumb-item">Liste</li>
		<li class="breadcrumb-item active">Nouvelles notes</li>
	@endcomponent
	
	<div class="container-fluid">
	    <div class="row">
			<div class="col-sm-12">
				<div class="card">
					<div class="card-header">
						<span style="font-size: 1rem">Nouvelles notes, matière : <b>{{ $matiere->nom }}</b>, classe : <b>{{ $classe }}</b></span>
					</div>
                    <div class="card-block row">
						@if (session()->has('errors'))
							<div class="card-body">
								<div class="alert alert-danger dark alert-dismissible fade show" role="alert">
									<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-triangle"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12" y2="17"></line></svg>
									<p  class="text-center"><span style="font-size: 1.1rem"> {{ $errors }} </span></p>
									<button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close" data-bs-original-title="" title=""></button>
								</div>
							</div>
						@endif
                        <div class="col-sm-12 col-lg-12 col-xl-12">
							<form action="{{ route('admin.post-notes', $matiere->id) }}" method="post">
								@csrf
								<div class="table-responsive">
									<table class="table">
										<thead class="bg-primary">
											<tr>
												<th scope="col">#</th>
												<th scope="col"></th>
												<th scope="col">Nom & Prénoms</th>
												<th scope="col">Note 1</th>
												<th scope="col">Note 2</th>
												<th scope="col">Note 3</th>
												<th scope="col">Note 4</th>
												<th scope="col">Note 4</th>
												<th scope="col">Note 6</th>
												<th scope="col">Partiel</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>
													<div class="mt-2">
														#
													</div>
												</td>
												<td>
													<div class="mt-2"></div>
												</td>
												<td>
													<div class="mt-2">
														Notes valides
													</div>
												</td>
												<td>
													<div class="checkbox">
														<input id="note_1" name="note_1" type="checkbox" @if(in_array('note_1', $notes_selectionnees)) checked @endif>
														<label for="note_1">Note 1</label>
													</div>
												</td>
												<td>
													<div class="checkbox">
														<input id="note_2" name="note_2" type="checkbox" @if(in_array('note_2', $notes_selectionnees)) checked @endif>
														<label for="note_2">Note 2</label>
													</div>
												</td>
												<td>
													<div class="checkbox">
														<input id="note_3" name="note_3" type="checkbox" @if(in_array('note_3', $notes_selectionnees)) checked @endif>
														<label for="note_3">Note 3</label>
													</div>
												</td>
												<td>
													<div class="checkbox">
														<input id="note_4" name="note_4" type="checkbox" @if(in_array('note_4', $notes_selectionnees)) checked @endif>
														<label for="note_4">Note 4</label>
													</div>
												</td>
												<td>
													<div class="checkbox">
														<input id="note_5" name="note_5" type="checkbox" @if(in_array('note_5', $notes_selectionnees)) checked @endif>
														<label for="note_5">Note 5</label>
													</div>
												</td>
												<td>
													<div class="checkbox">
														<input id="note_6" name="note_6" type="checkbox" @if(in_array('note_6', $notes_selectionnees)) checked @endif>
														<label for="note_6">Note 6</label>
													</div>
												</td>
												<td>
													<div class="checkbox">
														<input id="partiel_session_1" name="partiel_session_1" type="checkbox" @if(in_array('partiel_session_1', $notes_selectionnees)) checked @endif>
														<label for="partiel_session_1">Partiel</label>
													</div>
												</td>
											</tr>
											<tr>
												<td></td>
												<td></td>
												<td>Système de calcule</td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td>
													<div class="form-group m-t-10 m-checkbox-inline mb-0 custom-radio-ml">
														<div class="radio radio-primary">
															<input class="radio_animated" id="normal" type="radio" name="systeme" value="normal" {{ $systemeCalcule == 'normal' ? 'checked' : '' }} >
															<label class="mb-0" for="normal">NORMAL</label>
														</div>
														<div class="radio radio-primary">
															<input class="radio_animated" id="lmd" type="radio" name="systeme" value="lmd" {{ $systemeCalcule == 'lmd' ? 'checked' : '' }}>
															<label class="mb-0" for="lmd">LMD</label>
														</div>
													</div>
													@error('systeme')
														<span class="invalid-feedback" role="alert">
															<strong>{{ $message }}</strong>
														</span>
													@enderror
												</td>
											</tr>
											@foreach ($dataNotes as $dataNote)
												<tr>
													<th scope="row">{{ $loop->iteration }}</th>
													<td>
														<input id="{{ $dataNote['nom_etudiant']->fullname }}" name="{{ $dataNote['nom_etudiant']->id }}[]" type="checkbox" checked>
													</td>
													<td>
														<label for="{{ $dataNote['nom_etudiant']->fullname }}">{{ $dataNote['nom_etudiant']->fullname }}</label>
 													</td>
													<td>
														<input class="form-control @error('note_1') is-invalid @enderror" name="{{ $dataNote['nom_etudiant']->id }}[]" value="{{ old('note_1') ?? $dataNote['note_1'] }}" type="number" step="0.01" min="0" max="20" onchange="checkMaxNote(this.value)" placeholder="0" />
														@error('note_1')
															<span class="invalid-feedback" role="alert">
																<strong>{{ $message }}</strong>
															</span>
														@enderror
													</td>
													<td>
														<input class="form-control @error('note_2') is-invalid @enderror" name="{{ $dataNote['nom_etudiant']->id }}[]" value="{{ old('note_2') ?? $dataNote['note_2'] }}" type="number" step="0.01" min="0" max="20" onchange="checkMaxNote(this.value)" placeholder="0" />
														@error('note_2')
															<span class="invalid-feedback" role="alert">
																<strong>{{ $message }}</strong>
															</span>
														@enderror
													</td>
													<td>
														<input class="form-control @error('note_3') is-invalid @enderror" name="{{ $dataNote['nom_etudiant']->id }}[]" value="{{ old('note_3') ?? $dataNote['note_3'] }}" type="number" step="0.01" min="0" max="20" onchange="checkMaxNote(this.value)" placeholder="0" />
														@error('note_3')
															<span class="invalid-feedback" role="alert">
																<strong>{{ $message }}</strong>
															</span>
														@enderror
													</td>
													<td>
														<input class="form-control @error('note_4') is-invalid @enderror" name="{{ $dataNote['nom_etudiant']->id }}[]" value="{{ old('note_4') ?? $dataNote['note_4'] }}" type="number" step="0.01" min="0" max="20" onchange="checkMaxNote(this.value)" placeholder="0" />
														@error('note_4')
															<span class="invalid-feedback" role="alert">
																<strong>{{ $message }}</strong>
															</span>
														@enderror
													</td>
													<td>
														<input class="form-control @error('note_5') is-invalid @enderror" name="{{ $dataNote['nom_etudiant']->id }}[]" value="{{ old('note_5') ?? $dataNote['note_5'] }}" type="number" step="0.01" min="0" max="20" onchange="checkMaxNote(this.value)" placeholder="0" />
														@error('note_5')
															<span class="invalid-feedback" role="alert">
																<strong>{{ $message }}</strong>
															</span>
														@enderror
													</td>
													<td>
														<input class="form-control @error('note_6') is-invalid @enderror" name="{{ $dataNote['nom_etudiant']->id }}[]" value="{{ old('note_6') ?? $dataNote['note_6'] }}" type="number" step="0.01" min="0" max="20" onchange="checkMaxNote(this.value)" placeholder="0" />
														@error('note_6')
															<span class="invalid-feedback" role="alert">
																<strong>{{ $message }}</strong>
															</span>
														@enderror
													</td>
													<td>
														<input class="form-control @error('partiel_session_1') is-invalid @enderror" name="{{ $dataNote['nom_etudiant']->id }}[]" value="{{ old('partiel_session_1') ?? $dataNote['partiel_session_1'] }}" type="number" step="0.01" min="0" max="20" onchange="checkMaxNote(this.value)" placeholder="0" />
														@error('partiel_session_1')
															<span class="invalid-feedback" role="alert">
																<strong>{{ $message }}</strong>
															</span>
														@enderror
													</td>
												</tr>
											@endforeach
										</tbody>
									</table>
								</div>
								<div class="text-center">
									<button type="submit" class="btn btn-primary btn-block my-3 float-right">
										<i class="fa fa-save"></i> Enregistrez les notes
									</button>
								</div>
							</form>
                        </div>
                    </div>
				</div>
			</div>
		</div>
	</div>

	
	@push('scripts')
	<script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

	<script>
		function checkMaxNote(value) {
			console.log('changement !!!! ' + value)
			if (value < 0) {
				Swal.fire({
					icon: 'error',
					title: 'Alert',
					text: 'La note saisie ne doit pas être inférieure à 0',
				})
			}
			else if(value > 20) {
				Swal.fire({
					icon: 'error',
					title: 'Alert',
					text: 'La note saisie ne doit pas être supérieure à 20',
				})
			}
			else {
				console.log('Tout est OK');
			}
		}
	</script>
	@endpush

@endsection