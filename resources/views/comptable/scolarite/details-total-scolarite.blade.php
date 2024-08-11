@extends('layouts.comptable.master')

@section('title', 'Scolarité par classe')

@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datatables.css') }}">
@endpush

@section('content')
	@component('components.breadcrumb')
		@slot('breadcrumb_title')
			<h3>Scolarité 
				@if ($scolariteClasseData['statut'] == 'scolariteParClasse')
					Totale
				@elseif($scolariteClasseData['statut'] == 'scolaritePayeeParClasse')
					payée 
				@else
					restante 
				@endif
				par classe
			</h3>
		@endslot
		<li class="breadcrumb-item active">Scolarité par classe</li>
		{{-- <li class="breadcrumb-item">Data Tables</li> --}}
		{{-- <li class="breadcrumb-item active">Liste des etudiants</li> --}}
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
	                                    <th>Classes</th>
	                                    <th>Niveaux</th>
	                                    <th>Filières</th>
	                                    <th>
											Scolarité 
											@if ($scolariteClasseData['statut'] == 'scolariteParClasse')
												Totale 
											@elseif ($scolariteClasseData['statut'] == 'scolaritePayeeParClasse')
												payée
											@else
												Restante
											@endif
										</th>
	                                </tr>
	                            </thead>
	                            <tbody>
									@foreach ($scolariteClasseData as $scolariteData)
										@if ($loop->iteration > 1)
											<tr>
												<td>{{ $loop->index}}</td>
												<td>{{ $scolariteData['nom'] }}</td>
												<td>{{ $scolariteData['niveau'] ?? __('NAN') }}</td>
												<td>{{ $scolariteData['filiere'] ?? __('NAN') }}</td>
												<td>{{ $scolariteData['scolarite'] }}</td>
											</tr>
										@endif
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