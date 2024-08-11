@extends('layouts.comptable.master')

@section('title')Scolarité
 {{ $title }}
@endsection

@push('css')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/prism.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/select2.css') }}">
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
						<h5>Paiement professeur : {{ $professeur->fullname }}</h5>
						{{-- <span>Use class<code>.table-primary</code> inside thead tr element.</span> --}}
					</div>
					<div class="card-block row">
						<div class="col-sm-12 col-lg-12 col-xl-12">
							<div class="table-responsive">
								<table class="table">
									<thead class="table-primary">
										<tr>
											<th scope="col">N°</th>
											<th scope="col">Faculte</th>
											<th scope="col">Montant</th>
											<th scope="col">Mode Paiement</th>
											<th scope="col">N° reçu</th>
											<th scope="col">Date</th>
											<th scope="col">Note</th>
											<th scope="col">Reçu</th>
										</tr>
									</thead>
									<tbody>
                                        @if ($paiements->count() > 0)
                                            @foreach ($paiements as $paiement)
                                                <tr>
                                                    <th scope="row">{{ $loop->iteration }}</th>
                                                    <td>{{ $paiement->faculte->nom }}</td>
                                                    <td>{{ $paiement->montant_paiement }}</td>
                                                    <td>{{ $paiement->mode_paiement }}</td>
                                                    <td>{{ $paiement->numero_recu }}</td>
                                                    <td>{{ explode('-' ,$paiement->date_paiement)[2] . '/' . explode('-' ,$paiement->date_paiement)[1] . '/' . explode('-' ,$paiement->date_paiement)[0] }}</td>
                                                    <td>{{ $paiement->note }}</td>
                                                    <td>
                                                        <a href="{{ route('admin.professeur-recu-pdf', $paiement->id) }}" target="_blank" class="btn btn-success">
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
                            <button class="btn btn-primary btn-block mt-3" type="button" data-bs-toggle="modal" data-bs-target="#seeModal{{ $professeur->id }}"><i class="fa fa-money"></i> Nouveau Paiement</button>
                            <div class="modal fade" id="seeModal{{ $professeur->id }}" tabindex="-1" role="dialog" aria-labelledby="seeModal{{ $professeur->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">{{ $professeur->fullname }}</h5>
                                            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form class="form theme-form" action="{{ route('admin.paiement-professeur-post', $professeur->id) }}" method="POST">
                                            <div class="modal-body">
                                                @csrf
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="mb-3 row">
                                                                <label class="form-label" for="professeur">Professeur</label>
                                                                <div class="col-sm-12">
                                                                    <input class="form-control @error('professeur') is-invalid @enderror" id="professeur" value="{{ $professeur->fullname }}" disabled  type="text" />
                                                                </div>
                                                            </div>
                                                            <div class="mb-3 row">
                                                                <label class="form-label" for="date_paiement">Date du versement</label>
                                                                <div class="col-sm-12">
                                                                    <input class="form-control @error('date_paiement') is-invalid @enderror" id="date_paiement" value="{{ old('date_paiement') }}" name="date_paiement" type="date" placeholder="Date du versement" />
                                                                    @error('date_paiement')
                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="mb-3 row">
                                                                <label class="form-label" for="faculte">Faculté</label>
                                                                <select class="js-example-basic-single col-sm-12 @error('faculte') is-invalid @enderror" name="faculte">
                                                                    <option value="">Choisir la faculte</option>
                                                                    @foreach ($facultes as $faculte)
                                                                        <option {{ old("faculte") == $faculte->id ? 'selected' : '' }} value="{{ $faculte->id }}">{{ $faculte->nom }}</option>
                                                                    @endforeach
                                                                </select>
                                                                @error('faculte')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                            <div class="mb-3 row">
                                                                <label class="form-label" for="entite">Entité</label>
                                                                <div class="col-sm-12">
                                                                    <select class="form-select" name="entite" id="entite">
                                                                        <option value="UA ABIDJAN">UA ABIDJAN</option>
                                                                        <option value="UA BASSAM">UA BASSAM</option>
                                                                        <option value="UA BOUAKE">UA BOUAKE</option>
                                                                        <option value="UA SAN-PEDRO">UA SAN-PEDRO</option>
                                                                    </select>
                                                                    @error('entite')
                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="mb-3 row">
                                                                <label class="form-label" for="mode_paiement">Mode de paiement</label>
                                                                <div class="col-sm-12">
                                                                    <select class="form-select" name="mode_paiement" id="mode_paiement">
                                                                        <option value="espece">Espèce</option>
                                                                        <option value="cheque">Chèque</option>
                                                                        <option value="transfere">Transfert</option>
                                                                    </select>
                                                                    @error('mode_paiement')
                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="mb-3 row">
                                                                <label class="form-label" for="montant_paiement">Montant du paiement (FCA)</label>
                                                                <div class="col-sm-12">
                                                                    <input class="form-control @error('montant_paiement') is-invalid @enderror" id="montant_paiement" value="{{ old('montant_paiement') }}" name="montant_paiement" type="number" placeholder="Montant paiement" />
                                                                    @error('montant_paiement')
                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="mb-3 row">
                                                                <label class="form-label" for="note">Note</label>
                                                                <div class="col-sm-12">
                                                                    <textarea class="form-control @error('note') is-invalid @enderror" id="note" name="note" id="" placeholder="Note relative au paiement" rows="10">{{ old('note') }}</textarea>
                                                                    @error('note')
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
<script src="{{ asset('assets/js/select2/select2.full.min.js') }}"></script>
<script src="{{ asset('assets/js/select2/select2-custom.js') }}"></script>
@endpush