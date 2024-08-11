@extends('layouts.professeur.master')

@section('title')Ressource cours
 {{ $title }}
@endsection

@push('css')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/dropzone.css')}}">
@endpush

@section('content')
	@component('components.professeur.breadcrumb')
		@slot('breadcrumb_title')
			<h3>Ressource cours</h3>
		@endslot
		{{-- <li class="breadcrumb-item">Tableau de bord</li> --}}
		<li class="breadcrumb-item active">Ressource cours</li>
	@endcomponent
	
	<div class="container-fluid">
	    <div class="row">
			<div class="col-xl-12 col-md-12 box-col-12">
				<div class="file-content">
					<div class="card">
						<div class="card-header">
							{{-- <div class="media">
								<form class="form-inline" action="#" method="get">
									<div class="form-group d-flex mb-0"> <i class="fa fa-search"></i>
										<input class="form-control-plaintext" type="text" placeholder="Search...">
									</div>
								</form>
								<div class="media-body text-end">
								<form class="d-inline-flex" action="#" method="POST" enctype="multipart/form-data" name="myForm">
									<div class="btn btn-primary" onclick="getFile()"> <i data-feather="plus-square"></i>Add New</div>
									<div style="height: 0px;width: 0px; overflow:hidden;">
									<input id="upfile" type="file" onchange="sub(this)">
									</div>
								</form>
								<div class="btn btn-outline-primary ms-2"><i data-feather="upload">   </i>Upload  </div>
								</div>
							</div> --}}
						</div>
						<div class="card-body file-manager">
							<h4>Ressources</h4>
							@foreach ($allData as $data)
								<h5 class="mt-4">{{ $data['classe_nom'] }}</h5>
									<ul class="folder">
										@foreach ($data['matieres'] as $matiere)
											{{-- <li class="folder-box m-1">
												<a href="{{ route('prof.ressource-show', $matiere['matiere_id']) }}">
													<div class="media"><i class="fa fa-folder f-36 txt-warning"></i>
														<div class="media-body ms-3">
															<h6 class="mb-0">{{ $matiere['matiere_nom'] }}</h6>
															<p>101 files, 10mb</p>
														</div>
													</div>
												</a>
											</li> --}}
											<li class="folder-box m-1">
												<form action="{{ route('prof.ressource-show') }}" method="post">
													@csrf
													<div class="media"><i class="fa fa-folder f-36 txt-warning"></i>
														<div class="media-body ms-3">
															<input type="hidden" name="matiere" value="{{ $matiere['matiere_id'] }}">
															<input type="hidden" name="classe" value="{{ $data['classe_id'] }}">
															<button class="btn">{{ $matiere['matiere_nom'] }}</button>
															{{-- <h6 class="mb-0">{{ $matiere['matiere_nom'] }}</h6> --}}
															{{-- <p>101 files, 10mb</p> --}}
														</div>
													</div>
												</form>
											</li>
										@endforeach
									</ul>
							@endforeach
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