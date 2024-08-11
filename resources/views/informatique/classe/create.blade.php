@extends("layouts.$master.master")

@section('title')Nouvelle Classe
 {{ $title }}
@endsection

@push('css')
@livewireStyles
@endpush

@section('content')
	@component("components.$master.breadcrumb")
		@slot('breadcrumb_title')
			<h3>Nouvelle Classe</h3>
		@endslot
		<li class="breadcrumb-item"><a href="{{ route('admin.classe.index') }}">Classes</a></li>
		{{-- <li class="breadcrumb-item">Data Tables</li> --}}
		<li class="breadcrumb-item active">nouvelle Classe</li>
	@endcomponent
	
	<div class="container-fluid">
	    <div class="row">
	        <div class="col-sm-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <h5>Entrez les informations</h5>
                    </div>
                    <form class="form theme-form" action="{{ route('admin.classe.store') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <livewire:classe-filiere-niveau />
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