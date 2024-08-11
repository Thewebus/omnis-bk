@extends('layouts.informatique.master')

@section('title')Notes
    {{ $title }}
@endsection

@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datatables.css') }}">
@endpush

@section('content')
	@component('components.informatique.breadcrumb')
		@slot('breadcrumb_title')
			<h3>Toutes les notes</h3>
		@endslot
		<li class="breadcrumb-item">Liste</li>
		<li class="breadcrumb-item active">Toutes les notes</li>
	@endcomponent
	
	<div class="container-fluid">
	    <div class="row">
			<div class="col-sm-12">
				<div class="card">
					<div class="card-header">
						<span style="font-size: 1rem">Toutes les notes, matière : <b>{{ $matiere->nom }}</b>, classe : <b>{{ $classe }}</b></span>
                        <a href="{{ route('admin.add-notes', $matiere->id) }}" class="btn btn-primary btn-block mt-3 float-right">
							<i class="fa fa-plus"></i> Nouvelle note
						</a>

						<a href="{{ route('admin.liste-etudiant-session-2', $matiere->id) }}" class="btn btn-warning btn-block mt-3">
							<i class="fa fa-download"></i> Liste étudiant session 2
						</a>
					</div>
                    <div class="card-block row">
                        <div class="col-sm-12 col-lg-12 col-xl-12">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="bg-primary">
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Nom & Prénoms</th>
											@foreach ($notesSelectionnees as $notesSelectionnee)
                                            	<th scope="col">
													@if ($notesSelectionnee == 'partiel_session_1')
														Partiel sess. 1
													@else
														Note {{ $loop->iteration }}
													@endif
												</th>
											@endforeach
                                            <th scope="col">Moyenne</th>
                                            <th scope="col">Dec. finale</th>
                                        </tr>
                                    </thead>
                                    <tbody>
										@foreach ($dataNotes as $dataNote)
											<tr>
												<th scope="row">{{ $loop->iteration }}</th>
												<td>{{ $dataNote['nom_etudiant']->fullname }}</td>
												@foreach ($notesSelectionnees as $notesSelectionnee)
													<td>{{ $dataNote[$notesSelectionnee] }}</td>
												@endforeach
												<td>{{ $dataNote['moyenne'] }}</td>
												<td>
													@if ($dataNote['decision_finale'] == 'admis')
														<span class="badge badge-primary">Admis</span>
													@elseif($dataNote['decision_finale'] == 'ajourné')
														<span class="badge badge-danger">Ajourné</span>
													@else
														<span class="badge badge-warning">NONE</span>
													@endif
												</td>
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
	</div>

	
	@push('scripts')
	<script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}"></script>
	@endpush

@endsection