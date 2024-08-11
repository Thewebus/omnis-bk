@extends('layouts.informatique.master')

@section('title')Informations Professeur
    {{ $title }}
@endsection

@push('css')
@endpush

@section('content')
    @component('components.breadcrumb')
        @slot('breadcrumb_title')
            <h3>Informations Professeur</h3>
        @endslot
        <li class="breadcrumb-item"><a href="{{ route('admin.professeurs.index') }}">Professeurs</a> </li>
        <li class="breadcrumb-item active">Information professeur</li>
    @endcomponent

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <h5>Informations Professeur</h5>
                        {{-- <span>lorem ipsum dolor sit amet, consectetur adipisicing elit</span> --}}
                    </div>
                    <div class="card-body">
                        <div class="row mt-3">
                            <div class="col-md-4">
                                Nom & Prénoms : <b>{{ $professeur->fullname ?? 'NEANT' }}</b>
                            </div>
                            <div class="col-md-4">
                                Numéro : <b>{{ $professeur->numero ?? 'NEANT' }}</b>
                            </div>
                            <div class="col-md-4">
                                Email : <b>{{ $professeur->email ?? 'NEANT' }}</b>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-4">
                                Adresse Postale : <b>{{ $professeur->postale ?? 'NEANT' }}</b>
                            </div>
                            <div class="col-md-4">
                                Date de Naissance : <b>{{ $professeur->date_naissance ?? 'NEANT' }}</b>
                            </div>
                            <div class="col-md-4">
                                Profession : <b>{{ $professeur->profession ?? 'NEANT' }}</b>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-4">
                                Statut : <b>{{ $professeur->statut ?? 'NEANT' }}</b>
                            </div>
                            <div class="col-md-4">
                                Années d'anciennetées : <b>{{ $professeur->anciennete ?? 'NEANT' }}</b>
                            </div>
                            <div class="col-md-4">
                                N° CNPS : <b>{{ $professeur->cnps ?? 'NEANT' }}</b>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-4">
                                Taux horaire BTS: <b>{{ $professeur->taux_horaire_bts ?? 0 }}</b>
                            </div>
                            <div class="col-md-4">
                                Taux horaire Licence: <b>{{ $professeur->taux_horaire_licence ?? 0 }}</b>
                            </div>
                            <div class="col-md-4">
                                Taux horaire Master: <b>{{ $professeur->taux_horaire_master ?? 0 }}</b>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <h5 style="color: #24695c">Modules enseignés</h5>
                            </div>
                            <div class="col-md-12">
                                <div class="col">
                                    <div class="form-group m-t-15 m-checkbox-inline mb-0">
                                        @if ($professeur->modules_enseignes)
                                            @foreach ($professeur->modules_enseignes as $module)
                                                <div class="checkbox checkbox-dark">
                                                    <input id="{{ $module }}" type="checkbox" checked disabled>
                                                    <label for="{{ $module }}">{{ $module }}</label>
                                                </div>
                                            @endforeach
                                        @else
                                            <h6>Aucun</h6>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-3">
                                <a 
                                    href="{{ $professeur->piece_identite == null ? '#' : asset(str_replace('public', 'storage', $professeur->piece_identite)) }}"
                                    class="btn btn-outline-secondary"
                                >
                                    Pièce d'identité {{ $professeur->piece_identite == null ? '(Aucun)' : '' }}
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a 
                                    href="{{ $professeur->cv == null ? '#' : asset(str_replace('public', 'storage', $professeur->cv)) }}"
                                    class="btn btn-outline-secondary"
                                >
                                    curriculum vitae {{ $professeur->cv == null ? '(Aucun)' : '' }}
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a 
                                    href="{{ $professeur->diplomes == null ? '#' : asset(str_replace('public', 'storage', $professeur->diplomes)) }}"
                                    class="btn btn-outline-secondary"
                                >
                                    Diplômes {{ $professeur->diplomes == null ? '(Aucun)' : '' }}
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a 
                                    href="{{ $professeur->autorisation_enseigner == null ? '#' : asset(str_replace('public', 'storage', $professeur->autorisation_enseigner)) }}"
                                    class="btn btn-outline-secondary"
                                >
                                    Autorisations {{ $professeur->autorisation_enseigner == null ? '(Aucun)' : '' }}
                                </a>
                            </div>
                        </div>
                        @if ($professeur->valide == 1)
                            <p>
                                @if ($professeur->matieres->count() > 0)
                                    Matières enseignées par M. <b>{{ $professeur->fullname }}</b> :
                                    <ul class="list-group list-group-flush">
                                        @foreach($professeur->matieres as $matiere)
                                        <li class="list-group-item mb-1">{{ $matiere->nom }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    <div class="alert alert-warning dark alert-dismissible fade show" role="alert">
                                        <i data-feather="bell"></i>
                                        <p>Mr. {{ $professeur->fullname }} n'enseigne dans aucune matière pour le moment</p>
                                        <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif
                            </p>
                        @else
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <h5 style="color: #24695c">Actions</h5>
                                </div>
                            </div>
                            <div class="text-center mb-3">
                                <form action="{{ route('admin.valide-enregistrement', $professeur->id) }}" method="post" style="display: inline-block">
                                    @csrf
                                    <button class="btn btn-success" type="submit"><i class="fa fa-check"></i> Valider l'enregistrement</button>
                                </form>
                                                            
                                <button class="btn btn-danger" type="button" data-bs-toggle="modal" data-bs-target="#denieModal{{ $professeur->id }}"><i class="icon-close"></i> Réfuser le dossier</button>
                                <div class="modal fade" id="denieModal{{ $professeur->id }}" tabindex="-1" role="dialog" aria-labelledby="denieModal{{ $professeur->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Refus</h5>
                                                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form class="form theme-form" action="{{ route('admin.refus-enregistrement', $professeur->id) }}" method="POST">
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
