<div class="col">
    <div class="mb-3 row">
        <label class="col-sm-3 col-form-label">Filière</label>
        <div class="col-sm-9">
            <select class="form-select digits @error('filiere') is-invalid @enderror" id="filiere" name="filiere" wire:model="filiere">
                <option selected value="">Choisir une filière</option>
                @foreach ($filieres as $filiere)
                <option value="{{ $filiere->id }}" {{ ($classe->niveauFiliere->filiere ? $classe->niveauFiliere->filiere->id : old('filiere')) == $filiere->id ? 'selected' : '' }}>{{ $filiere->nom }}</option>
                @endforeach
            </select>
            @error('filiere')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="mb-3 row">
        <label class="col-sm-3 col-form-label">Niveau Filière</label>
        <div class="col-sm-9">
            <select class="form-select digits @error('niveau') is-invalid @enderror" id="niveau" name="niveau">
                <option selected value="">Choisir un niveau</option>
                @if (!is_null($filiere))
                    @foreach ($niveaux as $niveau)
                        <option value="{{ $niveau->id }}" {{ ($classe->niveauFiliere ? $classe->niveauFiliere->id : old('niveau')) == $niveau->id ? 'selected' : '' }}>{{ $niveau->nom }}</option>
                    @endforeach
                @endif
            </select>
            @error('niveau')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="mb-3 row">
        <label class="col-sm-3 col-form-label">Nom</label>
        <div class="col-sm-9">
            <input class="form-control @error('nom') is-invalid @enderror" type="text" name="nom" value="{{ old("nom") ?? $classe->nom }}" placeholder="Nom classe" />
            @error('nom')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="row">
        <label class="col-sm-3 col-form-label">Description</label>
        <div class="col-sm-9">
            <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="5" cols="5" placeholder="Description filière">{{ old('description') ?? $classe->description }}</textarea>
            @error('description')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
</div>
