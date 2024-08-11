<div class="col-4">
    @if (!is_null($dataNotes))
        <h6>Matière: {{ $matiere->nom }}</h6>
        <form wire:submit.prevent="postSession2({{ $matiere->id }})" method="post">
            @csrf
            @if (session()->has('message'))
                <div class="my-3">
                    <div class="alert alert-success">
                        {{ session('message') }}
                    </div>
                </div>
            @endif
            <div class="table-responsive">
                <table class="table">
                    <thead class="bg-primary">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nom & Prénoms</th>
                            <th scope="col">Partiel</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- <tr>
                            <td>#</td>
                            <td>SYSTEME DE CALCULE</td>
                            <td>
                                <div class="form-group m-t-10 m-checkbox-inline mb-0 custom-radio-ml">
                                    <div class="radio radio-primary">
                                        <input class="radio_animated" id="normal" type="radio" wire:model="systeme" value="normal" checked>
                                        <label class="mb-0" for="normal">NML</label>
                                    </div>
                                    <div class="radio radio-primary">
                                        <input class="radio_animated" id="lmd" type="radio" wire:model="systeme" value="lmd">
                                        <label class="mb-0" for="lmd">LMD</label>
                                    </div>
                                </div>
                                @error('systeme')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </td>
                        </tr> --}}
                        @foreach ($dataNotes as $dataNote)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $dataNote['nom_etudiant']['fullname'] }}</td>
                                <td>
                                    <input class="form-control @error('partiel_session_2') is-invalid @enderror" wire:model="notes.{{ $dataNote['nom_etudiant']['id'] }}" type="number" step="0.01" required placeholder="0" />
                                    @error('notes.' . $dataNote['nom_etudiant']['id'])
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary btn-block my-3 float-right">
                    <i class="fa fa-save"></i> Enregistrez les notes
                </button>
            </div>
        </form>
    @else
        <h4 class="mt-5">Selectionner une matière.</h4>
    @endif
</div>