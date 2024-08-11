@extends('layouts.informatique.master')

@section('title')Importer Liste Etudiants
 {{ $title }}
@endsection

@push('css')
@endpush

@section('content')
  @component('components.informatique.breadcrumb')
    @slot('breadcrumb_title')
      <h3>Importer Liste Etudiants</h3>
    @endslot
    {{-- <li class="breadcrumb-item">Resultats</li> --}}
    <li class="breadcrumb-item active">Importer Liste Etudiants</li>
  @endcomponent

  <div class="container-fluid">
      <div class="row">
	        <div class="col-sm-12">
				<div class="card">
					<div class="card-header pb-0">
	                    <h5>Importer Liste des étudiants inscrits</h5>
					</div>
					<form class="form theme-form" enctype="multipart/form-data" method="POST" action="{{ route('admin.etudiant-postImport') }}">
						@csrf
						<div class="card-body">
							<div class="row">
								<div class="col">
									<div class="mb-3 row">
										<label class="col-sm-3 col-form-label">Charger le fichier Excel</label>
										<div class="col-sm-9">
											<input class="form-control @error('liste_etudiants') is-invalid @enderror" name="liste_etudiants" type="file" />
											@error('liste_etudiants')
												<div class="invalid-feedback">{{ $message }}</div>
											@enderror
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="card-footer text-end">
							<button class="btn btn-primary" type="submit">Valider</button>
						</div>
					</form>
				</div>
	        </div>
	        <!-- Default ordering (sorting) Ends-->
      </div>
  </div>


@push('scripts')
@endpush

@endsection
