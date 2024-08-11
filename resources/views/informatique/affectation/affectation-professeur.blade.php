@extends('layouts.informatique.master')

@section('title')Affectations professeur
    {{ $title }}
@endsection

@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/select2.css') }}">
@livewireStyles
@endpush

@section('content')
	@component('components.informatique.breadcrumb')
		@slot('breadcrumb_title')
			<h3>Affectations professeur</b></h3>
		@endslot
		<li class="breadcrumb-item">professeurs</li>
		{{-- <li class="breadcrumb-item">Data Tables</li> --}}
		<li class="breadcrumb-item active">Affectations</b></li>
	@endcomponent
	
	<div class="container-fluid">
	    <div class="row">
	        <!-- Feature Unable /Disable Order Starts-->
	        <div class="col-sm-12">
	            <div class="card">
	                <div class="card-header">
	                    <h5>Affectations professeurs</b></h5>
	                    <h6>Selectionner les matières à affecter au professeur <strong>{{ $professeur->fullname }}</strong> </h6>
	                    {{-- <span>In the following example only the search feature is left enabled (which it is by default).</span> --}}
	                </div>
	                <div class="card-body">
						@if (session('error'))
							<div class="alert alert-danger text-center" role="alert">
								{{ session('error') }}
							</div>
						@endif
						<form action="{{ route('admin.post-affectation-professeur', $professeur->id) }}" method="post">
							@csrf
							
							<livewire:affectation-professeur>

							<div class="row mb-2">
								<label class="col-sm-3 col-form-label"></label>
								<div class="col-sm-9">
									<button style="width: 50%" class="btn btn-block btn-primary">Affecter</button>
								</div>
							</div>
						</form>
	                </div>
	            </div>
	        </div>
	        <!-- Feature Unable /Disable Ends-->
	    </div>
	</div>

	
	@push('scripts')
    <script src="{{ asset('assets/js/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/js/select2/select2-custom.js') }}"></script>
    @livewireScripts
	@endpush

@endsection