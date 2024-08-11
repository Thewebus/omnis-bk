<div>
    <div class="mb-3 row">
        <label class="col-sm-3 col-form-label">Classe</label>
        <div class="col-sm-9">
            <select class="form-select digits @error('classe') is-invalid @enderror" id="classe" name="classe" wire:model="classe">
                <option value="">Choisir une classe</option>
                @foreach ($classes as $classe)
                    <option value="{{ $classe->id }}" {{ old('classe') == $classe->id ? 'selected' : '' }}>{{ $classe->nom }}</option>
                @endforeach
            </select>   
            @error('classe')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="row mb-2">
        <label class="col-sm-3 col-form-label">Selection matières</label>
        <div class="col-sm-9">
            <select name="matieres[]" class="form-select @error('matieres[]') is-invalid @enderror" id="exampleFormControlSelect3" multiple="">
                @if (!is_null($matieres))
                    @foreach ($matieres as $matiere)
                        <option value="{{ $matiere->id }}">{{ $matiere->nom }} | {{ $matiere->classe->niveauFaculte->faculte->nom }}</option>
                    @endforeach
                @endif
            </select>
            {{-- <select name="matieres[]" class="js-example-basic-multiple col-sm-12 @error('matieres[]') is-invalid @enderror" multiple="multiple">
                @if (!is_null($matieres))
                    @foreach ($matieres as $matiere)
                        <option value="{{ $matiere->id }}">{{ $matiere->nom }} | {{ $matiere->niveauFiliere->filiere->nom }}</option>
                    @endforeach
                @endif
            </select> --}}
            @error('matieres[]')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
</div>
