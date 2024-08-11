@extends('layouts.personnel.master')

@section('title')Nouvelles Notes
    {{ $title }}
@endsection

@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datatables.css') }}">
@endpush

@section('content')
	@component('components.personnel.breadcrumb')
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
                        <div class="col-sm-12 col-lg-12 col-xl-12">
							<form action="{{ route('admin.scolarite-post-notes', $matiere->id) }}" method="post">
								@csrf
								<div class="table-responsive">
									<table class="table">
										<thead class="bg-primary">
											<tr>
												<th scope="col">#</th>
												<th scope="col">Nom & Prénoms</th>
												<th scope="col">Note 1</th>
												<th scope="col">Note 2</th>
												<th scope="col">Note 3</th>
											</tr>
										</thead>
										<tbody>
											@foreach ($dataNotes as $dataNote)
												<tr>
													<th scope="row">{{ $loop->iteration }}</th>
													<td>{{ $dataNote['nom_etudiant']->fullname }}</td>
													<td>
														<input class="form-control @error('note_1') is-invalid @enderror" name="{{ $dataNote['nom_etudiant']->id }}[]" value="{{ old('note_1') ?? $dataNote['note_1'] }}" type="number" placeholder="0" />
														@error('note_1')
															<span class="invalid-feedback" role="alert">
																<strong>{{ $message }}</strong>
															</span>
														@enderror
													</td>
													<td>
														<input class="form-control @error('note_2') is-invalid @enderror" name="{{ $dataNote['nom_etudiant']->id }}[]" value="{{ old('note_2') ?? $dataNote['note_2'] }}" type="number" placeholder="0" />
														@error('note_2')
															<span class="invalid-feedback" role="alert">
																<strong>{{ $message }}</strong>
															</span>
														@enderror
													</td>
													<td>
														<input class="form-control @error('note_3') is-invalid @enderror" name="{{ $dataNote['nom_etudiant']->id }}[]" value="{{ old('note_3') ?? $dataNote['note_3'] }}" type="number" placeholder="0" />
														@error('note_3')
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