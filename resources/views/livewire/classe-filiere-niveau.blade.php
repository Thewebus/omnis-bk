<div class="col">
    <div class="mb-3 row">
        <label class="col-sm-3 col-form-label">faculte</label>
        <div class="col-sm-9">
            <select class="form-select digits @error('faculte') is-invalid @enderror" id="faculte" name="faculte" wire:model="faculte">
                @isset($classe)
                    <option selected value="{{ $classe->niveauFaculte->faculte->id }}">{{ $classe->niveauFaculte->faculte->nom }}</option>
                @else
                    <option selected value="">Choisir une faculte</option>
                @endisset
                @foreach ($facultes as $faculte)
                <option value="{{ $faculte->id }}" {{ old('faculte') == $faculte->id ? 'selected' : '' }}>{{ $faculte->nom }}</option>
                @endforeach
            </select>
            @error('faculte')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="mb-3 row">
        <label class="col-sm-3 col-form-label">Niveau faculte</label>
        <div class="col-sm-9">
            <select class="form-select digits @error('niveau') is-invalid @enderror" id="niveau" name="niveau" >
                @isset($classe)
                    <option selected value="{{ $classe->niveauFaculte->id }}">{{ $classe->niveauFaculte->nom }}</option>
                @else
                    <option selected value="">Choisir une faculte</option>
                @endisset                
                @if (!is_null($faculte))
                    @foreach ($niveaux as $niveau)
                        <option value="{{ $niveau->id }}" {{ old('niveau') == $niveau->id ? 'selected' : '' }}>{{ $niveau->nom }}</option>
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
            <input class="form-control @error('nom') is-invalid @enderror" type="text" name="nom" value="{{ old("nom") ?? ($classe ? $classe->nom : '') }}" placeholder="Nom classe" />
            @error('nom')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="mb-3 row">
        <label class="col-sm-3 col-form-label">Code</label>
        <div class="col-sm-9">
            <input class="form-control @error('code') is-invalid @enderror" type="text" name="code" value="{{ old("code") ?? ($classe ? $classe->code : '') }}" placeholder="Code classe" />
            @error('code')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="row">
        <label class="col-sm-3 col-form-label">Description</label>
        <div class="col-sm-9">
            <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="5" cols="5" placeholder="Description faculte">{{ old('description') ?? ($classe ? $classe->description : '') }}</textarea>
            @error('description')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
</div>
