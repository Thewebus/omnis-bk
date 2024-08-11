@extends('layouts.personnel.master')

@section('title')Liste étudiants
 {{ $title }}
@endsection

@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datatables.css') }}">
@endpush

@section('content')
	@component('components.personnel.breadcrumb')
		@slot('breadcrumb_title')
			<h3>Liste étudiants classe <b>{{ $classe->nom }}</b></h3>
		@endslot
		<li class="breadcrumb-item">Liste étudiants</li>
		{{-- <li class="breadcrumb-item">Data Tables</li> --}}
		<li class="breadcrumb-item active">Classe <b>{{ $classe->nom }}</b></li>
	@endcomponent
	
	<div class="container-fluid">
	    <div class="row">
	        <!-- Feature Unable /Disable Order Starts-->
	        <div class="col-sm-12">
	            <div class="card">
	                <div class="card-header">
	                    <h5>Liste des étudiants classe <b>{{ $classe->nom }}</b></h5>
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
	                                    <th>Faculté</th>
	                                    <th>Action</th>
	                                </tr>
	                            </thead>
	                            <tbody>
									@foreach ($classe->etudiants->sortBy('fullname') as $etudiant)
	                                <tr>
	                                    <td>{{ $loop->iteration }}</td>
	                                    <td>{{ $etudiant->fullname }}</td>
	                                    <td><b>{{ $classe->niveauFaculte->faculte->nom }}</b></td>
	                                    <td style="width: 13vw">
											<a href="{{ route('admin.scolarite-inscritpion-detail', $etudiant->inscriptions->last()->id) }}" class="btn  btn-success"><i class="fa fa-eye"></i></a>
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