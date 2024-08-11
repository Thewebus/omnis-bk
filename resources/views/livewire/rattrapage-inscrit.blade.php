<div class="row">
    <div class="mb-3 row">
        <label class="col-sm-3 col-form-label">Nom Etudiant</label>
        <div class="col-sm-9">
            <select class="col-sm-12 form-select digits @error('etudiant') is-invalid @enderror" wire:model="etudiant" name="etudiant">
                <option value="">Choisir l'étudiant</option>
                @foreach ($etudiants as $etudiant)
                    <option value="{{ $etudiant->id }}" {{ old('etudiant') == $etudiant->id ? 'selected' : '' }} >{{ $etudiant->fullname }}</option>
                @endforeach
            </select>
            @error('etudiant')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="mb-3 row">
        <label class="col-sm-3 col-form-label">Matière</label>
        <div class="col-sm-9">
            <select class="col-sm-12 form-select digits @error('matiere') is-invalid @enderror" wire:model="matiere" name="matiere">
                <option value="">Choisir la matière</option>
                @foreach ($matieres as $matiere)
                    <option value="{{ $matiere->id }}" {{ old('matiere') == $matiere->id ? 'selected' : '' }} >{{ $matiere->nom }}</option>
                @endforeach
            </select>
            @error('matiere')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="mb-3 row">
        <label class="col-sm-3 col-form-label">Note</label>
        <div class="col-sm-9">
            <input class="form-control @error('note') is-invalid @enderror" type="number" name="note" value="{{ old("note") }}" placeholder="note matière" />
            @error('note')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
</div>