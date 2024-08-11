@extends('layouts.comptable.master')

@section('title', 'Tableau de bord comptable')

@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datatables.css') }}">
@endpush

@section('content')
	@component('components.breadcrumb')
		@slot('breadcrumb_title')
			<h3>Scolarité</h3>
		@endslot
		<li class="breadcrumb-item active">Tous les scolarité</li>
		{{-- <li class="breadcrumb-item">Data Tables</li> --}}
		{{-- <li class="breadcrumb-item active">Liste des etudiants</li> --}}
	@endcomponent
	
	<div class="container-fluid">
	    <div class="row">
	        <!-- Feature Unable /Disable Order Starts-->
	        <div class="col-sm-12">
	            <div class="card">
	                <div class="card-header">
	                    <h5>Liste des étudiants</h5>
	                    {{-- <span>Disabling features that you don't wish to use for a particular table is easily done by setting a variable in the initialisation object</span>
	                    <span>In the following example only the search feature is left enabled (which it is by default).</span> --}}
	                </div>
	                <div class="card-body">
	                    <div class="table-responsive">
	                        <table class="display" id="basic-2">
	                            <thead>
	                                <tr>
	                                    <th>N°</th>
	                                    <th>Nom & Présnom</th>
	                                    <th>Classe</th>
	                                    <th>Filière</th>
	                                    <th>Action</th>
	                                </tr>
	                            </thead>
	                            <tbody>
									@foreach ($etudiants as $etudiant)
	                                <tr>
	                                    <td>{{ $loop->iteration }}</td>
	                                    <td>{{ $etudiant->fullname }}</td>
	                                    <td>{{ $etudiant->classe($anneeAcademique->id)->nom ?? __('NAN') }}</td>
	                                    <td>{{ $etudiant->classe($anneeAcademique->id)->niveauFaculte->faculte->nom ?? __('NAN') }}</td>
	                                    <td>
											<a href="{{ route('admin.etudiant-scolarite', $etudiant->id) }}"><button  class="btn btn-primary btn-block mt-3"><i class="fa fa-eye"></i> Voir</button> </a>
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