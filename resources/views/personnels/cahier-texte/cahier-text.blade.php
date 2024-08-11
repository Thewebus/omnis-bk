@extends('layouts.personnel.master')

@section('title')Cahier de texte
    {{ $title }}
@endsection

@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datatables.css') }}">
@endpush

@section('content')
@component('components.breadcrumb')
    @slot('breadcrumb_title')
    <h3>Cahier de texte</h3>
    @endslot
    <li class="breadcrumb-item">Consultation</li>
    <li class="breadcrumb-item active">Consultation C. T</li>
@endcomponent

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>Consultation cahier de texte <b>{{ $classe->nom }}</b></h5>
                    <span>Disabling features that you don't wish to use for a particular table is easily done by setting a variable in the initialisation object</span>
                    <span>In the following example only the search feature is left enabled (which it is by default).</span>
                    <br>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="display" id="basic-2">
                            <thead>
                                <tr>
                                    <th>N°</th>
                                    <th>Date</th>
                                    <th>Matière</th>
                                    <th>Durée</th>
                                    <th>Contenu</th>
                                    <th>Bibliographie</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cahierTextes->sortByDesc('created_at') as $cahierTexte)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $cahierTexte->date }}</td>
                                    <td>{{ $cahierTexte->matiere->nom }}</td>
                                    <td>{{ $cahierTexte->duree }}h</td>
                                    <td>{{ $cahierTexte->contenu }}</td>
                                    <td>{{ $cahierTexte->bibliographie }}</td>
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