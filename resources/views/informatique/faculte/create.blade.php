@extends("layouts.$master.master")

@section('title')Nouvelle faculté
 {{ $title }}
@endsection

@push('css')
@endpush

@section('content')
	@component("components.$master.breadcrumb")
		@slot('breadcrumb_title')
			<h3>Nouvelle faculté</h3>
		@endslot
		<li class="breadcrumb-item"><a href="{{ route('admin.facultes.index') }}">Facultés</a> </li>
		{{-- <li class="breadcrumb-item">Data Tables</li> --}}
		<li class="breadcrumb-item active">nouvelle faculté</li>
	@endcomponent
	
	<div class="container-fluid">
	    <div class="row">
	        <div class="col-sm-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <h5>Entrez les informations</h5>
                    </div>
                    <form class="form theme-form" action="{{ route('admin.facultes.store') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">Institut</label>
                                        <div class="col-sm-9">
                                            <select class="form-select digits @error('institut') is-invalid @enderror" id="institut" name="institut" >
                                                <option value="">Choisir un Institut</option>
                                                @foreach ($instituts as $institut)
                                                <option value="{{ $institut->id }}" {{ old('institut') == $institut->id ? 'selected' : '' }}>{{ $institut->nom }}</option>
                                                @endforeach
                                            </select>
                                            @error('institut')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">Nom</label>
                                        <div class="col-sm-9">
                                            <input class="form-control @error('nom_faculte') is-invalid @enderror" type="text" name="nom_faculte" value="{{ old("nom_faculte") }}" placeholder="Nom filière" />
                                            @error('nom_faculte')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-sm-3 col-form-label">Description</label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="5" cols="5" placeholder="Default textarea">{{ old('description') }}</textarea>
                                            @error('description')
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