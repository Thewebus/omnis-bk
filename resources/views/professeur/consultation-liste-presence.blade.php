@extends('layouts.professeur.master')

@section('title')Consultation Liste présence
    {{ $title }}
@endsection

@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datatables.css') }}">
@endpush

@section('content')
@component('components.professeur.breadcrumb')
    @slot('breadcrumb_title')
    <h3>Liste de présence</h3>
    @endslot
    <li class="breadcrumb-item">Présence</li>
    <li class="breadcrumb-item active">Consultation Liste présence</li>
@endcomponent

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>Consultation Liste présence matière <b>{{ $presences[0]->matiere->nom ?? 'Nom Matière' }}</b></h5>
                    {{-- <span>Disabling features that you don't wish to use for a particular table is easily done by setting a variable in the initialisation object</span>
                    <span>In the following example only the search feature is left enabled (which it is by default).</span> --}}
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="display" id="basic-2">
                            <thead>
                                <tr>
                                    <th>N°</th>
                                    <th>Classe</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($presences->sortByDesc('created_at') as $presence)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $presence->classe->nom }}</td>
                                    <td>{{ $presence->created_at }}</td>
                                    <td style="width: 13vw">
                                        <button class="btn btn-primary btn-block mt-3" type="button" data-bs-toggle="modal" data-bs-target="#seeModal{{ $loop->iteration }}"><i class="fa fa-eye"></i></button>
                                        <div class="modal fade" id="seeModal{{ $loop->iteration }}" tabindex="-1" role="dialog" aria-labelledby="seeModal{{ $loop->iteration }}" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Liste de Présence</h5>
                                                        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>
                                                            @foreach ($presence->liste as $fullname => $status)
                                                                <ul class="list-group">
                                                                    <li class="list-group-item">
                                                                        <div class="row">
                                                                            <div class="col-2">
                                                                                {{ $loop->iteration }}
                                                                            </div>
                                                                            <div class="col-6">
                                                                                <input class="form-control" type="text" disabled value="{{ str_replace('_', ' ', $fullname) }}">
                                                                            </div>
                                                                            <div class="col-4">
                                                                                <div class="form-group m-t-10 m-checkbox-inline mb-0 custom-radio-ml">
                                                                                    @if ($status == 1)
                                                                                        <span class="badge badge-success">Présent</span>
                                                                                    @else
                                                                                        <span class="badge badge-danger">Absent</span>
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                </ul>
                                                            @endforeach
                                                        </p>														
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Fermer</button>
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
    </div>
</div>


@push('scripts')
<script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}"></script>
@endpush

@endsection
