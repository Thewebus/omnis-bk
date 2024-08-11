@extends('layouts.informatique.master')

@section('title')Liste Professeurs
 {{ $title }}
@endsection

@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datatables.css') }}">
@endpush


@section('content')
@component('components.breadcrumb')
@slot('breadcrumb_title')
    <h3>Liste Professeur</h3>
@endslot
{{-- <li class="breadcrumb-item"><a href="{{ route('admin.professeurs.index') }}">Professeurs</a> </li> --}}
{{-- <li class="breadcrumb-item">Data Tables</li> --}}
<li class="breadcrumb-item active">Liste des Professeurs</li>
@endcomponent

<div class="container-fluid">
<div class="row">
    <!-- Feature Unable /Disable Order Starts-->
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5>Liste des Professeurs</h5>
                <div class="row">
                    <div class="col-md-9"></div>
                    <div class="col-md-3"><a href="{{ route('admin.professeur-liste-pdf') }}" class="btn btn-primary"><i class="fa fa-download"></i> Liste professeurs</a></div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="display" id="basic-2">
                        <thead>
                            <tr>
                                <th>N°</th>
                                <th>Nom & Prénoms</th>
                                <th>Numéro</th>
                                <th>Statut</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($profs as $prof)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $prof->fullname }}</td>
                                <td>{{ $prof->numero }}</td>
                                <td>
                                    @if ($prof->valide == 1)
                                        <span class="badge badge-success">Valider</span>
                                    @elseif ($prof->valide == 0 && !is_null($prof->raison))
                                        <span class="badge badge-danger">Refusé</span>
                                    @elseif ($prof->valide == 0 && is_null($prof->raison) && $prof->soumettre == 0)
                                        <span class="badge badge-secondary">Pas soumis</span>
                                    @elseif ($prof->valide == 0 && $prof->soumettre == 1)
                                        <span class="badge badge-warning">En attente</span>
                                    @else
                                        <span class="badge badge-warning">Some wrong</span>
                                    @endif
                                </td>
                                <td style="width: 18vw">
                                    <a href="{{ route('admin.professeurs.show', $prof) }}" class="btn btn-primary btn-block mt-3" ><i class="fa fa-eye"></i></a>
                                    <a href="{{ route('admin.professeurs.edit', $prof) }}" class="btn btn-warning mt-3"><i class="fa fa-pencil-square-o"></i></a>
                                    {{-- <a href="{{ route('admin.professeurs.destroy', $prof) }}" class="btn btn-danger btn-block mt-3"><i class="fa fa-trash-o"></i></a> --}}

                                    <button class="btn btn-danger btn-block mt-3" type="button" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $prof->id }}"><i class="fa fa-trash-o"></i></button>
                                    <div class="modal fade" id="deleteModal{{ $prof->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModal{{ $prof->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Suppression professeur : {{ $prof->fullname }}</h5>
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
                                                    <form action="{{ route('admin.professeurs.destroy', $prof) }}" method="POST">
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


@push('scripts')
<script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}"></script>
@endpush
@endsection