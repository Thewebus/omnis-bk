@extends('layouts.informatique.master')

@section('title')Modification Unité d'Enseignement
 {{ $title }}
@endsection

@push('css')
@endpush

@section('content')
	@component('components.informatique.breadcrumb')
		@slot('breadcrumb_title')
			<h3>Modification informations Unité d'Enseignement</h3>
		@endslot
		<li class="breadcrumb-item"><a href="{{ route('admin.unite-enseignement.index') }}">Unité d'Enseignements</a> </li>
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
                    <form class="form theme-form" action="{{ route('admin.unite-enseignement.update', $uniteEnseignement) }}" method="POST">
                        @method('PUT')
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">Nom</label>
                                        <div class="col-sm-9">
                                            <input class="form-control @error('nom') is-invalid @enderror" type="text" name="nom" value="{{ old("nom") ?? $uniteEnseignement->nom }}" placeholder="Nom UE" />
                                            @error('nom')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">Code</label>
                                        <div class="col-sm-9">
                                            <input class="form-control @error('code') is-invalid @enderror" type="text" name="code" value="{{ old("code") ?? $uniteEnseignement->code }}" placeholder="Code UE" />
                                            @error('code')
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
	@endpush

@endsection