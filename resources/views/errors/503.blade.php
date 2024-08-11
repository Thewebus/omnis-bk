@extends('errors.master')

@section('title')Maintenance
 {{ $title }}
@endsection

@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/sweetalert2.css') }}">
@endpush

@section('content')
	<section class="maintenance-sec">
	    <div class="page-wrapper">
	        <div class="error-wrapper maintenance-bg">
	            <div class="container">
	                <ul class="maintenance-icons">
	                    <li><i class="fa fa-cog"></i></li>
	                    <li><i class="fa fa-cog"></i></li>
	                    <li><i class="fa fa-cog"></i></li>
	                </ul>
	                <div class="maintenance-heading">
	                    <h2 class="headline">MAINTENANCE</h2>
	                </div>
	                <h4 class="sub-content">
	                    Notre site est actuellement en maintenance Nous serons de retour sous peu<br />
	                    Merci pour votre patience.
	                </h4>
	                {{-- <div><a class="btn btn-primary btn-lg text-light" href="{{ route('index') }}">BACK TO HOME PAGE</a></div> --}}
	            </div>
	        </div>
	    </div>
	</section>


    @push('scripts')
    <script src="{{ asset('assets/js/sweet-alert/sweetalert.min.js') }}"></script>
    @endpush

@endsection