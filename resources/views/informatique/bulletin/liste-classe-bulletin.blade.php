@extends('layouts.informatique.master')

@section('title')Liste classes
 {{ $title }}
@endsection

@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datatables.css') }}">
@endpush

@section('content')
	@component('components.informatique.breadcrumb')
		@slot('breadcrumb_title')
			<h3>Liste classes</h3>
		@endslot
		<li class="breadcrumb-item">classes</li>
		{{-- <li class="breadcrumb-item">Data Tables</li> --}}
		<li class="breadcrumb-item active">Liste des classes</li>
	@endcomponent
	
	<div class="container-fluid">
	    <div class="row">
	        <!-- Feature Unable /Disable Order Starts-->
	        <div class="col-sm-12">
	            <div class="card">
	                <div class="card-header">
	                    <h5>Liste des classes {{ $systeme }} bulletin session {{ $session }}</h5>
	                    {{-- <span>Disabling features that you don't wish to use for a particular table is easily done by setting a variable in the initialisation object</span>
	                    <span>In the following example only the search feature is left enabled (which it is by default).</span> --}}
	                </div>
	                <div class="card-body">
	                    <div class="table-responsive">
	                        <table class="display" id="basic-2">
	                            <thead>
	                                <tr>
	                                    <th>N°</th>
	                                    <th>Nom</th>
	                                    <th>Faculté</th>
	                                    <th>Action</th>
	                                </tr>
	                            </thead>
	                            <tbody>
									@foreach ($classes as $classe)
	                                <tr>
	                                    <td>{{ $loop->iteration }}</td>
	                                    <td><a href="{{ route('admin.liste-classe-etudiants', $classe->id) }}">{{ $classe->nom }}</a></td>
	                                    <td>{{ $classe->niveauFaculte->faculte->nom ?? __('no filière') }}</td>
	                                    <td style="width: 18%">
											@php
												$route = $systeme == 'licence' ? 'admin.bulletins' : 'admin.bulletins-bts';
											@endphp
											<form action="{{ route($route, $classe->id) }}" method="post" style="display: inline-block">
												@csrf
												<input type="hidden" name="semestre" value="1">
												<input type="hidden" name="session" value="{{ $session }}">
												<button type="submit" class="btn btn-secondary">Semestre 1</button>
											</form>

											<form action="{{ route($route, $classe->id) }}" method="post" style="display: inline-block">
												@csrf
												<input type="hidden" name="semestre" value="2">
												<input type="hidden" name="session" value="{{ $session }}">
												<button type="submit" class="btn btn-primary">Semestre 2</button>
											</form>
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