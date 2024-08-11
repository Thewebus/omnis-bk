@extends('layouts.etudiant.master')

@section('title')Echéancier
 {{ $title }}
@endsection

@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/date-picker.css') }}">
@endpush

@section('content')
	@component('components.breadcrumb')
		@slot('breadcrumb_title')
			<h3>Echéancier</h3>
		@endslot
		{{-- <li class="breadcrumb-item">Bootstrap Tables</li> --}}
		<li class="breadcrumb-item active">Modifier Echéancier</li>
	@endcomponent
	
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-12">
				<div class="card">
					<div class="card-header">
						<h5>Remplir l'échéancier</h5>
						<span>
							Example of <code>horizontal</code> table borders. This is a default table border style attached to <code> .table</code> class.All borders have the same grey color and style, table itself doesn't have a border, but
							you can add this border using<code> .table-bordered</code>class added to the table with <code>.table</code>class.
						</span>
					</div>
					<div class="table-responsive">
						<form class="theme-form" action="{{ route('user.echeancier.update', $echeancier->id) }}" method="post">
							@csrf
							@method('PUT')
							<table class="table table-bordered">
								<thead>
									<tr>
										<th scope="col">#</th>
										<th scope="col">Nbr Versements</th>
										<th scope="col">Dates</th>
										<th scope="col">Sommes</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<th scope="row">1</th>
										<td>Versement 1</td>
										<td>
											<div class="form-group row">
												<div class="col-xl-12 col-sm-12">
													<div class="input-group">
														<input class="datepicker-here form-control digits @error('date_1') is-invalid @enderror" type="text" value="{{ old('date_1') ?? $echeancier->date_1 }}"  name="date_1" data-language="fr" />
														@error('date_1')
															<span class="invalid-feedback" role="alert">
																<strong>{{ $message }}</strong>
															</span>
														@enderror
													</div>
												</div>
											</div>
										</td>
										<td>
											<div class="form-group">
												<input class="form-control @error('versement_1') is-invalid @enderror" type="number" value="{{ old('versement_1') ?? $echeancier->versement_1 }}" name="versement_1">
												@error('versement_1')
													<span class="invalid-feedback" role="alert">
														<strong>{{ $message }}</strong>
													</span>
												@enderror
											</div>
										</td>
									</tr>
									<tr>
										<th scope="row">2</th>
										<td>Versement 2</td>
										<td>
											<div class="form-group row">
												<div class="col-xl-12 col-sm-12">
													<div class="input-group">
														<input class="datepicker-here form-control digits @error('date_2') is-invalid @enderror" type="text" value="{{ old('date_2') ?? $echeancier->date_2 }}" name="date_2" data-language="en" />
														@error('date_2')
															<span class="invalid-feedback" role="alert">
																<strong>{{ $message }}</strong>
															</span>
														@enderror
													</div>
												</div>
											</div>
										</td>
										<td>
											<div class="form-group">
												<input class="form-control @error('versement_2') is-invalid @enderror" type="number" value="{{ old('versement_2') ?? $echeancier->versement_2 }}" name="versement_2">
												@error('versement_2')
													<span class="invalid-feedback" role="alert">
														<strong>{{ $message }}</strong>
													</span>
												@enderror
											</div>
										</td>
									</tr>
									<tr>
										<th scope="row">3</th>
										<td>Versement 3</td>
										<td>
											<div class="form-group row">
												<div class="col-xl-12 col-sm-12">
													<div class="input-group">
														<input class="datepicker-here form-control digits @error('date_3') is-invalid @enderror" type="text" value="{{ old('date_3') ?? $echeancier->date_3 }}" name="date_3" data-language="en" />
														@error('date_3')
															<span class="invalid-feedback" role="alert">
																<strong>{{ $message }}</strong>
															</span>
														@enderror
													</div>
												</div>
											</div>
										</td>
										<td>
											<div class="form-group">
												<input class="form-control @error('versement_3') is-invalid @enderror" type="number" value="{{ old('versement_3') ?? $echeancier->versement_3 }}" name="versement_3">
												@error('versement_3')
													<span class="invalid-feedback" role="alert">
														<strong>{{ $message }}</strong>
													</span>
												@enderror
											</div>
										</td>
									</tr>
									<tr>
										<th scope="row">4</th>
										<td>Versement 4</td>
										<td>
											<div class="form-group row">
												<div class="col-xl-12 col-sm-12">
													<div class="input-group">
														<input class="datepicker-here form-control digits @error('date_4') is-invalid @enderror" type="text" value="{{ old('date_4') ?? $echeancier->date_4 }}" name="date_4" data-language="en" />
														@error('date_4')
															<span class="invalid-feedback" role="alert">
																<strong>{{ $message }}</strong>
															</span>
														@enderror
													</div>
												</div>
											</div>
										</td>
										<td>
											<div class="form-group">
												<input class="form-control @error('versement_4') is-invalid @enderror" type="number" value="{{ old('versement_4') ?? $echeancier->versement_4 }}" name="versement_4">
												@error('versement_4')
													<span class="invalid-feedback" role="alert">
														<strong>{{ $message }}</strong>
													</span>
												@enderror
											</div>
										</td>
									</tr>
									<tr>
										<th scope="row">5</th>
										<td>Versement 5</td>
										<td>
											<div class="form-group row">
												<div class="col-xl-12 col-sm-12">
													<div class="input-group">
														<input class="datepicker-here form-control digits @error('date_5') is-invalid @enderror" type="text" value="{{ old('date_5') ?? $echeancier->date_5 }}" name="date_5" data-language="en" />
														@error('date_5')
															<span class="invalid-feedback" role="alert">
																<strong>{{ $message }}</strong>
															</span>
														@enderror
													</div>
												</div>
											</div>
										</td>
										<td>
											<div class="form-group">
												<input class="form-control @error('versement_5') is-invalid @enderror" type="number" value="{{ old('versement_5') ?? $echeancier->versement_5 }}" name="versement_5">
												@error('versement_5')
													<span class="invalid-feedback" role="alert">
														<strong>{{ $message }}</strong>
													</span>
												@enderror
											</div>
										</td>
									</tr>
									<tr>
										<th scope="row">6</th>
										<td>Versement 6</td>
										<td>
											<div class="form-group row">
												<div class="col-xl-12 col-sm-12">
													<div class="input-group">
														<input class="datepicker-here form-control digits @error('date_6') is-invalid @enderror" type="text" value="{{ old('date_6') ?? $echeancier->date_6 }}" name="date_6" data-language="en" />
														@error('date_6')
															<span class="invalid-feedback" role="alert">
																<strong>{{ $message }}</strong>
															</span>
														@enderror
													</div>
												</div>
											</div>
										</td>
										<td>
											<div class="form-group">
												<input class="form-control @error('versement_6') is-invalid @enderror" type="number" value="{{ old('versement_6') ?? $echeancier->versement_6 }}" name="versement_6">
												@error('versement_6')
													<span class="invalid-feedback" role="alert">
														<strong>{{ $message }}</strong>
													</span>
												@enderror
											</div>
										</td>
									</tr>
									<tr>
										<th scope="row">7</th>
										<td>Versement 7</td>
										<td>
											<div class="form-group row">
												<div class="col-xl-12 col-sm-12">
													<div class="input-group">
														<input class="datepicker-here form-control digits @error('date_7') is-invalid @enderror" type="text" value="{{ old('date_7') ?? $echeancier->date_7 }}" name="date_7" data-language="en" />
														@error('date_7')
															<span class="invalid-feedback" role="alert">
																<strong>{{ $message }}</strong>
															</span>
														@enderror
													</div>
												</div>
											</div>
										</td>
										<td>
											<div class="form-group">
												<input class="form-control @error('versement_7') is-invalid @enderror" type="number" value="{{ old('versement_7') ?? $echeancier->versement_7 }}" name="versement_7">
												@error('versement_7')
													<span class="invalid-feedback" role="alert">
														<strong>{{ $message }}</strong>
													</span>
												@enderror
											</div>
										</td>
									</tr>
								</tbody>
							</table>
							<button class="btn btn-success m-20" type="submit">Valider l'échéancier</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>	
	
	@push('scripts')
	<script src="{{ asset('assets/js/datepicker/date-picker/datepicker.js') }}"></script>
    <script src="{{ asset('assets/js/datepicker/date-picker/datepicker.en.js') }}"></script>
    <script src="{{ asset('assets/js/datepicker/date-picker/datepicker.custom.js') }}"></script>
	@endpush

@endsection