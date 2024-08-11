@extends('layouts.comptable.master')

@section('title')Scolarité
 {{ $title }}
@endsection

@push('css')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/prism.css')}}">
@endpush

@section('content')
    @component('components.breadcrumb')
        @slot('breadcrumb_title')
            <h3>Scolarité</h3>
        @endslot
        <li class="breadcrumb-item">Accueil</li>
        <li class="breadcrumb-item active">Scolarité</li>
    @endcomponent

    <div class="container-fluid grid-wrrapper">
        <div class="row">
            <div class="col-sm-12">
				<div class="card">
					<div class="card-header">
						<h5>Scolarité étudiant : {{ $etudiant->fullname }}</h5>
						{{-- <span>Use class<code>.table-primary</code> inside thead tr element.</span> --}}
					</div>
					<div class="card-block row">
						<div class="col-sm-12 col-lg-12 col-xl-12">
							<div class="table-responsive">
								<table class="table">
									<thead class="table-primary">
										<tr>
											<th scope="col">N°</th>
											<th scope="col">Libellé</th>
											<th scope="col">Banque</th>
											<th scope="col">N° Bordereau</th>
											<th scope="col">N° Reçu</th>
											<th scope="col">Versement</th>
											<th scope="col">Reste</th>
											<th scope="col">Date</th>
											<th scope="col">Scolarité</th>
											<th scope="col">Reçu</th>
										</tr>
									</thead>
									<tbody>
                                        @if (count($scolarites) > 0)
                                            @foreach ($scolarites as $scolarite)
                                                <tr>
                                                    <th scope="row">{{ $loop->iteration }}</th>
                                                    <td>{{ $scolarite['libelle'] }}</td>
                                                    <td>{{ $scolarite['nom_banque'] }}</td>
                                                    <td>{{ $scolarite['numero_bordereau'] }}</td>
                                                    <td>{{ $scolarite['numero_recu'] }}</td>
                                                    <td>{{ $scolarite['versement'] }}</td>
                                                    <td>{{ $scolarite['reste'] }}</td>
                                                    <td>{{ $scolarite['date'] }}</td>
                                                    <td>{{ $scolarite['scolarite'] }}</td>
                                                    <td>
                                                        <a href="{{ route('admin.recu-scolarite', ['id' => $scolarite['scolarite_id'], 'libelle' => $scolarite['libelle']]) }}" target="_blank" class="btn btn-success">
                                                            <i class="fa fa-download"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="8" class="text-center">No Data</td>
                                            </tr>
                                        @endif
									</tbody>
								</table>
							</div>
						</div>
                        <div class="col-md-12 text-center mt-3">
                            <button class="btn btn-primary btn-block mt-3" type="button" data-bs-toggle="modal" data-bs-target="#seeModal{{ $etudiant->id }}"><i class="fa fa-money"></i> Nouveau Paiement</button>
                            <div class="modal fade" id="seeModal{{ $etudiant->id }}" tabindex="-1" role="dialog" aria-labelledby="seeModal{{ $etudiant->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">{{ $etudiant->fullname }}</h5>
                                            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form class="form theme-form" action="{{ route('admin.post-scolarite', $etudiant->id) }}" method="POST">
                                            <div class="modal-body">
                                                @csrf
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="mb-3 row">
                                                                <label class="form-label" for="libelle">Libellé</label>
                                                                <div class="col-sm-12">
                                                                    <select class="form-select" name="libelle" id="libelle">
                                                                        <option value="inscription">Inscription</option>
                                                                        <option selected value="scolarite">Scolarité</option>
                                                                    </select>
                                                                    @error('libelle')
                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="mb-3 row">
                                                                <label class="form-label" for="nom_banque">Nom de la banque</label>
                                                                <div class="col-sm-12">
                                                                    <input class="form-control @error('nom_banque') is-invalid @enderror" id="nom_banque" value="{{ old('nom_banque') }}" name="nom_banque" @isset($inscription->frais_inscription) disabled @endisset  type="text" placeholder="Nom de la banque" />
                                                                    @error('nom_banque')
                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="mb-3 row">
                                                                <label class="form-label" for="numero_bordereau">N° bordereau</label>
                                                                <div class="col-sm-12">
                                                                    <input class="form-control @error('numero_bordereau') is-invalid @enderror" id="numero_bordereau" value="{{ old('numero_bordereau') }}" name="numero_bordereau" @isset($inscription->frais_inscription) disabled @endisset type="text" placeholder="N° du bordereau" />
                                                                    @error('numero_bordereau')
                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="mb-3 row">
                                                                <label class="form-label" for="date_versement">Date du versement</label>
                                                                <div class="col-sm-12">
                                                                    <input class="form-control @error('date_versement') is-invalid @enderror" id="date_versement" value="{{ old('date_versement') }}" name="date_versement" @isset($inscription->frais_inscription) disabled @endisset type="date" placeholder="Date du versement" />
                                                                    @error('date_versement')
                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="mb-3 row">
                                                                <label class="form-label" for="numero_recu_scolarite">N° du reçu de paiement</label>
                                                                <div class="col-sm-12">
                                                                    <input class="form-control @error('numero_recu_scolarite') is-invalid @enderror" id="numero_recu_scolarite" value="{{ old('numero_recu_scolarite') }}" name="numero_recu_scolarite" @isset($inscription->frais_inscription) disabled @endisset type="text" placeholder="N° reçu" />
                                                                    @error('numero_recu_scolarite')
                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="mb-3 row">
                                                                <label class="form-label" for="montant_frais_scolarite">Montant du versement (FCA)</label>
                                                                <div class="col-sm-12">
                                                                    <input class="form-control @error('montant_frais_scolarite') is-invalid @enderror" id="montant_frais_scolarite" value="{{ old('montant_frais_scolarite') }}" name="montant_frais_scolarite" @isset($inscription->frais_inscription) disabled @endisset type="number" placeholder="Montant versement" />
                                                                    @error('montant_frais_scolarite')
                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                                                <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i> Valider</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
					</div>
				</div>
			</div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="{{ asset('assets/js/tooltip-init.js')}}"></script>
@endpush