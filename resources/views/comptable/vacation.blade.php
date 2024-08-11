@extends('layouts.comptable.master')

@section('title')Fiche de vacation
 {{ $title }}
@endsection

@push('css')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/prism.css')}}">
@endpush

@section('content')
    @component('components.breadcrumb')
        @slot('breadcrumb_title')
            <h3>Fiche de vacation</h3>
        @endslot
        <li class="breadcrumb-item">Accueil</li>
        <li class="breadcrumb-item active">Fiche de vacation</li>
    @endcomponent

    <div class="container-fluid grid-wrrapper">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <h5>Bordereau de paiement des enseignants </h5>
                            {{-- <div class="col-sm-6">
                                <span>Use class<code>.table-primary</code> inside thead tr element.</span>
                            </div>
                            <div class="col-sm-6">
                                <button class="btn btn-success"><i class="fa fa-download"></i> Tous télécharger</button>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-block pt-3 row">
                        <div class="col-md-6 offset-md-3 border text-center mb-3">
                            <h4>Bordereau de paiement des enseignants {{ $anneeAcademique['debut'] }} - {{ $anneeAcademique['fin'] }}</h4>
                        </div>
                        <div class="col-md-6 offset-md-3 text-center">
                            {{-- <h6>ING AVRIL 2022</h6> --}}
                        </div>
                        <div class="col-sm-12 col-lg-12 col-xl-12">
                            <div class="table-responsive">
                                <table class="table border table-sm">
                                    <tr class="text-center align-middle">
                                        <th rowspan="2">COMPTE BANCAIRE</th>
                                        <th rowspan="2">Téléphone</th>
                                        <th rowspan="2">Nom & Prénoms</th>
                                        <th rowspan="2">Vol. Horaire</th>
                                        {{-- <th rowspan="2">Taux BTS</th>
                                        <th rowspan="2">Taux LICENCE</th>
                                        <th rowspan="2">Taux MASTER</th> --}}
                                        <th rowspan="2">Montant total brut 100%</th>
                                        <th>Impôts</th>
                                        <th>CNPS</th>
                                        <th rowspan="2">Net à payer</th>
                                        <th rowspan="2">Classe</th>
                                        <th rowspan="2">Nbr d'Heures</th>
                                        <th>Matières</th>
                                    </tr>
                                    <tr class="text-center">
                                        {{-- <td>Taux 2</td> --}}
                                        <td>7.50%</td>
                                        <td>6.30%</td>
                                        <td>Cours dispensés</td>
                                    </tr>
                                    <tbody>
                                        @if (count($vacationDatas) > 0)
                                            @foreach ($vacationDatas as $vacationData)
                                                <tr class="text-center align-middle">
                                                    <th rowspan="{{ count($vacationData['cours']) }}">{{ $vacationData['compte_bancaire'] }}</th>
                                                    <td rowspan="{{ count($vacationData['cours']) }}">{{ $vacationData['telephone'] }}</td>
                                                    <td rowspan="{{ count($vacationData['cours']) }}">{{ $vacationData['fullname'] }}</td>
                                                    <td rowspan="{{ count($vacationData['cours']) }}">{{ $vacationData['volume_horaire'] }}</td>
                                                    {{-- <td rowspan="{{ count($vacationData['cours']) }}">{{ $vacationData['taux_horaire_bts'] }}</td>
                                                    <td rowspan="{{ count($vacationData['cours']) }}">{{ $vacationData['taux_horaire_licence'] }}</td>
                                                    <td rowspan="{{ count($vacationData['cours']) }}">{{ $vacationData['taux_horaire_master'] }}</td> --}}
                                                    <td rowspan="{{ count($vacationData['cours']) }}">{{ $vacationData['montant_brut'] }}</td>
                                                    <td rowspan="{{ count($vacationData['cours']) }}">{{ $vacationData['impots'] }}</td>
                                                    <td rowspan="{{ count($vacationData['cours']) }}">{{ $vacationData['cnps'] }}</td>
                                                    <td rowspan="{{ count($vacationData['cours']) }}">{{ $vacationData['net_payer'] }}</td>
                                                    @foreach ($vacationData['cours'] as $cours)
                                                        @if ($loop->iteration == 1)
                                                            <td>{{ $cours['classe'] }}</td>
                                                            <td>{{ $cours['nbr_heure'] }}</td>
                                                            <td>{{ $cours['matiere'] }}</td>
                                                            @break
                                                        @endif
                                                    @endforeach
                                                </tr>
                                                @foreach ($vacationData['cours'] as $cours)
                                                    @if ($loop->iteration >= 2)
                                                        <tr class="text-center align-middle">
                                                            <td>{{ $cours['classe'] }}</td>
                                                            <td>{{ $cours['nbr_heure'] }}</td>
                                                            <td>{{ $cours['matiere'] }}</td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            @endforeach
                                        @else
                                            <tr class="text-center">
                                                <td><strong>No data</strong></td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
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