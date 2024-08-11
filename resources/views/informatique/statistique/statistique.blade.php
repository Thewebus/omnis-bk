@extends('layouts.informatique.master')

@section('title')Statistiques
 {{ $title }}
@endsection

@push('css')
@endpush

@section('content')
	@component('components.informatique.breadcrumb')
		@slot('breadcrumb_title')
			<h3>Accueil</h3>
		@endslot
		<li class="breadcrumb-item active">Statistiques</li>
		<li class="breadcrumb-item">Session {{ $session }} - Semestre {{ $semestre }}</li>
		{{-- <li class="breadcrumb-item active">Liste des services</li> --}}
	@endcomponent
	
	<div class="container-fluid">
	    <div class="row">
	        <!-- Feature Unable /Disable Order Starts-->
	        <div class="col-sm-12">
	            <div class="card">
	                <div class="card-header">
	                    <h5>Statistiques {{ $faculte->nom }} / {{ $option }} / Session {{ $session }} / Semestre {{ $semestre }}</h5>
	                    {{-- <span>Disabling features that you don't wish to use for a particular table is easily done by setting a variable in the initialisation object</span>
	                    <span>In the following example only the search feature is left enabled (which it is by default).</span> --}}
	                </div>
	                <div class="card-body">
						<div class="row">
							@foreach ($dataStats as $dataStat)
								<div class="col-sm-12 col-xl-6 box-col-6">
									<div class="card">
										<div class="card-header pb-0 text-center">
											<h6>{{ $dataStat['classe'] }}</h6>
										</div>
										<div class="card-body apex-chart">
											<div id="piechart_{{ $loop->iteration }}"></div>
										</div>
									</div>
								</div>
							@endforeach
						</div>
						@php
							$totalFillesAjournees = $totalFilles - $totalFillesAdmises;
							$pourcentageFillesAdmises = ($totalFillesAdmises * 100) / $totalFilles;
							$pourcentageFillesAjournees = 100 - $pourcentageFillesAdmises;

							$totalGarconsAjournes = $totalGarcons - $totalGarconsAdmis;
							$pourcentageGarconsAdmis = ($totalGarconsAdmis * 100) / $totalGarcons;
							$pourcentageGarconsAjournes = 100 - $pourcentageGarconsAdmis;
						@endphp
						<div class="row">
							<div class="col-md-6">
								<h5>Résultats filles</h5>
								<div class="progress">
									<div class="progress-bar progress-bar-striped bg-primary" role="progressbar" style="width: {{ $pourcentageFillesAdmises }}%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
									<div class="progress-bar progress-bar-striped bg-danger" role="progressbar" style="width: {{ $pourcentageFillesAjournees }}%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
								</div>
	
								<div class="mt-3">
									<table>
										<tr>
											<td>Total filles: </td>
											<td><button class="btn btn-info">{{ $totalFilles }} (100%)</button> </td>
										</tr>
										<tr>
											<td>Admises: </td>
											<td><button class="btn btn-success">{{ $totalFillesAdmises }}  ({{ number_format($pourcentageFillesAdmises, 2) }}%)</button> </td>
										</tr>
										<tr>
											<td>Ajournées: </td>
											<td><button class="btn btn-danger">{{ $totalFillesAjournees }}  ({{ number_format($pourcentageFillesAjournees, 2) }}%)</button> </td>
										</tr>
									</table>         
								</div>
							</div>
							<div class="col-md-6">
								<h5>Résultats garçons</h5>
								<div class="progress">
									<div class="progress-bar progress-bar-striped bg-primary" role="progressbar" style="width: {{ $pourcentageGarconsAdmis }}%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
									<div class="progress-bar progress-bar-striped bg-danger" role="progressbar" style="width: {{ $pourcentageGarconsAjournes }}%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
								</div>
	
								<div class="mt-3">
									<table>
										<tr>
											<td>Total garçons: </td>
											<td><button class="btn btn-info">{{ $totalGarcons }} (100%)</button> </td>
										</tr>
										<tr>
											<td>Admis: </td>
											<td><button class="btn btn-success">{{ $totalGarconsAdmis }} ({{ number_format($pourcentageGarconsAdmis, 2) }}%)</button> </td>
										</tr>
										<tr>
											<td>Ajournés: </td>
											<td><button class="btn btn-danger">{{ $totalGarconsAjournes }} ({{ number_format($pourcentageGarconsAjournes, 2) }}%)</button> </td>
										</tr>
									</table>         
								</div>
							</div>
						</div>
	                </div>
	            </div>
	        </div>
	        <!-- Feature Unable /Disable Ends-->
	    </div>
	</div>

	
	@push('scripts')
	{{-- Pie Chart --}}
	<script src="{{ asset('assets/js/chart/apex-chart/apex-chart.js') }}"></script>
    <script src="{{ asset('assets/js/chart/apex-chart/stock-prices.js') }}"></script>
    <script src="{{ asset('assets/js/chart/apex-chart/chart-custom.js') }}"></script>
	<script src="{{ asset('assets/js/tooltip-init.js')}}"></script>
	<script>

		@foreach ($dataStats as $dataStat)
			var options_{{ $loop->iteration }} = {
				chart: {
					width: 380,
					type: 'pie',
				},
				labels: ['Admis', 'Ajournes'],
				series: [{{ $dataStat['admis'] }}, {{ $dataStat['ajournes'] }}],
				responsive: [{
					breakpoint: 480,
					options: {
						chart: {
							width: 200
						},
						legend: {
							position: 'bottom'
						}
					}
				}],
				colors:[vihoAdminConfig.primary, '#FF0000']
				// colors:[vihoAdminConfig.primary, vihoAdminConfig.secondary, '#222222', '#717171', '#e2c636']
			}
			
			var chart_{{ $loop->iteration }} = new ApexCharts(
				document.querySelector("#piechart_{{ $loop->iteration }}"),
				options_{{ $loop->iteration }}
			);

			chart_{{ $loop->iteration }}.render();
		@endforeach



	</script>

	{{-- Doughnut Chart --}}
	<script src="{{ asset('assets/js/chart/chartjs/chart.min.js') }}"></script>
    <script src="{{ asset('assets/js/chart/chartjs/chart.custom.js') }}"></script>
	@endpush

@endsection