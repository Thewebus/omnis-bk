<div class="col-4">
    <div class="card-header pb-0 mb-3">
        <h5>Stat repêchage</h5>
    </div>
    
    @if (!is_null($matiere) || !is_null($ue))
        <div class="card">
            <div class="card-header pb-0">
                <h6>{{ $matiere ? $matiere['nom'] : $ue->nom }}</h6>
            </div>
            @if (session()->has('message'))
                <div class="my-3">
                    <div class="alert alert-danger">
                        {{ session('message') }}
                    </div>
                </div>
            @endif
            @if (session()->has('success'))
                <div class="my-3">
                    <div class="alert alert-primary">
                        {{ session('success') }}
                    </div>
                </div>
            @endif
            <div class="form theme-form">
                <div class="card-body">
                    <div class="row">
                        <div class="mb-3 row">
                            <label class="col-sm-6 col-form-label">Note de repêchage</label>
                            <div class="col-sm-6">
                                <input class="form-control @error('note') is-invalid @enderror" type="number" step="0.01" wire:model.lazy="note" placeholder="Note de repêchage" />
                                @error('note')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <button class="btn btn-warning" wire:click="statistiques" wire:change="statistiques"><i class="fa fa-check"></i> Tester</button>
                    <button class="btn btn-primary" wire:click="save"><i class="fa fa-save"></i> Valider</button>
                </div>
            </div>
        </div>

        <div class="progress">
            <div class="progress-bar progress-bar-striped bg-primary" role="progressbar" style="width: {{ $pourcentageAdmis }}%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
            <div class="progress-bar progress-bar-striped bg-danger" role="progressbar" style="width: {{ $pourcentageAjournes }}%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
        </div>

        <div class="mt-3">
            <table>
                <tr>
                    <td>Admis: </td>
                    <td><button class="btn btn-success">{{ $admis }} ({{ number_format($pourcentageAdmis, 2) }}%)</button> </td>
                </tr>
                <tr>
                    <td>Ajourné: </td>
                    <td><button class="btn btn-danger">{{ $ajournes }} ({{ number_format($pourcentageAjournes, 2) }}%)</button> </td>
                </tr>
                <tr>
                    <td>Nbr Etudiants: </td>
                    <td><button class="btn btn-info">{{ $nbrEtudiants }}</button> </td>
                </tr>
            </table>         
        </div>
    @else
        <h5>Sélectionner une matière</h5>
    @endif
</div>