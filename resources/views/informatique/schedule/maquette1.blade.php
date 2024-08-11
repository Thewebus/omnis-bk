@extends('layouts.informatique.master')


@section('title')Emploi du temps
 {{ $title }}
@endsection

@push('css')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/prism.css')}}">
@endpush

@section('content')
    @component('components.breadcrumb')
        @slot('breadcrumb_title')
            <h3>Grid</h3>
        @endslot
        <li class="breadcrumb-item">Base</li>
        <li class="breadcrumb-item active">Grid</li>
    @endcomponent

    <div class="container-fluid grid-wrrapper">
        <div class="row">
            <div class="col-sm-12">
				<div class="card">
					<div class="card-header">
						<h5>Table head options</h5>
						{{-- <span>Use class<code>.table-primary</code> inside thead tr element.</span> --}}
					</div>
					<div class="card-block row">
						<div class="col-sm-12 col-lg-12 col-xl-12">
							<div class="table-responsive">
								<table class="table">
									<thead class="table-primary">
										<tr>
											<th scope="col">Heure</th>
											<th scope="col">Lundi</th>
											<th scope="col">Mardi</th>
											<th scope="col">Mercredi</th>
											<th scope="col">Jeudi</th>
											<th scope="col">Vendredi</th>
											<th scope="col">Samedi</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<th scope="row">8:00 - 9:00</th>
											<td></td>
											<td>Mathematique</td>
											<td></td>
											<td></td>
											<td>Anglais</td>
											<td></td>
										</tr>
										<tr>
											<th scope="row">9:00 - 10:00</th>
											<td></td>
											<td>Mathematique</td>
											<td></td>
											<td></td>
											<td>Anglais</td>
											<td></td>
										</tr>
										<tr>
											<th scope="row">10:00 - 11:00</th>
											<td></td>
											<td>Mathematique</td>
											<td>Français</td>
											<td>Français</td>
											<td>Anglais</td>
											<td></td>
										</tr>
                                        <tr>
											<th scope="row">11:00 - 12:00</th>
											<td></td>
											<td></td>
											<td>Français</td>
											<td>Français</td>
											<td>Anglais</td>
											<td></td>
										</tr>
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