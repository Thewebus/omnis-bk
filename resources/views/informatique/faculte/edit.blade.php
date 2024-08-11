@extends("layouts.$master.master")

@section('title')Modification Faculté
 {{ $title }}
@endsection

@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datatables.css') }}">
@endpush

@section('content')
	@component("components.$master.breadcrumb")
		@slot('breadcrumb_title')
			<h3>Modification informations Faculté</h3>
		@endslot
		<li class="breadcrumb-item"><a href="{{ route('admin.facultes.index') }}">Facultés</a> </li>
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
                    <form class="form theme-form" action="{{ route('admin.facultes.update', $faculte) }}" method="POST">
                        @method('PUT')
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
                                                <option value="{{ $institut->id }}" {{ ($faculte->institut ? $faculte->institut->id : old('institut')) == $institut->id ? 'selected' : '' }}>{{ $institut->nom }}</option>
                                                @endforeach
                                            </select>
                                            @error('filiere')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">Nom</label>
                                        <div class="col-sm-9">
                                            <input class="form-control @error('nom_faculte') is-invalid @enderror" type="text" name="nom_faculte" value="{{ old("nom_faculte") ?? $faculte->nom }}" placeholder="Nom filière" />
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
                                            <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="5" cols="5" placeholder="Default textarea">{{ old('description') ?? $faculte->description }}</textarea>
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

                <button class="btn btn-warning btn-block mb-3" type="button" data-bs-toggle="modal" data-bs-target="#createModal{{ $faculte->id }}"><i class="fa fa-plus"></i> Nouveau niveau</button>
                <div class="modal fade" id="createModal{{ $faculte->id }}" tabindex="-1" role="dialog" aria-labelledby="createModal{{ $faculte->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <form class="form theme-form" action="{{ route('admin.niveau-faculte.store') }}" method="POST">
                            @csrf
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Ajouter un niveau</h5>
                                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col">
                                                <div class="mb-3 row">
                                                    <label for="nom" class="col-form-label text-center">Nom</label>
                                                    <div class="col-sm-12">
                                                        <select class="form-select digits @error('nom') is-invalid @enderror" id="nom" name="nom" >
                                                            <option selected value="">Choisir un niveau</option>
                                                            <optgroup label="BTS">
                                                                <option value="bts 1" {{ old('nom') == 'bts 1' ? 'selected' : '' }}>BTS 1</option>
                                                                <option value="bts 2" {{ old('nom') == 'bts 2' ? 'selected' : '' }}>BTS 2</option>
                                                            </optgroup>
                                                            <optgroup label="LICENCE">
                                                                <option value="licence 1" {{ old('nom') == 'licence 1' ? 'selected' : '' }}>LICENCE 1</option>
                                                                <option value="licence 2" {{ old('nom') == 'licence 2' ? 'selected' : '' }}>LICENCE 2</option>
                                                                <option value="licence 3" {{ old('nom') == 'licence 3' ? 'selected' : '' }}>LICENCE 3</option>
                                                            </optgroup>
                                                            <optgroup label="MASTER">
                                                                <option value="master 1" {{ old('nom') == 'master 1' ? 'selected' : '' }}>MASTER 1</option>
                                                                <option value="master 2" {{ old('nom') == 'master 2' ? 'selected' : '' }}>MASTER 2</option>
                                                            </optgroup>
                                                        </select>

                                                        <input type="hidden" name="faculte_id" value="{{ $faculte->id }}">
                                                        @error('nom')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <label for="scolarite_affecte" class="col-form-label text-center">Scolarité Affecté</label>
                                                    <div class="col-sm-12">
                                                        <input id="scolarite_affecte" class="form-control @error('scolarite_affecte') is-invalid @enderror" type="text" name="scolarite_affecte" value="{{ old("scolarite_affecte") }}" placeholder="Scolarité affecté" />
                                                        @error('scolarite_affecte')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <label for="scolarite_reaffecte" class="col-form-label text-center">Scolarité Réacffecté</label>
                                                    <div class="col-sm-12">
                                                        <input id="scolarite_reaffecte" class="form-control @error('scolarite_reaffecte') is-invalid @enderror" type="text" name="scolarite_reaffecte" value="{{ old("scolarite_reaffecte") }}" placeholder="Scolarité réacffecté" />
                                                        @error('scolarite_reaffecte')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <label for="scolarite_nonaffecte" class="col-form-label text-center">Scolarité non acffecté</label>
                                                    <div class="col-sm-12">
                                                        <input id="scolarite_nonaffecte" class="form-control @error('scolarite_nonaffecte') is-invalid @enderror" type="text" name="scolarite_nonaffecte" value="{{ old("scolarite_nonaffecte") }}" placeholder="Scolarité non affecté" />
                                                        @error('scolarite_nonaffecte')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i> Enregistrer</button>
                                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </form>													
                    </div>
                </div>
            </div>
	    </div>
	</div>
	
    <div class="container-fluid">
	    <div class="row">
	        <!-- Feature Unable /Disable Order Starts-->
	        <div class="col-sm-12">
	            <div class="card">
	                <div class="card-header">
	                    <h5>Liste des niveau</h5>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="display" id="basic-2">
                                    <thead>
                                        <tr>
                                            <th>N°</th>
                                            <th>Nom</th>
                                            <th>Scolarité affecté</th>
                                            <th>Scolarité réacffecté</th>
                                            <th>Scolarité non affecté</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($faculte->niveaux as $niveau)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ strtoupper($niveau->nom) }}</td>
                                            <td>{{ $niveau->scolarite_affecte }}</td>
                                            <td>{{ $niveau->scolarite_reaffecte }}</td>
                                            <td>{{ $niveau->scolarite_nonaffecte }}</td>
                                            <td style="width: 11vw">
                                                <button class="btn btn-warning btn-block mt-3" type="button" data-bs-toggle="modal" data-bs-target="#editModal{{ $niveau->id }}"><i class="fa fa-edit"></i></button>
                                                <div class="modal fade" id="editModal{{ $niveau->id }}" tabindex="-1" role="dialog" aria-labelledby="editModal{{ $niveau->id }}" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <form class="form theme-form" action="{{ route('admin.niveau-faculte.update', $niveau->id) }}" method="POST">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Niveau {{ strtoupper($niveau->nom) }}</h5>
                                                                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    @method('PUT')
                                                                    @csrf
                                                                    <div class="card-body">
                                                                        <div class="row">
                                                                            <div class="col">
                                                                                <div class="mb-3 row">
                                                                                    <label for="nom" class="col-form-label text-center">Nom</label>
                                                                                    <div class="col-sm-12">
                                                                                        <select class="form-select digits @error('nom') is-invalid @enderror" id="nom" name="nom" >
                                                                                            <option value="">Choisir un niveau</option>
                                                                                            <optgroup label="BTS">
                                                                                                <option value="bts 1" {{ old('nom') == 'bts 1' ? 'selected' : ($niveau->nom == 'bts 1' ? 'selected' : '' ) }}>BTS 1</option>
                                                                                                <option value="bts 2" {{ old('nom') == 'bts 2' ? 'selected' : ($niveau->nom == 'bts 2' ? 'selected' : '' ) }}>BTS 2</option>
                                                                                            </optgroup>
                                                                                            <optgroup label="LICENCE">
                                                                                                <option value="licence 1" {{ old('nom') == 'licence 1' ? 'selected' : ($niveau->nom == 'licence 1' ? 'selected' : '' ) }}>LICENCE 1</option>
                                                                                                <option value="licence 2" {{ old('nom') == 'licence 2' ? 'selected' : ($niveau->nom == 'licence 2' ? 'selected' : '' ) }}>LICENCE 2</option>
                                                                                                <option value="licence 3" {{ old('nom') == 'licence 3' ? 'selected' : ($niveau->nom == 'licence 3' ? 'selected' : '' ) }}>LICENCE 3</option>
                                                                                            </optgroup>
                                                                                            <optgroup label="MASTER">
                                                                                                <option value="master 1" {{ old('nom') == 'master 1' ? 'selected' : ($niveau->nom == 'master 1' ? 'selected' : '' ) }}>MASTER 1</option>
                                                                                                <option value="master 2" {{ old('nom') == 'master 2' ? 'selected' : ($niveau->nom == 'master 2' ? 'selected' : '' ) }}>MASTER 2</option>
                                                                                            </optgroup>
                                                                                        </select>
                                
                                                                                        <input type="hidden" name="faculte_id" value="{{ $faculte->id }}">
                                                                                        @error('nom')
                                                                                            <span class="invalid-feedback" role="alert">
                                                                                                <strong>{{ $message }}</strong>
                                                                                            </span>
                                                                                        @enderror
                                                                                    </div>
                                                                                </div>
                                                                                <div class="mb-3 row">
                                                                                    <label for="scolarite_affecte" class="col-form-label text-center">Scolarité Affecté</label>
                                                                                    <div class="col-sm-12">
                                                                                        <input id="scolarite_affecte" class="form-control @error('scolarite_affecte') is-invalid @enderror" type="text" name="scolarite_affecte" value="{{ old("scolarite_affecte") ?? $niveau->scolarite_affecte }}" placeholder="Scolarité affecté" />
                                                                                        @error('scolarite_affecte')
                                                                                            <span class="invalid-feedback" role="alert">
                                                                                                <strong>{{ $message }}</strong>
                                                                                            </span>
                                                                                        @enderror
                                                                                    </div>
                                                                                </div>
                                                                                <div class="mb-3 row">
                                                                                    <label for="scolarite_reaffecte" class="col-form-label text-center">Scolarité Réacffecté</label>
                                                                                    <div class="col-sm-12">
                                                                                        <input id="scolarite_reaffecte" class="form-control @error('scolarite_reaffecte') is-invalid @enderror" type="text" name="scolarite_reaffecte" value="{{ old("scolarite_reaffecte") ?? $niveau->scolarite_reaffecte }}" placeholder="Scolarité réacffecté" />
                                                                                        @error('scolarite_reaffecte')
                                                                                            <span class="invalid-feedback" role="alert">
                                                                                                <strong>{{ $message }}</strong>
                                                                                            </span>
                                                                                        @enderror
                                                                                    </div>
                                                                                </div>
                                                                                <div class="mb-3 row">
                                                                                    <label for="scolarite_nonaffecte" class="col-form-label text-center">Scolarité non acffecté</label>
                                                                                    <div class="col-sm-12">
                                                                                        <input id="scolarite_nonaffecte" class="form-control @error('scolarite_nonaffecte') is-invalid @enderror" type="text" name="scolarite_nonaffecte" value="{{ old("scolarite_nonaffecte") ?? $niveau->scolarite_nonaffecte }}" placeholder="Scolarité non affecté" />
                                                                                        @error('scolarite_nonaffecte')
                                                                                            <span class="invalid-feedback" role="alert">
                                                                                                <strong>{{ $message }}</strong>
                                                                                            </span>
                                                                                        @enderror
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i> Enregistrer</button>
                                                                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                                                                </div>
                                                            </div>
                                                        </form>													
                                                    </div>
                                                </div>

                                                <button class="btn btn-danger btn-block mt-3" type="button" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $niveau->id }}"><i class="fa fa-trash-o"></i></button>
                                                <div class="modal fade" id="deleteModal{{ $niveau->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModal{{ $niveau->id }}" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Suppression Niveau {{ $niveau->nom }}</h5>
                                                                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>
                                                                    Vous êtes sur le point de supprimer définitivement cet élément. <br>
                                                                    Cette opération est irréversible. <br>
                                                                    Voulez-vous vraiment supprimer ?
                                                                </p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button class="btn btn-success" type="button" data-bs-dismiss="modal">Fermer</button>
                                                                <form action="{{ route('admin.niveau-faculte.destroy', $niveau) }}" method="POST">
                                                                    @method('DELETE')
                                                                    @csrf
                                                                    <button class="btn btn-danger" type="submit"><i class="fa fa-trash-o"></i> Supprimer</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
	                </div>
                </div>
                <!-- Feature Unable /Disable Ends-->
	        </div>
	    </div>
    </div>
	@push('scripts')
    <script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}"></script>
	@endpush

@endsection