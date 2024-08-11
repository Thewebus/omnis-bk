@extends('layouts.etudiant.master')

@section('title')Ressource cours
 {{ $title }}
@endsection

@push('css')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/dropzone.css')}}">
@endpush

@section('content')
    @component('components.etudiant.breadcrumb')
        @slot('breadcrumb_title')
			<h3>Ressource cours</h3>
		@endslot
		{{-- <li class="breadcrumb-item">Tableau de bord</li> --}}
		<li class="breadcrumb-item"><a href="{{ route('user.ressource-index') }}">Ressource cours</a></li>
		<li class="breadcrumb-item active">{{ $matiere->nom }}</li>
	@endcomponent
	
	<div class="container-fluid">
	    <div class="row">
			<div class="col-xl-12 col-md-12 box-col-12">
				<div class="file-content">
					<div class="card">
						<div class="card-header">
						</div>
						<div class="card-body file-manager">
							<h4>{{ $matiere->nom }}</h4>
							<h5 class="mt-4">Fichiers</h5>
							<ul class="files">
								@if ($ressources->count())
									@foreach ($ressources as $ressource)
										<li class="file-box">
											<a href="{{ asset(str_replace('public', 'storage', $ressource->path)) }}">
												<div class="file-top">  <i class="fa fa-file-text-o txt-info"></i></div>
												<div class="file-bottom">
													<h6 class="text-center">{{ $ressource->nom }}</h6>
												</div>
											</a>
										</li>
									@endforeach
								@else
									<div class="alert alert-warning dark alert-dismissible fade show text-center" role="alert">
										<h5>Aucune ressource pour le moment</h5>
										<button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
									</div>
								@endif
							</ul>
						</div>
					</div>
				</div>
			</div>
	    </div>
	</div>
	
	@push('scripts')
	<script src="{{asset('assets/js/dropzone/dropzone.js')}}"></script>
    <script src="{{asset('assets/js/dropzone/dropzone-script.js')}}"></script>
	@endpush

@endsection