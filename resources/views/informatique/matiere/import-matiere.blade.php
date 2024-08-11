@extends('layouts.informatique.master')

@section('title')Import Nouvelles matière
 {{ $title }}
@endsection

@push('css')
@livewireStyles
@endpush

@section('content')
	@component('components.breadcrumb')
		@slot('breadcrumb_title')
			<h3>Import Nouvelles matière</h3>
		@endslot
		<li class="breadcrumb-item">matières</li>
		{{-- <li class="breadcrumb-item">Data Tables</li> --}}
		<li class="breadcrumb-item active">Import nouvelles Matière</li>
	@endcomponent
	
	<div class="container-fluid">
	    <div class="row">
	        <div class="col-sm-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <h5>Entrez les informations</h5>
                    </div>
                    <form class="form theme-form" action="{{ route('admin.store-import-matiere') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <livewire:matiere-import />
                                
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label">Importer le fichier Excel</label>
                                    <div class="col-sm-9">
                                        {{-- <label class="form-label @error('ficher_import') is-invalid @enderror" for="ficher_import">Importer le fichier Excel</label> --}}
                                        <input class="form-control @error('ficher_import') is-invalid @enderror" type="file" name="ficher_import" aria-label="file example"/>
                                        @error('ficher_import')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
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
    @livewireScripts
	@endpush

@endsection