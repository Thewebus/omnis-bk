@extends('layouts.personnel.master')

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
                {{-- <span>Disabling features that you don't wish to use for a particular table is easily done by setting a variable in the initialisation object</span>
                <span>In the following example only the search feature is left enabled (which it is by default).</span> --}}
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
                            @foreach ($professeurs as $professeur)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $professeur->fullname }}</td>
                                <td>{{ $professeur->numero }}</td>
                                <td>
                                    @if ($professeur->valide == 1)
                                        <span class="badge badge-success">Valider</span>
                                    @elseif ($professeur->valide == 0 && !is_null($professeur->raison))
                                        <span class="badge badge-danger">Refusé</span>
                                    @elseif ($professeur->valide == 0 && is_null($professeur->raison) && $professeur->soumettre == 0)
                                        <span class="badge badge-secondary">Pas soumis</span>
                                    @elseif ($professeur->valide == 0 && $professeur->soumettre == 1)
                                        <span class="badge badge-warning">En attente</span>
                                    @else
                                        <span class="badge badge-warning">Some wrong</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.professeur-details', $professeur->id) }}" class="btn btn-primary btn-block mt-3" ><i class="fa fa-eye"></i></a>
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