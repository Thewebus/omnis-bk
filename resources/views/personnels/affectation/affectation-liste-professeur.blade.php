@extends('layouts.personnel.master')

@section('title')Affectations Professeurs
    {{ $title }}
@endsection

@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datatables.css') }}">
@endpush

@section('content')
	@component('components.personnel.breadcrumb')
		@slot('breadcrumb_title')
			<h3>Affectations Professeurs</b></h3>
		@endslot
		<li class="breadcrumb-item">Professeur</li>
		{{-- <li class="breadcrumb-item">Data Tables</li> --}}
		<li class="breadcrumb-item active">Affectations</b></li>
	@endcomponent
	
	<div class="container-fluid">
	    <div class="row">
	        <!-- Feature Unable /Disable Order Starts-->
	        <div class="col-sm-12">
	            <div class="card">
	                <div class="card-header">
	                    <h5>Affectations professeur</b></h5>
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
	                                    <th>email</th>
	                                    <th>Action</th>
	                                </tr>
	                            </thead>
	                            <tbody>
									@foreach ($profs as $prof)
	                                <tr>
	                                    <td>{{ $loop->iteration }}</td>
	                                    <td>{{ $prof->fullname }}</td>
	                                    <td><b>{{ $prof->email }}</b></td>
	                                    <td style="width: 13vw">
											<a href="{{ route('admin.scolarite.affectation-professeur', $prof->id) }}" class="btn btn-warning btn-block mt-3"><i class="fa fa-pencil-square-o"></i></a>
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
	@if($errors->any())
		<script>
		$(function() {
			$('#changeModal{{ old('professeur') }}').modal({
				show: true
			});
		});
		</script>
	@endif
	@endpush

@endsection