<div class="col-4">
    @if (!is_null($dataNotes))
        <h6>Liste Notes</h6>
        <div class="card">
            <div class="card-header">
                <span style="font-size: 1rem">matière : <b>{{ $matiere->nom }}</b></span>
            </div>
            <div class="card-block row">
                <div class="col-sm-12 col-lg-12 col-xl-12">
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="bg-primary">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nom & Prénoms</th>
                                    {{-- @foreach ($notesSelectionnees as $notesSelectionnee)
                                        <th scope="col">
                                            @if ($notesSelectionnee == 'partiel_session_1')
                                                Partiel sess. 1
                                            @else
                                                Note {{ $loop->iteration }}
                                            @endif
                                        </th>
                                    @endforeach --}}
                                    <th scope="col">Partiel sess. 2</th>
                                    <th scope="col">Dec. finale</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dataNotes as $dataNote)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $dataNote['nom_etudiant']->fullname }}</td>
                                        {{-- @foreach ($notesSelectionnees as $notesSelectionnee)
                                            <td>{{ $dataNote[$notesSelectionnee] }}</td>
                                        @endforeach --}}
                                        <td>{{ $dataNote['partiel_session_2'] }}</td>
                                        <td>
                                            {!! $dataNote['partiel_session_2'] < 10 || $dataNote['partiel_session_2'] == 'NONE' ? '<span class="badge badge-danger">Ajourné</span>' : '<span class="badge badge-primary">Admis</span>'  !!}
                                            {{-- @if ($dataNote['decision_finale'] == 'admis')
                                                <span class="badge badge-primary">Admis</span>
                                            @elseif($dataNote['decision_finale'] == 'ajourné')
                                                <span class="badge badge-danger">Ajourné</span>
                                            @else
                                                <span class="badge badge-warning">NONE</span>
                                            @endif --}}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @else
        <h4 class="mt-5">Selectionner une matière.</h4>
    @endif
</div>
