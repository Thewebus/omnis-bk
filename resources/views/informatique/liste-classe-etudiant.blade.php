@extends("layouts.$master.master")

@section('title')Liste étudiants
	{{ $title }}
@endsection

@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datatables.css') }}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/sweetalert2.css')}}">
<meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
	@component("components.$master.breadcrumb")
		@slot('breadcrumb_title')
			<h3>Liste étudiants classe <b>{{ $classe->nom }}</b></h3>
		@endslot
		<li class="breadcrumb-item">Liste étudiants</li>
		{{-- <li class="breadcrumb-item">Data Tables</li> --}}
		<li class="breadcrumb-item active">Classe <b>{{ $classe->nom }}</b></li>
	@endcomponent

	
	<div class="container-fluid">
	    <div class="row">
	        <!-- Feature Unable /Disable Order Starts-->
	        <div class="col-sm-12">
	            <div class="card">
	                <div class="card-header">
	                    <h5>Liste des étudiants classe <b>{{ $classe->nom }}</b></h5>
	                    <div class="row">
							<div class="col-md-9"></div>
							<div class="col-md-3"><a href="{{ route('admin.liste-classe-pdf', $classe->id) }}" class="btn btn-primary"><i class="fa fa-download"></i> Liste de classe</a></div>
						</div>
	                </div>
	                <div class="card-body">
	                    <div class="table-responsive">
	                        <table class="display" id="basic-2">
	                            <thead>
	                                <tr>
	                                    <th>N°</th>
	                                    <th>Voir Note</th>
	                                    <th>ID Permat.</th>
	                                    <th>Matricule</th>
	                                    <th>N° tbl BAC</th>
	                                    <th>Nom & Prénoms</th>
	                                    <th>Date Nais.</th>
	                                    <th>Lieu Nais.</th>
	                                    <th>Contact</th>
	                                    <th>Faculté</th>
	                                    <th>Établissement</th>
	                                    <th>Code EP</th>
	                                    <th>Emargement</th>
	                                    <th>Action</th>
	                                </tr>
	                            </thead>
	                            <tbody>
									@foreach ($classe->etudiants() as $etudiant)
										@if ($etudiant)
											<tr>
												<td>{{ $loop->iteration }}</td>
												<td>
													<input class="check-note" id="{{ $etudiant->id }}" name="{{ $etudiant->id }}"
													@if($etudiant->notes->first()->show_note ?? null) checked @endif  type="checkbox" value="{{ $etudiant->id }}">
												</td>
												<td><b>{{ $etudiant->id_permanent }}</b></td>
												<td><b>{{ $etudiant->matricule_etudiant }}</b></td>
												<td><b>{{ $etudiant->numero_table_bac }}</b></td>
												<td>
													<label for="{{ $etudiant->id }}">{{ $etudiant->fullname }}</label>
												</td>
												<td><b>{{ $etudiant->date_naissance }}</b></td>
												<td><b>{{ $etudiant->lieu_naissance }}</b></td>
												<td><b>{{ $etudiant->numero_etudiant }}</b></td>
												<td><b>{{ $classe->niveauFaculte->faculte->nom }}</b></td>
												<td><b>{{ __('Etablissement') }}</b></td>
												<td><b>{{ $etudiant->code_ep }}</b></td>
												<td><b>{{ $etudiant->emargement }}</b></td>
												<td style="width: 25vw">
													<a href="{{ route('admin.inscritpion-detail', $etudiant->inscriptions->last()->id) }}"><button class="btn btn-success"><i class="fa fa-eye"></i></button> </a>
													
													<button class="btn btn-danger btn-block" type="button" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $etudiant->id }}"><i class="fa fa-trash-o"></i></button>
													<div class="modal fade" id="deleteModal{{ $etudiant->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModal{{ $etudiant->id }}" aria-hidden="true">
														<div class="modal-dialog modal-dialog-centered" role="document">
															<div class="modal-content">
																<div class="modal-header">
																	<h5 class="modal-title">Suppression étudiant</h5>
																	<button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
																</div>
																<div class="modal-body">
																	<p>
																		Vous êtes sur le point de supprimer définitivement l'étudiant <b>{{ $etudiant->fullname }}</b>.<br>
																		Cette opération est irréversible. <br>
																		Voulez-vous vraiment supprimer ?
																	</p>
																</div>
																<div class="modal-footer">
																	<button class="btn btn-success" type="button" data-bs-dismiss="modal">Fermer</button>
																	<form action="{{ route('admin.etudiant-suppression', $etudiant->id) }}" method="POST">
																		@method('DELETE')
																		@csrf
																		<button class="btn btn-danger" type="submit"><i class="fa fa-trash-o"></i> Supprimer</button>
																	</form>
																</div>
															</div>
														</div>
													</div>
												</td>
											</tr>
										@endif
									@endforeach
	                            </tbody>
	                        </table>
	                    </div>
						<button class="btn btn-success mt-3" onclick="getElementChecked()">Autoriser consultation de note</button>
						{{-- <button class="btn btn-success" id="sweetalert">Sweet Alert</button> --}}
						{{-- <button class="btn btn-success" id="sweetalert">Sweet Alert</button> --}}
	                </div>
	            </div>
	        </div>
	        <!-- Feature Unable /Disable Ends-->
	    </div>
	</div>
	
	@push('scripts')
	<script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}"></script>

	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

	<script>

		// document.getElementById('sweetalert').addEventListener('click', function() {
		// 	Swal.fire({
		// 		icon: 'success',
		// 		title: 'Enrégistré avec succès',
		// 		showConfirmButton: false,
		// 		timer: 2000
		// 	})
		// })
		
		// document.getElementById('sweetalert').addEventListener('click', function() {
		// 	let timerInterval
		// 	Swal.fire({
		// 		title: 'Enregistrement en cours !',
		// 		html: 'I will close in <b></b> milliseconds.',
		// 		timer: 5000,
		// 		timerProgressBar: false,
		// 		didOpen: () => {
		// 			Swal.showLoading()
		// 			const b = Swal.getHtmlContainer().querySelector('b')
		// 			timerInterval = setInterval(() => {
		// 				b.textContent = Swal.getTimerLeft()
		// 			}, 100)
		// 		},
		// 		willClose: () => {
		// 			clearInterval(timerInterval)
		// 		}
		// 	})
		// 	// .then((result) => {
		// 	// 	/* Read more about handling dismissals below */
		// 	// 	if (result.dismiss === Swal.DismissReason.timer) {
		// 	// 		console.log('I was closed by the timer')
		// 	// 	}
		// 	// })
		// })

		async function getElementChecked() {
			var resquest
			var response
			const query_url = window.origin + '/informaticien/notes-show';
			const csrfToken = document.head.querySelector("[name~=csrf-token][content]").content;
			var allSelected = document.querySelectorAll('.check-note:checked');
			var elementChecked = [];
			for (let i = 0; i < allSelected.length; i++) {
				elementChecked.push(allSelected[i].name)
			}

			console.log(document.querySelectorAll('.check-note:checked'));

			const data = {
				method: 'POST',
				headers: {
					"Content-Type": "application/json" ,
				},
				body: JSON.stringify({
					checked: elementChecked,
					_token: csrfToken,
					classe_id: {{ $classe->id }}
				})
			}

			Swal.fire({
				title: 'Modification en cours',
				html: 'Veuillez patienter pendant l\'exécution de cette action.',
				timerProgressBar: false,
				didOpen: () => {
				//here it will open the in progress box
					Swal.showLoading();

					//setTimeout with 1000 or more ms is needed in order to show the inprogress box
					setTimeout(async () => {
						resquest = await fetch(query_url, data)
						response = await resquest.json()
						console.log(response)
						//Automatically close popup so it continues with willClose
						Swal.close();
					}, 3000);
				},
				willClose: () => {
					if(response.has_error == false) {
						Swal.fire({
							icon: 'success',
							title: 'Enrégistré avec succès',
							showConfirmButton: false,
							timer: 3000
						})

						setTimeout(() => {
							location.reload();
						}, 3000);
					}
				}
			})
		}
	</script>
	@endpush

@endsection