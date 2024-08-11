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
			margin: 2% 0;
			font-family: Arial, Helvetica, sans-serif;
		}

		.container {
			margin: 5%;
		}

		.table {
			font-size: 0.8rem;
			margin-bottom: .5rem;
			width: 100%;
		}

		.align-center {
			text-align: center;
		}

		/* Les descendants de rang impair sont stylés avec une couleur     */
		tbody:nth-child(odd)  { background-color : #CED4E5; }
		/* Les descendants de rang pair sont stylés avec une autre couleur */
		tbody:nth-child(even) { background-color : #E8EBF5; }
		th { background-color : #557CBA; padding:0.2em; }
		td { padding:0.2em; }

		h2 {
			text-align: center;
		}

		.bloc-header .annee-session{
            display: inline-block;
            font-size: 1rem;
        }
        .img {
            margin-bottom: 3em;
            border: 1px solid #e6edef;
            width: 30%;
            height: 11.5%;
            margin-top: -150px;
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
			<span class="annee-academique">
				@if (env('OWNER') == 'ua_abidjan')
					UA ABIDJAN
				@elseif (env('OWNER') == 'ua_bassam')
					UA BASSAM
				@elseif (env('OWNER') == 'ua_bouake')
					UA BOUAKE
				@else
					UA SAN-PEDRO
				@endif
			</span>
		</div>
		<div class="faculte">
			<h3>Fiche d'enseignants</h3>
		</div>
		{{-- <div class="classe">
			<h4>{{ $inscription->classe->nom }}</h4>
		</div> --}}
		{{-- <div class="semestre-1">
			<span>SEMESTRE 1</span>	
			<span class="etudiant">{{ $etudiant->fullname }}</span>
		</div> --}}

		<table class="table">
			<thead class="bg-primary">
				<tr>
					<th>#</th>
					<th class="align-center">NOMS ENSEIGNANTS</th>
					<th class="align-center">CONTACT</th>
					{{-- <th class="align-center">Grade</th> --}}
					{{-- <th class="align-center">ECOLES</th> --}}
					<th class="align-center">MATIÈRES ENSIGNÉES</th>
			</thead>
			<tbody>
				@foreach ($profs as $prof)
					<tr>
						<td scope="row">{{ $loop->iteration }}</td>
						<td>{{ $prof->fullname }}</td>
						<td class="align-center">{{ $prof->numero ?? 'NULL' }}</td>
						{{-- <td class="align-center">
							@if (env('OWNER') == 'ua_abidjan')
								UA ABIDJAN
							@elseif (env('OWNER') == 'ua_bassam')
								UA BASSAM
							@elseif (env('OWNER') == 'ua_bouake')
								UA BOUAKE
							@else
								UA SAN-PEDRO
							@endif
						</td> --}}
						<td class="align-center">
							@foreach ($prof->matiereProfesseur as $matProf)
								@isset($matProf->matiere)
									{{ $matProf->matiere->nom }} <br>
								@else
									null
								@endisset
							@endforeach
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</body>
</html>