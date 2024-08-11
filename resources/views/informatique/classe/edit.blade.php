@extends("layouts.$master.master")

@section('title')Modification
 {{ $title }}
@endsection

@push('css')
@livewireStyles
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
                    <form class="form theme-form" action="{{ route('admin.classe.update', $classe) }}" method="POST">
                        @method('PUT')
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <livewire:classe-filiere-niveau :classe="$classe" />
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