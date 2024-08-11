@extends('layouts.personnel.master')

@section('title')PV
    {{ $title }}
@endsection

@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datatables.css') }}">
@endpush

@section('content')
	@component('components.personnel.breadcrumb')
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
                                <h6>{{ $classe->nom }} // Semestre {{ $semestre }} // {{ $anneeAcademique->debut }} - {{ $anneeAcademique->fin }}</h6>
                            </div>
                        </div>
					</div>
                    <div class="card-block row">
                        <div class="col-sm-12 col-lg-12 col-xl-12">
                            <div class="table-responsive">
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
                                        {{-- <th rowspan="2">TOTAL CREDIT VALIDE  30/30</th> --}}
                                    </tr>
                                    <tr>
                                        @foreach ($entete4 as $entete)
                                            <td>{{ $entete }}</td>
                                        @endforeach
                                    </tr>
                                    @foreach ($dataAllEtudiants as $dataAllEtudiant)
                                        <tr>
                                            @foreach ($dataAllEtudiant as $item)
                                                <td>{{ $item }}</td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
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