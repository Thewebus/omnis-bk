@extends('layouts.professeur.master')


@section('title')Emploi du temps
 {{ $title }}
@endsection

@push('css')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/prism.css')}}">
@endpush

@section('content')
	@component('components.professeur.breadcrumb')
        @slot('breadcrumb_title')
            <h3>Accueil</h3>
        @endslot
        <li class="breadcrumb-item">Tableau de bord</li>
        <li class="breadcrumb-item active">Emploi du temps</li>
    @endcomponent

    <div class="container-fluid grid-wrrapper">
        <div class="row">
            <div class="col-sm-12">
				<div class="card">
					<div class="card-header">
						<h5>Emploi du temps {{ Auth::user()->nom }}</h5>
						{{-- <span>Use class<code>.table-primary</code> inside thead tr element.</span> --}}
					</div>
					<div class="card-block row">
						<div class="col-sm-12 col-lg-12 col-xl-12">
							<div class="table-responsive">
								<table class="table table-bordered">
									<thead class="table-primary">
										<tr>
											<th scope="col">Heure</th>
											@foreach ($jours as $jour)
												<th scope="col" class="text-center">{{ $jour }}</th> 
											@endforeach
										</tr>
									</thead>
									<tbody>
										@foreach ($donneesCalendrier as $heure => $jours)
											<tr>
												<th scope="row">{{ $heure }}</th>
												@foreach ($jours as $valeur)
													@if (is_array($valeur))
														<td rowspan="{{ $valeur['rowspan'] }}" class="align-middle text-center" style="background-color:#f0f0f0">
															{{ $valeur['matiere_nom'] }} <br>
															Salle : {{ $valeur['salle_nom'] }} <br>
														</td>
													@elseif ($valeur === 1)
														<td></td>
													@endif
												@endforeach
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
      </div>

@endsection

@push('scripts')
<script src="{{ asset('assets/js/tooltip-init.js')}}"></script>
@endpush