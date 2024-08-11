@extends('layouts.etudiant.master')

@section('title')Matières
    {{ $title }}
@endsection

@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datatables.css') }}">
@endpush

@section('content')
	@component('components.etudiant.breadcrumb')
		@slot('breadcrumb_title')
			<h3>Liste des matières</h3>
		@endslot
		<li class="breadcrumb-item">Liste</li>
		<li class="breadcrumb-item active">Liste des matières</li>
	@endcomponent
	
	<div class="container-fluid">
	    <div class="row">
			<div class="col-sm-12">
				<div class="card">
					<div class="card-header">
						<span style="font-size: 1rem">Notes matières semestre 1</span>
					</div>
					<div class="card-block row">
                        <div class="col-sm-12 col-lg-12 col-xl-12">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="bg-primary">
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Matières</th>
                                            <th scope="col">Note 1</th>
                                            <th scope="col">Note 2</th>
                                            <th scope="col">Note 3</th>
                                            <th scope="col">Note 4</th>
                                            <th scope="col">Note 5</th>
                                            <th scope="col">Note 6</th>
                                            <th scope="col">Moyenne</th>
                                            <th scope="col">Partiel sess. 1</th>
                                            <th scope="col">Partiel sess. 2</th>
                                            {{-- <th scope="col">Partiel sess. 2</th> --}}
                                            {{-- <th scope="col">Dec. finale</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
										@foreach ($dataNotesSem1 as $dataNote)
											<tr>
												<th scope="row">{{ $loop->iteration }}</th>
												<td>{{ $dataNote['nom_matiere'] }}</td>
												<td>{{ $dataNote['note_1'] }}</td>
												<td>{{ $dataNote['note_2'] }}</td>
												<td>{{ $dataNote['note_3'] }}</td>
												<td>{{ $dataNote['note_4'] }}</td>
												<td>{{ $dataNote['note_5'] }}</td>
												<td>{{ $dataNote['note_6'] }}</td>
												<td>{{ $dataNote['moyenne'] }}</td>
												<td>{{ $dataNote['partiel_session_1'] }}</td>
												<td>{{ $dataNote['partiel_session_2'] }}</td>
												{{-- <td>{{ $dataNote['partiel_session_2'] }}</td> --}}
												{{-- <td>
													@if ($dataNote['decision_finale'] == 'admis')
														<span class="badge badge-primary">Admis</span>
													@elseif($dataNote['decision_finale'] == 'ajourné')
														<span class="badge badge-danger">Ajourné</span>
													@else
														<span class="badge badge-warning">NONE</span>
													@endif
												</td> --}}
											</tr>
										@endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
				</div>
			</div>

			@isset($dataNotesSem2)
				<div class="col-sm-12">
					<div class="card">
						<div class="card-header">
							<span style="font-size: 1rem">Notes matières semestre 2</span>
						</div>
						<div class="card-block row">
							<div class="col-sm-12 col-lg-12 col-xl-12">
								<div class="table-responsive">
									<table class="table">
										<thead class="bg-primary">
											<tr>
												<th scope="col">#</th>
												<th scope="col">Matières</th>
												<th scope="col">Note 1</th>
												<th scope="col">Note 2</th>
												<th scope="col">Note 3</th>
												<th scope="col">Note 4</th>
												<th scope="col">Note 5</th>
												<th scope="col">Note 6</th>
												<th scope="col">Moyenne</th>
												<th scope="col">Partiel sess. 1</th>
												<th scope="col">Partiel sess. 2</th>
												{{-- <th scope="col">Partiel sess. 2</th> --}}
												{{-- <th scope="col">Dec. finale</th> --}}
											</tr>
										</thead>
										<tbody>
											@foreach ($dataNotesSem2 as $dataNote)
												<tr>
													<th scope="row">{{ $loop->iteration }}</th>
													<td>{{ $dataNote['nom_matiere'] }}</td>
													<td>{{ $dataNote['note_1'] }}</td>
													<td>{{ $dataNote['note_2'] }}</td>
													<td>{{ $dataNote['note_3'] }}</td>
													<td>{{ $dataNote['note_4'] }}</td>
													<td>{{ $dataNote['note_5'] }}</td>
													<td>{{ $dataNote['note_6'] }}</td>
													<td>{{ $dataNote['moyenne'] }}</td>
													<td>{{ $dataNote['partiel_session_1'] }}</td>
													<td>{{ $dataNote['partiel_session_2'] }}</td>
													{{-- <td>{{ $dataNote['partiel_session_2'] }}</td> --}}
													{{-- <td>
														@if ($dataNote['decision_finale'] == 'admis')
															<span class="badge badge-primary">Admis</span>
														@elseif($dataNote['decision_finale'] == 'ajourné')
															<span class="badge badge-danger">Ajourné</span>
														@else
															<span class="badge badge-warning">NONE</span>
														@endif
													</td> --}}
												</tr>
											@endforeach
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			@endisset
		</div>
	</div>

	
	@push('scripts')
	<script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}"></script>
	@endpush

@endsection