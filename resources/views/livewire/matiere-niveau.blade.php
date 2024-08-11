<div class="col">
    <div class="mb-3 row">
        <label class="col-sm-3 col-form-label">Faculté</label>
        <div class="col-sm-9">
            <select class="form-select digits @error('faculte') is-invalid @enderror" id="faculte" name="faculte" wire:model="faculte">
                @isset($matiere)
                    <option selected value="{{ $matiere->niveauFaculte->faculte->id }}">{{ $matiere->niveauFaculte->faculte->nom }}</option>
                @else
                    <option selected value="">Choisir une Faculté</option>
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
        <label class="col-sm-3 col-form-label">Niveau Faculté</label>
        <div class="col-sm-9">
            <select class="form-select digits @error('niveau') is-invalid @enderror" id="niveau" name="niveau" >
                @isset($matiere)
                    <option selected value="{{ $matiere->niveauFaculte->id }}">{{ $matiere->niveauFaculte->nom }}</option>
                @else
                    <option selected value="">Choisir un niveau</option>
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
            <input class="form-control @error('nom') is-invalid @enderror" type="text" name="nom" value="{{ old("nom") ?? ($matiere ? $matiere->nom : '') }}" placeholder="Nom matière" />
            @error('nom')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="mb-3 row">
        <label class="col-sm-3 col-form-label">Type matière</label>
        <div class="col-sm-9">
            <select class="form-select digits @error('type') is-invalid @enderror" id="type" name="type">
                <option value="">Choisir le type de la matière</option>
                <option {{ (old("type") ?? ($matiere ? $matiere->type : '')) == 'generale' ? 'selected' : '' }} value="generale">Matière Générale</option>
                <option {{ (old("type") ?? ($matiere ? $matiere->type : '')) == 'professionnelle' ? 'selected' : '' }} value="professionnelle">Matière Professionnelle</option>
            </select>
            @error('type')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="mb-3 row">
        <label class="col-sm-3 col-form-label">Système</label>
        <div class="col-sm-9">
            <select class="form-select digits @error('systeme') is-invalid @enderror" id="systeme" name="systeme">
                <option value="">Choisir le système de la matière</option>
                <option {{ (old("systeme") ?? ($matiere ? $matiere->systeme : '')) == 'bts' ? 'selected' : '' }} value="bts">BTS</option>
                <option {{ (old("systeme") ?? ($matiere ? $matiere->systeme : '')) == 'licence' ? 'selected' : '' }} value="licence">LICENCE</option>
                <option {{ (old("systeme") ?? ($matiere ? $matiere->systeme : '')) == 'master' ? 'selected' : '' }} value="master">MASTER</option>
            </select>
            @error('systeme')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="mb-3 row">
        <label class="col-sm-3 col-form-label">Coefficient</label>
        <div class="col-sm-9">
            <input class="form-control @error('coefficient') is-invalid @enderror" type="number" name="coefficient" value="{{ old("coefficient") ?? ($matiere ? $matiere->coefficient : '') }}" placeholder="Coefficient matière" />
            @error('coefficient')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="mb-3 row">
        <label class="col-sm-3 col-form-label">Volume Horaire (heure)</label>
        <div class="col-sm-9">
            <input class="form-control @error('volume_horaire') is-invalid @enderror" type="number" name="volume_horaire" value="{{ old("volume_horaire") ?? ($matiere ? $matiere->volume_horaire : '') }}" placeholder="Volume horaire" />
            @error('volume_horaire')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="row">
        <label class="col-sm-3 col-form-label">Description</label>
        <div class="col-sm-9">
            <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="5" cols="5" placeholder="Description matière">{{ old('description') ?? ($matiere ? $matiere->description : '') }}</textarea>
            @error('description')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
</div>