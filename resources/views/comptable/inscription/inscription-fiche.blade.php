@extends('layouts.comptable.master')

@section('title')Fiche d'inscription
    {{ $title }}
@endsection

@push('css')
@endpush

@section('content')
  @component('components.breadcrumb')
    @slot('breadcrumb_title')
      <h3>Accueil</h3>
    @endslot
    <li class="breadcrumb-item">Inscription</li>
    <li class="breadcrumb-item active">Fiche d'inscription</li>
  @endcomponent

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <h5>Fiche d'inscription : {{ $inscription->etudiant->fullname }}</h5>
                        <span> 
                            @if ($inscription->valide == 0 && $inscription->raison == null)
                                <span class="badge badge-warning">En attente</span>
                            @elseif ($inscription->valide == 0 && $inscription->raison !== null)
                                <span class="badge badge-danger">Refusé</span>
                            @else
                                <span class="badge badge-success">Validé</span>
                            @endif
                        </span>
                        <div class="row mt-5">
                            <div class="col-md-3"></div>
                            <div class="col-md-3"></div>
                            <div class="col-md-3"></div>
                            <div class="col-md-3"></div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h5 style="color: #24695c">IDENTITE PERSONNELLE</h5>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                Date Nais. : <b>{{ $inscription->etudiant->date_naissance }}</b> 
                            </div>
                            <div class="col-md-4">
                                Lieu Nais. : <b>{{ $inscription->etudiant->lieu_naissance }}</b> 
                            </div>
                            <div class="col-md-4">
                                Nationalité : <b>{{ $inscription->etudiant->nationalite ?? __('NEANT') }}</b> 
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                Sexe : <b>{{ $inscription->etudiant->sexe }}</b> 
                            </div>
                            <div class="col-md-4">
                                Domicile : <b>{{ $inscription->etudiant->domicile ?? __('NEANT') }}</b> 
                            </div>
                            <div class="col-md-4">
                                Téléphone : <b>{{ $inscription->etudiant->numero_etudiant }}</b> 
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                Email : <b>{{ $inscription->etudiant->email ?? __('NEANT') }}</b> 
                            </div>
                            <div class="col-md-4">
                                Etablissement d'origine : <b>{{ strtoupper($inscription->etudiant->etablissement_origine) ?? __('NEANT') }}</b> 
                            </div>
                            <div class="col-md-4">
                                Adr. Géographique : <b>{{ strtoupper($inscription->etudiant->adresse_geographique) ?? __('NEANT') }}</b> 
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-2">
                                Matricule : <b>{{ strtoupper($inscription->etudiant->matricule_etudiant) ?? __('NEANT') }}</b> 
                            </div>
                            <div class="col-md-2">
                                Niveau Etd. : <b>{{ strtoupper($inscription->etudiant->niveau_etude) ?? __('NEANT') }}</b> 
                            </div>
                            <div class="col-md-2">
                                Serie BAC : <b>{{ strtoupper($inscription->etudiant->serie_bac) ?? __('NEANT') }}</b> 
                            </div>
                            <div class="col-md-3">
                            Autre diplome : <b>{{ $inscription->etudiant->autre_diplome ?? __('NEANT') }}</b> 
                            </div>
                            <div class="col-md-3">
                                Faculté : <b>
                                    {{ ($inscription->etudiant->niveauFaculte->faculte->nom ?? $inscription->etudiant->classe($anneeAcademique->id)->niveauFaculte->faculte->nom)
                                        ?? __('NEANT') }}
                                </b> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h5 style="color: #24695c">ANNEE ACADEMIQUE {{ $inscription->anneeAcademique->debut }} - {{ $inscription->anneeAcademique->fin }}</h5>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                Statut : <b>{{ strtoupper($inscription->etudiant->statut) ?? __('NEANT') }}</b> 
                            </div>
                            <div class="col-md-4">
                            </div>
                            <div class="col-md-4">
                                Niveau d'étude : <b>{{ ($inscription->etudiant->niveauFaculte->nom ?? $inscription->etudiant->classe($anneeAcademique->id)->niveauFaculte->nom) ?? __('NEANT') }}</b> 
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                Date de la première entrée à l'université (année) : <b>{{ $inscription->etudiant->premier_entree_ua ?? __('NEANT') }}</b> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h5 style="color: #24695c">RESPONSABLE LEGAL DE L'ÉTUDIANT (A APPELER EN CAS D'URGENCE)</h5>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                Responsable : <b>
                                    {{ $inscription->etudiant->responsable_legal == null ? __('NEANT') : ($inscription->etudiant->responsable_legal == 'autre' ? strtoupper($inscription->etudiant->responsable_legal_precision) : strtoupper($inscription->etudiant->responsable_legal)) }}
                                </b> 
                            </div>
                            <div class="col-md-4">
                                Nom & Prénoms : <b>{{ $inscription->etudiant->responsable_legal_fullname ?? __('NEANT') }}</b> 
                            </div>
                            <div class="col-md-4">
                                Profession : <b>{{ $inscription->etudiant->responsable_legal_profession ?? __('NEANT') }}</b> 
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                Adresse : <b>{{ $inscription->etudiant->responsable_legal_adresse ?? _('NEANT') }} </b> 
                            </div>
                            <div class="col-md-4">
                                Domicile : <b>{{ $inscription->etudiant->responsable_legal_domicile ?? __('NEANT') }}</b> 
                            </div>
                            <div class="col-md-4">
                                Numéro : <b>{{ $inscription->etudiant->responsable_legal_numero ?? __('NEANT') }}</b> 
                            </div>
                        </div>
                        {{-- <div class="row">
                            <div class="col-md-12">
                                <h5 style="color: #24695c">PERSONNE EN CHARGE DU PAIEMENT DE LA SCOLATITÉ (A APPELER EN CAS DE BESOIN)</h5>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                Nom & Prénoms : <b>{{ $inscription->etudiant->responsable_scolarite_fullname ?? __('NEANT') }}</b> 
                            </div>
                            <div class="col-md-4">
                                Profession : <b>{{ $inscription->etudiant->responsable_scolarite_profession ?? __('NEANT') }}</b> 
                            </div>
                            <div class="col-md-4">
                                Adresse : <b>{{ $inscription->etudiant->responsable_scolarite_adresse ?? _('NEANT') }} </b> 
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                Domicile : <b>{{ $inscription->etudiant->responsable_scolarite_dimicile ?? __('NEANT') }}</b> 
                            </div>
                            <div class="col-md-4">
                                Numéro : <b>{{ $inscription->etudiant->responsable_scolarite_numero ?? __('NEANT') }}</b> 
                            </div>
                        </div> --}}
                        <div class="row">
                            <div class="col-md-12">
                                <h5 style="color: #24695c">PRISE EN CHARGE</h5>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                Prise en charge : <b>{{ $inscription->prise_chage == 0 ? __('NON') : __('OUI') }}</b> 
                            </div>
                            <div class="col-md-4">
                                Type de prise en charge : <b>{{ $inscription->prise_charge_type ?? __('NEANT') }}</b> 
                            </div>
                            <div class="col-md-4">
                                Scolarité : <b>{{ $inscription->net_payer }} FR CFA </b> 
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                Remise : <b>{{ $inscription->remise }} FR CFA</b> 
                            </div>
                            <div class="col-md-4">
                                Net à payer : <b>{{ $inscription->net_payer }} FR CFA</b> 
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-2">
                                <a class="btn btn-outline-primary" 
                                    href="{{ $inscription->extrait_naissance == null ? '#' : asset(str_replace('public', 'storage', $inscription->extrait_naissance)) }}"
                                >
                                    Ext. nais. {{ $inscription->extrait_naissance == null ? '(Aucun)' : '' }}
                                </a>
                            </div>
                            <div class="col-md-2">
                                <a 
                                    href="{{ $inscription->bac_legalise == null ? '#' : asset(str_replace('public', 'storage', $inscription->bac_legalise)) }}" class="btn btn-outline-secondary"
                                >
                                    BAC {{ $inscription->bac_legalise == null ? '(Aucun)' : '' }}
                                </a>    
                            </div>
                            <div class="col-md-2">
                                <a 
                                    href="{{ $inscription->cp_note_bac == null ? '#' : asset(str_replace('public', 'storage', $inscription->cp_note_bac)) }}" 
                                    class="btn btn-outline-warning"
                                >
                                    Note BAC {{ $inscription->cp_note_bac == null ? '(Aucun)' : '' }}
                                </a>
                            </div>
                            <div class="col-md-2">
                                <a 
                                    href="{{ $inscription->fiche_inscription == null ? '#' : asset(str_replace('public', 'storage', $inscription->fiche_inscription)) }}" 
                                    class="btn btn-outline-secondary"
                                >
                                    Fiche inscription {{ $inscription->fiche_inscription == null ? '(Aucun)' : '' }}
                                </a>
                            </div>
                            <div class="col-md-2">
                                <a 
                                    href="{{ $inscription->fiche_oriantation == null ? '#' : asset(str_replace('public', 'storage', $inscription->fiche_oriantation)) }}" 
                                    class="btn btn-outline-secondary"
                                >
                                    Fiche orientation {{ $inscription->fiche_oriantation == null ? '(Aucun)' : '' }}
                                </a>
                            </div>
                            <div class="col-md-2">
                                <a 
                                    href="{{ $inscription->photo == null ? '#' : asset(str_replace('public', 'storage', $inscription->photo)) }}" 
                                    class="btn btn-outline-secondary"
                                >
                                    Photo {{ $inscription->photo == null ? '(Aucun)' : '' }}
                                </a>
                            </div>
                        </div>
                        @if ($inscription->valide == 0)
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <h5 style="color: #24695c">Actions</h5>
                                </div>
                            </div>
                            <div class="text-center mb-3">
                                <form action="{{ route('admin.valider-inscription', $inscription->id) }}" method="post" style="display: inline-block">
                                    @csrf
                                    <button class="btn btn-success" type="submit"><i class="fa fa-check"></i> Valider l'inscription</button>
                                </form>
                                                            
                                <button class="btn btn-danger" type="button" data-bs-toggle="modal" data-bs-target="#denieModal{{ $inscription->id }}"><i class="icon-close"></i> Réfuser le dossier</button>
                                <div class="modal fade" id="denieModal{{ $inscription->id }}" tabindex="-1" role="dialog" aria-labelledby="denieModal{{ $inscription->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Motif refus</h5>
                                                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form class="form theme-form" action="{{ route('admin.refuser-inscription', $inscription->id) }}" method="POST">
                                                <div class="modal-body">
                                                    @csrf
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col">
                                                                <div class="mb-3 row">
                                                                    <label class="col-sm-3 col-form-label">Motif</label>
                                                                    <div class="col-sm-9">
                                                                        <textarea class="form-control @error('motif') is-invalid @enderror" name="motif" rows="5" cols="5" placeholder="Motif du réfus">{{ old('motif') }}</textarea>
                                                                        @error('motif')
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
                                                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Fermer</button>
                                                    <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i> Valider</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>


  @push('scripts')
  @endpush

@endsection
