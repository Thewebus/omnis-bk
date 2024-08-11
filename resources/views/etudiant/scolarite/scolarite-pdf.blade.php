<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Bootstrap css-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- App css-->
    <title>Scolarité</title>
</head>
<body>
    <div class="container grid-wrrapper">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Scolarité étudiant : {{ Auth::user()->fullname }}</h5>
                        <span>Use class<code>.table-primary</code> inside thead tr element.</span>
                    </div>
                    <div class="card-block row">
                        <div class="col-sm-12">
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>



