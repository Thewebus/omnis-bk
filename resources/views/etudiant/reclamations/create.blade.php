@extends("layouts.etudiant.master")

@section('title')Nouvelle Reclamations
 {{ $title }}
@endsection

@push('css')
@endpush

@section('content')
	@component("components.etudiant.breadcrumb")
		@slot('breadcrumb_title')
			<h3>Nouvelle Reclamations</h3>
		@endslot
		<li class="breadcrumb-item"><a href="{{ route('admin.classe.index') }}">Classes</a></li>
		{{-- <li class="breadcrumb-item">Data Tables</li> --}}
		<li class="breadcrumb-item active">nouvelle Reclamations</li>
	@endcomponent
	
	<div class="container-fluid">
	    <div class="row">
	        <div class="col-sm-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <h5>Entrez les informations</h5>
                    </div>
                    <form class="form theme-form" action="{{ route('user.reclamations.store') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">Objet</label>
                                        <div class="col-sm-9">
                                            <input class="form-control @error('objet') is-invalid @enderror" type="text" name="objet" value="{{ old("objet") }}" placeholder="Objet de la reclamation" />
                                            @error('objet')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">Matière</label>
                                        <div class="col-sm-9">
                                            <select class="form-select digits @error('matiere') is-invalid @enderror" id="matiere" name="matiere">              
                                                <option value="">Choisir la matière</option>
                                                @foreach ($matieres as $matiere)
                                                    <option value="{{ $matiere->id }}" {{ old('matiere') == $matiere->id ? 'selected' : '' }}>{{ $matiere->nom }}</option>
                                                @endforeach
                                            </select>
                                            @error('matiere')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">Type de reclamation</label>
                                        <div class="col-sm-9">
                                            <div class="form-group m-t-15 m-checkbox-inline mb-0">
                                                @foreach ($reclamations as $key => $reclamation)
                                                    <div class="checkbox checkbox-dark">
                                                        <input id="{{ $loop->iteration }}" type="checkbox" name="reclamations[]" value="{{ $key }}" {{ old($reclamation) ? 'checked' : '' }}>
                                                        <label for="{{ $loop->iteration }}">{{ $reclamation }}</label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        @error('reclamations')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="row">
                                        <label class="col-sm-3 col-form-label">Description</label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="5" cols="5" placeholder="Description faculte">{{ old('description') }}</textarea>
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