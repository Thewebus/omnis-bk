<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<title>Echeancier</title>
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<div class="card">
					<div class="card-header">
						<h5>Echéancier {{ $echeancier->etudiant->fullname }}</h5>
						<span>
							Example of <code>horizontal</code> table borders. This is a default table border style attached to <code> .table</code> class.All borders have the same grey color and style, table itself doesn't have a border, but
							you can add this border using<code> .table-bordered</code>class added to the table with <code>.table</code>class.
						</span>
					</div>
					<div class="table-responsive">
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
									<td>{{ $echeancier->date_1 ?? '' }}</td>
									<td>{{ $echeancier->versement_1 ?? '' }}</td>
								</tr>
								<tr>
									<th scope="row">2</th>
									<td>Versement 2</td>
									<td>{{ $echeancier->date_2 ?? '' }}</td>
									<td>{{ $echeancier->versement_2 ?? '' }}</td>
								</tr>
								<tr>
									<th scope="row">3</th>
									<td>Versement 3</td>
									<td>{{ $echeancier->date_3 ?? '' }}</td>
									<td>{{ $echeancier->versement_3 ?? '' }}</td>
								</tr>
								<tr>
									<th scope="row">4</th>
									<td>Versement 4</td>
									<td>{{ $echeancier->date_4 ?? '' }}</td>
									<td>{{ $echeancier->versement_4 ?? '' }}</td>
								</tr>
								<tr>
									<th scope="row">5</th>
									<td>Versement 5</td>
									<td>{{ $echeancier->date_5 ?? '' }}</td>
									<td>{{ $echeancier->versement_5 ?? '' }}</td>
								</tr>
								<tr>
									<th scope="row">6</th>
									<td>Versement 6</td>
									<td>{{ $echeancier->date_6 ?? '' }}</td>
									<td>{{ $echeancier->versement_6 ?? '' }}</td>
								</tr>
								<tr>
									<th scope="row">7</th>
									<td>Versement 7</td>
									<td>{{ $echeancier->date_7 ?? '' }}</td>
									<td>{{ $echeancier->versement_7 ?? '' }}</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>	
</body>
</html>
