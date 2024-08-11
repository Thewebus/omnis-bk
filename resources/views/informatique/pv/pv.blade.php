@extends('layouts.informatique.master')

@section('title')PV
    {{ $title }}
@endsection

@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datatables.css') }}">
<style>
    .black-background {
        background-color: rgb(240, 239, 239);
    }
</style>
@endpush

@section('content')
	@component('components.informatique.breadcrumb')
		@slot('breadcrumb_title')
			<h3>Toutes les notes</h3>
		@endslot
		<li class="breadcrumb-item">Liste</li>
		<li class="breadcrumb-item active">Toutes les notes</li>
	@endcomponent
	
	<div class="container-fluid">
	    <div class="row">
			<div class="col-sm-12">
				<div class="card">
					<div class="card-header">
                        <div class="row">
                            <div class="col-sm-4">
                                <h5>PV DE DELIBERATION</h5>
                            </div>
                            <div class="col-sm-3">
                                <h5></h5>
                            </div>
                            <div class="col-sm-5">
                                <h6>{{ $classe->nom }} // Semestre {{ $semestre }} // Session {{ $session }} //{{ $anneeAcademique->debut }} - {{ $anneeAcademique->fin }}</h6>
                            </div>
                        </div>
					</div>
                    @php
                        if (env('OWNER') == 'ua_abidjan') {
                            $ua = 'ABIDJAN';
                        }
                        else if (env('OWNER') == 'ua_bouake') {
                            $ua = 'BOUAKE';
                        }
                        else if (env('OWNER') == 'ua_bassam') {
                            $ua = 'GRAND BASSAM';
                        }
                        else {
                            $ua = 'SAN-PEDRO';
                        }
                    @endphp
                    <div class="card-block row">
                        <div class="col-sm-12 col-lg-12 col-xl-12">
                            <div class="table-responsive">
                                @if ($anneeAcademique->id == 1)
                                    <table class="table table-bordered text-center align-middle">
                                        <tr>
                                            @foreach ($entetes[0] as $entete)
                                                <td rowspan="{{ $entete['rowspan'] }}" colspan="{{ $entete['colspan'] }}">{{ $entete['nom'] }}</td>
                                            @endforeach
                                        </tr>
                                        <tr>
                                            @foreach ($entetes[1] as $entete)
                                                <td rowspan="{{ $entete['rowspan'] }}" colspan="{{ $entete['colspan'] }}">{{ $entete['nom'] }}</td>
                                            @endforeach
                                        </tr>
                                        <tr>
                                            @foreach ($entetes[2] as $entete)
                                                <td rowspan="{{ $entete['rowspan'] }}" colspan="{{ $entete['colspan'] }}">{{ $entete['nom'] }}</td>
                                            @endforeach
                                        </tr>
                                        <tr>
                                            @foreach ($entete4 as $entete)
                                                <td>{{ $entete }}</td>
                                            @endforeach
                                        </tr>
                                        @foreach ($dataAllEtudiants as $dataAllEtudiant)
                                            <tr>
                                                @foreach ($dataAllEtudiant as $item)
                                                    <td style="{{ $item === '-' ? "background-color: rgb(240, 239, 239)" : '' }}" class="black-background">{{ $item }}</td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    </table>
                                @else
                                    <table class="table table-bordered text-center align-middle">
                                        <tr>
                                            @foreach ($entetes[0] as $entete)
                                                <td rowspan="{{ $entete['rowspan'] }}" colspan="{{ $entete['colspan'] }}">
                                                    UNIVERSITE DE L'ATLANTIQUE {{ $ua }} - ANNEE ACADEMIQUE: {{ $anneeAcademique->debut }} - {{ $anneeAcademique->fin }}
                                                </td>
                                            @endforeach
                                        </tr>
                                        <tr>
                                            @foreach ($entetes[0] as $entete)
                                                <td rowspan="{{ $entete['rowspan'] }}" colspan="{{ $entete['colspan'] }}">{{ $entete['nom'] }}</td>
                                            @endforeach
                                        </tr>
                                        <tr>
                                            @foreach ($entetes[1] as $entete)
                                                <td
                                                    @if($loop->index > 0 && $loop->index < array_key_last($entetes[1]))
                                                        style="background-color: rgb(192, 182, 182)" 
                                                    @endif 
                                                    rowspan="{{ $entete['rowspan'] }}" 
                                                    colspan="{{ $entete['colspan'] }}"
                                                >
                                                    {{ $entete['nom'] }}
                                                </td>
                                            @endforeach
                                        </tr>
                                        <tr>
                                            @foreach ($entetes[2] as $entete)
                                                <td 
                                                    @if ($entete['nom'] == 'MOY.UE' || $entete['nom'] == 'RES.UE' || $entete['nom'] == 'CREDIT(S)')
                                                        style="background-color: rgb(192, 182, 182)" 
                                                    @endif
                                                    rowspan="{{ $entete['rowspan'] }}"
                                                    colspan="{{ $entete['colspan'] }}"
                                                >
                                                    {{ $entete['nom'] }}
                                                </td>
                                            @endforeach
                                        </tr>
                                        <tr>
                                            @foreach ($entetes[3] as $entete)
                                                <td
                                                    @if ($entete == 'MOY.ECUE' || $loop->index == array_key_last($entetes[3]))
                                                        style="background-color: rgb(192, 182, 182)" 
                                                    @endif
                                                >
                                                    {{ $entete }}
                                                </td>
                                            @endforeach
                                        </tr>
                                        @foreach ($dataAllEtudiants as $dataAllEtudiant)
                                            <tr>
                                                @foreach ($dataAllEtudiant as $item)
                                                    <td
                                                        @if ($item == 'V' || $item == 'R' || $loop->index == (array_key_last($dataAllEtudiant) - 1))
                                                            style="background-color: rgb(192, 182, 182)" 
                                                        @endif
                                                    >
                                                        {{ $item }}
                                                    </td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    </table>
                                @endif
                            </div>
                        </div>
                    </div>
				</div>
                <div class="text-center">
                    <form action="{{ route('admin.pv-download', $classe->id) }}" method="post" style="display: inline-block">
                        @csrf
                        <input type="hidden" name="semestre" value="{{ $semestre }}">
                        <input type="hidden" name="session" value="{{ $session }}">
                        <button type="submit" class="btn btn-primary m-3"><i class="fa fa-download"></i> Téléchager le PV</button>
                    </form>
                </div>
			</div>
		</div>
	</div>

	@push('scripts')
	<script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}"></script>
	@endpush

@endsection