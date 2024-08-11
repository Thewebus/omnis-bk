@extends("layouts.$master.master")

@section('title')Modification classe
 {{ $title }}
@endsection

@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datatables.css') }}">
@endpush

@section('content')
	@component("components.$master.breadcrumb")
		@slot('breadcrumb_title')
			<h3>Modification informations classe</h3>
		@endslot
		<li class="breadcrumb-item">classes</li>
		{{-- <li class="breadcrumb-item">Data Tables</li> --}}
		<li class="breadcrumb-item active">Modification</li>
	@endcomponent
	
	<div class="container-fluid">
	    <div class="row">
	        <div class="col-sm-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <h5>Modifier les informations</h5>
                    </div>
                    <form class="form theme-form" action="{{ route('admin.salle.update', $salle) }}" method="POST">
                        @method('PUT')
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">Nom</label>
                                        <div class="col-sm-9">
                                            <input class="form-control @error('nom') is-invalid @enderror" type="text" name="nom" value="{{ old("nom") ?? $salle->nom }}" placeholder="Nom salle" />
                                            @error('nom')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">Capacité</label>
                                        <div class="col-sm-9">
                                            <input class="form-control @error('capacite') is-invalid @enderror" type="number" name="capacite" value="{{ old("capacite") ?? $salle->capacite }}" placeholder="capacite salle" />
                                            @error('capacite')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">Batiment</label>
                                        <div class="col-sm-9">
                                            <input class="form-control @error('batiment') is-invalid @enderror" type="text" name="batiment" value="{{ old("batiment") ?? $salle->batiment }}" placeholder="batiment salle" />
                                            @error('batiment')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <div class="col-sm-9 offset-sm-3">
                                <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i> Enregistrer</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
	    </div>
	</div>
	
	@push('scripts')
    <script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}"></script>
	@endpush

@endsection