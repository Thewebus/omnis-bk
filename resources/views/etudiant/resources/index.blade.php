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
									<div class="form-group d-flex mb-0">                                      <i class="fa fa-search"></i>
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
							<h4>Modules</h4>
							{{-- <h6>Recently opened files</h6>
							<ul class="files">
								<li class="file-box">
								<div class="file-top">  <i class="fa fa-file-image-o txt-primary"></i><i class="fa fa-ellipsis-v f-14 ellips"></i></div>
								<div class="file-bottom">
									<h6>Logo.psd </h6>
									<p class="mb-1">2.0 MB</p>
									<p> <b>last open : </b>1 hour ago</p>
								</div>
								</li>
								<li class="file-box">
								<div class="file-top">  <i class="fa fa-file-archive-o txt-secondary"></i><i class="fa fa-ellipsis-v f-14 ellips"></i></div>
								<div class="file-bottom">
									<h6>Project.zip </h6>
									<p class="mb-1">1.90 GB</p>
									<p> <b>last open : </b>1 hour ago</p>
								</div>
								</li>
								<li class="file-box">
								<div class="file-top">  <i class="fa fa-file-excel-o txt-success"></i><i class="fa fa-ellipsis-v f-14 ellips"></i></div>
								<div class="file-bottom">
									<h6>Backend.xls</h6>
									<p class="mb-1">2.00 GB</p>
									<p> <b>last open : </b>1 hour ago</p>
								</div>
								</li>
								<li class="file-box">
								<div class="file-top">  <i class="fa fa-file-text-o txt-info"></i><i class="fa fa-ellipsis-v f-14 ellips"></i></div>
								<div class="file-bottom">
									<h6>requirements.txt </h6>
									<p class="mb-1">0.90 KB</p>
									<p> <b>last open : </b>1 hour ago</p>
								</div>
								</li>
							</ul> --}}
							{{-- <h5 class="mt-4">Module</h5> --}}
							<ul class="folder">
								{{-- <li class="folder-box">
								<div class="media"><i class="fa fa-file-archive-o f-36 txt-warning"></i>
									<div class="media-body ms-3">
									<h6 class="mb-0">Viho admin</h6>
									<p>204 files, 50mb</p>
									</div>
								</div>
								</li> --}}
								@foreach ($matieres as $matiere)
									<li class="folder-box m-1">
										<a href="{{ route('user.ressource-show', $matiere->id) }}">
											<div class="media"><i class="fa fa-folder f-36 txt-warning"></i>
												<div class="media-body ms-3">
													<h6 class="mb-0">{{ $matiere->nom }}</h6>
													<p>101 files, 10mb</p>
												</div>
											</div>
										</a>
									</li>
								@endforeach
								{{-- <li class="folder-box">
								<div class="media"><i class="fa fa-file-archive-o f-36 txt-warning"></i>
									<div class="media-body ms-3">
									<h6 class="mb-0">Viho admin</h6>
									<p>25 files, 2mb</p>
									</div>
								</div>
								</li> --}}
								{{-- <li class="folder-box">
									<div class="media"><i class="fa fa-file-archive-o f-36 txt-warning"></i>
										<div class="media-body ms-3">
										<h6 class="mb-0">OMNIS admin</h6>
										<p>25 files, 2mb</p>
										</div>
									</div>
								</li> --}}
								{{-- <li class="folder-box">
								<div class="media"><i class="fa fa-folder f-36 txt-warning"></i>
									<div class="media-body ms-3">
									<h6 class="mb-0">Viho admin</h6>
									<p>108 files, 5mb</p>
									</div>
								</div>
								</li> --}}
							</ul>
							{{-- <h5 class="mt-4">Files</h5>
							<ul class="files">
								<li class="file-box">
								<div class="file-top">  <i class="fa fa-file-archive-o txt-secondary"></i><i class="fa fa-ellipsis-v f-14 ellips"></i></div>
								<div class="file-bottom">
									<h6>Project.zip </h6>
									<p class="mb-1">1.90 GB</p>
									<p> <b>last open : </b>1 hour ago</p>
								</div>
								</li>
								<li class="file-box">
								<div class="file-top">  <i class="fa fa-file-excel-o txt-success"></i><i class="fa fa-ellipsis-v f-14 ellips"></i></div>
								<div class="file-bottom">
									<h6>Backend.xls</h6>
									<p class="mb-1">2.00 GB</p>
									<p> <b>last open : </b>1 hour ago</p>
								</div>
								</li>
								<li class="file-box">
								<div class="file-top">  <i class="fa fa-file-text-o txt-info"></i><i class="fa fa-ellipsis-v f-14 ellips"></i></div>
								<div class="file-bottom">
									<h6>requirements.txt </h6>
									<p class="mb-1">0.90 KB</p>
									<p> <b>last open : </b>1 hour ago</p>
								</div>
								</li>
								<li class="file-box">
								<div class="file-top">  <i class="fa fa-file-text-o txt-primary"></i><i class="fa fa-ellipsis-v f-14 ellips"></i></div>
								<div class="file-bottom">
									<h6>Logo.psd </h6>
									<p class="mb-1">2.0 MB</p>
									<p> <b>last open : </b>1 hour ago</p>
								</div>
								</li>
							</ul> --}}
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