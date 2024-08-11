@extends('layouts.personnel.master')

@section('title')Notes partiel
    {{ $title }}
@endsection

@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datatables.css') }}">
@endpush

@section('content')
	@component('components.personnel.breadcrumb')
		@slot('breadcrumb_title')
			<h3>Notes partiel</h3>
		@endslot
		<li class="breadcrumb-item">Liste</li>
		<li class="breadcrumb-item active">Notes partiel</li>
	@endcomponent
	
	<div class="container-fluid">
	    <div class="row">
			<div class="col-sm-12">
				<div class="card">
					<div class="card-header">
						<span style="font-size: 1rem">Notes partiel, matière : <b>{{ $matiere->nom }}</b>, classe : <b>{{ $classe }}</b></span>
					</div>
                    <div class="card-block row">
                        <div class="col-sm-12 col-lg-12 col-xl-12">
							<form action="{{ route('admin.scolarite-post-notes-partiel', $matiere->id) }}" method="post">
								@csrf
								<div class="table-responsive">
									<table class="table">
										<thead class="bg-primary">
											<tr>
												<th scope="col">#</th>
												<th scope="col">Nom & Prénoms</th>
												<th scope="col">Partiel</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>#</td>
												<td>SESSION</td>
												<td>
													<select class="form-select digits @error('session') is-invalid @enderror" name="session">
														<option value="">Choisir le Session</option>
														<option value="partiel_session_1" {{ old('partiel_session_1') == 'partiel_session_1' ? 'selected' : '' }}>1er Session</option>
														<option value="partiel_session_2" {{ old('partiel_session_2') == 'partiel_session_2' ? 'selected' : '' }}>2e Session</option>
													</select>
													@error('session')
														<span class="invalid-feedback" role="alert">
															<strong>{{ $message }}</strong>
														</span>
													@enderror
												</td>
											</tr>
											<tr>
												<td>#</td>
												<td>SYSTEME DE CALCULE</td>
												<td>
													<div class="form-group m-t-10 m-checkbox-inline mb-0 custom-radio-ml">
														<div class="radio radio-primary">
															<input class="radio_animated" id="normal" type="radio" name="systeme" value="normal" checked>
															<label class="mb-0" for="normal">NORMAL</label>
														</div>
														<div class="radio radio-primary">
															<input class="radio_animated" id="lmd" type="radio" name="systeme" value="lmd">
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
													<td>{{ $dataNote['nom_etudiant']->fullname }}</td>
													<td>
														<input class="form-control @error('partiel_session_1') is-invalid @enderror" name="{{ $dataNote['nom_etudiant']->id }}" value="{{ old('partiel_session_1') ?? $dataNote['partiel_session_1'] }}" type="number" placeholder="0" />
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
	@endpush

@endsection