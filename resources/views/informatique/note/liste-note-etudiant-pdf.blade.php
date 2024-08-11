<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Notes étudiants </title>
	<style>
		body, html {
			height: 100%;
			margin: 0;
			font-family: Arial, Helvetica, sans-serif;
		}

		.container {
			margin: 5%;
		}

		.table {
			font-size: 0.8rem;
			margin-bottom: .5rem;
		}

		.align-center {
			text-align: center;
		}

		/* Les descendants de rang impair sont stylés avec une couleur     */
		tbody:nth-child(odd)  { background-color : #CED4E5; }
		/* Les descendants de rang pair sont stylés avec une autre couleur */
		tbody:nth-child(even) { background-color : #E8EBF5; }
		th { background-color : #557CBA; padding:0.3em; }
		td { padding:0.3em; }

		h2 {
			text-align: center;
		}

		.bloc-header .annee-session{
            display: inline-block;
            font-size: 1rem;
        }
        .img {
            margin-bottom: 2em;
            border: 1px solid #e6edef;
            width: 30%;
            height: 11.5%;
            margin-top: -50px;
        }
        .ministere {
            text-align: center;
            width: 60%;
            position: fixed;
            left: 45%;
            top: -40px
        }
		.faculte {
			margin-top: -90px;
			width: 100%;
			vertical-align: middle;
			height: 60px;
            background-color: #1a0a8f;
            color: #fff;
            border-radius: 0.25rem;
            text-align: center;			
		}
		.classe {
			margin-top: -100px;
			width: 100%;
			vertical-align: middle;
            text-align: center;
		}
		.annee-session {
			position: absolute;
			right: 5%;
			top: 10%;
		}
		.semestre-1 {
			display: flex;
			flex-direction: row;
			justify-content: space-between;
			width: 100%;
			font-weight: bold;
			margin-bottom: 15px;
		}
		.semestre-2 {
			margin: 2rem 0;
			font-weight: bold;
		}
		.etudiant {
			margin-left: 40%;
		}
	</style>
</head>
<body>
    <div class="container">
		<div class="bloc-header">
			<div class="img">
				<img src="https://ua.omnis-ci.com/assets/images/logo_ua.png" width="450" alt="LOGO UA">
			</div>
			<div class="ministere">
				<span>REPUBLIQUE DE CÔTE D'IVOIRE <br> -------------------------- <br></span>
				<span>UNION - DISCIPLINE - TRAVAIL <br> ---------------------- <br></span>
				<span>MINISTERE DE L'ENSEINGNEMENT SUPÉRIEUR <br> ET DE LA RECHERCHE SCIENTITFIQUE</span>
			</div>
		</div>
		<div class="annee-session">
			<span class="annee-academique">Année Académique {{ $anneeAcademique->debut }} - {{ $anneeAcademique->fin }}</span>
		</div>
		<div class="faculte">
			<h3>{{ $inscription->classe->niveauFaculte->faculte->nom }}</h3>
		</div>
		<div class="classe">
			<h4>{{ $inscription->classe->nom }}</h4>
		</div>
		<div class="semestre-1">
			<span>SEMESTRE 1</span>	
			<span class="etudiant">{{ $etudiant->fullname }}</span>
		</div>

		<table class="table">
			<thead class="bg-primary">
				<tr>
					<th>#</th>
					<th>Matières</th>
					<th class="align-center">Note 1</th>
					<th class="align-center">Note 2</th>
					<th class="align-center">Note 3</th>
					<th class="align-center">Note 4</th>
					{{-- <th scope="col">Note 5</th> --}}
					{{-- <th scope="col">Note 6</th> --}}
					<th class="align-center">Partiel sess. 1</th>
					<th class="align-center">Moyenne</th>
					<th class="align-center">Moyenne sess. 2</th>
					{{-- <th scope="col">Partiel sess. 2</th> --}}
					{{-- <th scope="col">Dec. finale</th> --}}
				</tr>
			</thead>
			<tbody>
				@foreach ($dataNotesSem1 as $dataNote)
					<tr>
						<td scope="row">{{ $loop->iteration }}</td>
						<td>{{ $dataNote['nom_matiere'] }}</td>
						<td class="align-center">{{ $dataNote['note_1'] == 'NONE' ? '-' : $dataNote['note_1'] }}</td>
						<td class="align-center">{{ $dataNote['note_2'] == 'NONE' ? '-' : $dataNote['note_2'] }}</td>
						<td class="align-center">{{ $dataNote['note_3'] == 'NONE' ? '-' : $dataNote['note_3'] }}</td>
						<td class="align-center">{{ $dataNote['note_4'] == 'NONE' ? '-' : $dataNote['note_4'] }}</td>
						{{-- <td>{{ $dataNote['note_5'] }}</td>
						<td>{{ $dataNote['note_6'] }}</td> --}}
						<td class="align-center">{{ $dataNote['partiel_session_1']  == 'NONE' ? '-' : $dataNote['partiel_session_1'] }}</td>
						<td class="align-center">{{ $dataNote['moyenne'] }}</td>
						<td class="align-center">{{ $dataNote['partiel_session_2']  == 'NONE' ? '-' : $dataNote['partiel_session_2'] }}</td>
						{{-- <td>{{ $dataNote['partiel_session_2'] }}</td> --}}
						{{-- <td>
							@if ($dataNote['decision_finale'] == 'admis')
								<span class="badge badge-primary">Admis</span>
							@elseif($dataNote['decision_finale'] == 'ajourné')
								<span class="badge badge-danger">Ajourné</span>
							@else
								<span class="badge badge-warning">NONE</span>
							@endif
						</td> --}}
					</tr>
				@endforeach
			</tbody>
		</table>
						
		@isset($dataNotesSem2)

			<span class="semestre-2">SEMESTRE 2</span>

			<table class="table">
				<thead class="bg-primary">
					<tr>
						<th>#</th>
						<th>Matières</th>
						<th class="align-center">Note 1</th>
						<th class="align-center">Note 2</th>
						<th class="align-center">Note 3</th>
						<th class="align-center">Note 4</th>
						{{-- <th scope="col">Note 5</th> --}}
						{{-- <th scope="col">Note 6</th> --}}
						<th class="align-center">Partiel sess. 1</th>
						<th class="align-center">Moyenne</th>
						<th class="align-center">Moyenne sess. 2</th>
						{{-- <th scope="col">Partiel sess. 2</th> --}}
						{{-- <th scope="col">Dec. finale</th> --}}
					</tr>
				</thead>
				<tbody>
					@foreach ($dataNotesSem2 as $dataNote)
						<tr>
							<td scope="row">{{ $loop->iteration }}</td>
							<td>{{ $dataNote['nom_matiere'] }}</td>
							<td class="align-center">{{ $dataNote['note_1'] == 'NONE' ? '-' : $dataNote['note_1'] }}</td>
							<td class="align-center">{{ $dataNote['note_2'] == 'NONE' ? '-' : $dataNote['note_2'] }}</td>
							<td class="align-center">{{ $dataNote['note_3'] == 'NONE' ? '-' : $dataNote['note_3'] }}</td>
							<td class="align-center">{{ $dataNote['note_4'] == 'NONE' ? '-' : $dataNote['note_4'] }}</td>
							{{-- <td>{{ $dataNote['note_5'] }}</td>
							<td>{{ $dataNote['note_6'] }}</td> --}}
							<td class="align-center">{{ $dataNote['partiel_session_1']  == 'NONE' ? '-' : $dataNote['partiel_session_1'] }}</td>
							<td class="align-center">{{ $dataNote['moyenne'] }}</td>
							<td class="align-center">{{ $dataNote['partiel_session_2']  == 'NONE' ? '-' : $dataNote['partiel_session_2'] }}</td>
							{{-- <td>{{ $dataNote['partiel_session_2'] }}</td> --}}
							{{-- <td>
								@if ($dataNote['decision_finale'] == 'admis')
									<span class="badge badge-primary">Admis</span>
								@elseif($dataNote['decision_finale'] == 'ajourné')
									<span class="badge badge-danger">Ajourné</span>
								@else
									<span class="badge badge-warning">NONE</span>
								@endif
							</td> --}}
						</tr>
					@endforeach
				</tbody>
			</table>

		@endisset
	</div>

	{{-- <table>
		<thead>
			<tr><th>Customer</th><th>Order</th><th>Month</th></tr>
		</thead>
		<tbody>
			<tr><td>Customer 1</td><td>#1</td><td>January</td></tr>
			<tr><td>Customer 1</td><td>#2</td><td>April</td></tr>
			<tr><td>Customer 1</td><td>#3</td><td>March</td></tr>
		</tbody>
		<tbody>
			<tr><td>Customer 2</td><td>#1</td><td>January</td></tr>
			<tr><td>Customer 2</td><td>#2</td><td>April</td></tr>
			<tr><td>Customer 2</td><td>#3</td><td>March</td></tr>
		</tbody>
		<tbody>
			<tr><td>Customer 3</td><td>#1</td><td>January</td></tr>
			<tr><td>Customer 3</td><td>#2</td><td>April</td></tr>
			<tr><td>Customer 3</td><td>#3</td><td>March</td></tr>
		</tbody>
	</table> --}}
</body>
</html>