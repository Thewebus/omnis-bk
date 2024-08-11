@extends('layouts.etudiant.master')

@section('title')Scolarité
 {{ $title }}
@endsection

@push('css')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/prism.css')}}">
@endpush

@section('content')
    @component('components.breadcrumb')
        @slot('breadcrumb_title')
            <h3>Scolarité</h3>
        @endslot
        <li class="breadcrumb-item">Accueil</li>
        <li class="breadcrumb-item active">Scolarité</li>
    @endcomponent

    <div class="container-fluid grid-wrrapper">
        <div class="row">
            <div class="col-sm-12">
				<div class="card">
					<div class="card-header">
						<h5>Scolarité étudiant : {{ Auth::user()->fullname }}</h5>
						<span>Use class<code>.table-primary</code> inside thead tr element.</span>
					</div>
					<div class="card-block row">
						<div class="col-sm-12 col-lg-12 col-xl-12">
							<div class="table-responsive">
								<table class="table">
									<thead class="table-primary">
										<tr>
											<th scope="col">N°</th>
											<th scope="col">Montant</th>
											<th scope="col">N° Operation</th>
											<th scope="col">Reste</th>
											<th scope="col">Date</th>
											<th scope="col">Scolarité</th>
										</tr>
									</thead>
									<tbody>
                                        @if (count($scolarites) > 0)
                                            @foreach ($scolarites as $scolarite)
                                                <tr>
                                                    <th scope="row">{{ $loop->iteration }}</th>
                                                    <td>{{ $scolarite['montant'] }}</td>
                                                    <td>{{ $scolarite['numero_operation'] }}</td>
                                                    <td>{{ $scolarite['reste'] }}</td>
                                                    <td>{{ $scolarite['created_at']->format('d/m/Y') }}</td>
                                                    <td>{{ $scolarite['scolarite'] }}</td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="6" class="text-center">No Data</td>
                                            </tr>
                                        @endif
									</tbody>
								</table>
							</div>
						</div>
                        <div class="col-md-12 text-center mt-3">
                            <a href="{{ route('user.scolarite-pdf') }}" class="btn btn-success"><i class="fa fa-download"></i> Télécharger</a>
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