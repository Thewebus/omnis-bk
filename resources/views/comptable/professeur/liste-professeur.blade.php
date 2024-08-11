@extends('layouts.comptable.master')

@section('title', 'Liste Professeurs')

@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datatables.css') }}">
@endpush

@section('content')
	@component('components.comptable.breadcrumb')
		@slot('breadcrumb_title')
			<h3>Liste Professeurs</h3>
		@endslot
		<li class="breadcrumb-item active">Liste de tous les professeurs</li>
		{{-- <li class="breadcrumb-item">Data Tables</li> --}}
		{{-- <li class="breadcrumb-item active">Liste des etudiants</li> --}}
	@endcomponent
	
	<div class="container-fluid">
	    <div class="row">
	        <!-- Feature Unable /Disable Order Starts-->
	        <div class="col-sm-12">
	            <div class="card">
	                <div class="card-header">
	                    <h5>Liste des Professeurs</h5>
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
	                                    <th>Action</th>
	                                </tr>
	                            </thead>
	                            <tbody>
									@foreach ($professeurs as $professeur)
	                                <tr>
	                                    <td>{{ $loop->iteration }}</td>
	                                    <td>{{ $professeur->fullname }}</td>
	                                    <td class="text-center">
											<a href="{{ route('admin.comptable-details-professeurs', $professeur->id) }}" class="btn btn-primary btn-block mt-3"><i class="fa fa-eye"></i> Voir</a>
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