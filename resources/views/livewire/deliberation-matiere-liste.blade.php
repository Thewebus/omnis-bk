<div class="col-4 right-divider">
    @if (!is_null($matieres))
    <h6>{{ $classe['nom'] }}</h6>
    <div class="table-wrapper-scroll-y my-custom-scrollbar">
        <table class="table table-bordered table-striped mb-0">
            <thead>
                <tr>
                    <th>N°</th>
                    <th>
                        {{ $annee->id == 1 ? 'Matières' : 'Unité d\'enseignement' }}
                        
                    </th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @if ($matieres->count() !== 0 || count($ues) !== 0)
                    @if ($annee->id > 1 && ($action == 'deliberation' || $action == 'deliberation-session-2'))
                        @foreach ($ues as $ue)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $ue->nom }}</td>
                                <td>
                                    @php
                                        $ue = json_encode([$ue, 'classe_id' => $classe['id']]);
                                    @endphp
                                    @if ($action == 'deliberation')
                                        <button class="btn btn-primary" type="button" wire:click="repechageStat({{ $ue }})"><i class="fa fa-eye"></i></button>
                                    @elseif ($action == 'deliberation-session-2')
                                        <button class="btn btn-primary" type="button" wire:click="deliberationSession2({{ $ue }})"><i class="fa fa-eye"></i></button>
                                    @else
                                        <button class="btn btn-danger" type="button">Something gone wrong</button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @else
                        @foreach ($matieres as $matiere)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $matiere->nom }}</td>
                                <td>
                                    @if ($action == 'deliberation')
                                        <button class="btn btn-primary" type="button" wire:click="repechageStat({{ $matiere }})"><i class="fa fa-eye"></i></button>
                                    @elseif($action == 'session2')
                                        <button class="btn btn-primary" type="button" wire:click="noteSession2({{ $matiere->id }})"><i class="fa fa-eye"></i></button>
                                    @elseif($action == 'liste-note-session2')
                                        <button class="btn btn-primary" type="button" wire:click="affichageNoteSession2({{ $matiere->id }})"><i class="fa fa-eye"></i></button>
                                    @elseif ($action == 'modification-note-session-2')
                                        <button class="btn btn-primary" type="button" wire:click="modificationNoteSession2({{ $matiere->id }})"><i class="fa fa-eye"></i></button>
                                    @elseif ($action == 'deliberation-session-2')
                                        <button class="btn btn-primary" type="button" wire:click="deliberationSession2({{ $matiere }})"><i class="fa fa-eye"></i></button>
                                    @else
                                        <button class="btn btn-danger" type="button">Something gone wrong</button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @endif
                @else
                    <tr>
                        <td colspan="4" class="text-center">No data</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
    @else
        <h4 class="mt-5">Aucune Classe selectionnée</h4>
    @endif
</div>
