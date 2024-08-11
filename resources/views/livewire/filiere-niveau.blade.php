<div class="row g-3">
    <div class="col-md-4">
        <label class="form-label" for="faculte">Faculté souhaitée <span style="color: red">*</span></label>
        <select class="form-select @error('faculte') is-invalid @enderror" id="faculte" name="faculte" wire:model="faculte">
            <option selected="" value="">Choisir...</option>
            @foreach ($facultes as $faculte)
                <option value="{{ $faculte->id }}" {{ old('faculte') == $faculte->id ? 'selected' : '' }}>{{ $faculte->nom }}</option>
            @endforeach
        </select>
        @error('faculte')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-4">
        <label class="form-label" for="niveau">Niveau Faculté <span style="color: red">*</span></label>
        <select class="form-select @error('niveau') is-invalid @enderror" id="niveau" name="niveau">
            <option selected="" value="">Choisir...</option>
            @if (!is_null($faculte))
                @foreach ($niveaux as $niveau)
                    <option value="{{ $niveau->id }}" {{ old('niveau') == $niveau->id ? 'selected' : '' }}>{{ strtoupper($niveau->nom) }}</option>
                @endforeach
            @endif
        </select>
        @error('niveau')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label" for="faculte">Cursus <span style="color: red">*</span></label>
        <div class="form-group m-t-10 m-checkbox-inline mb-0 custom-radio-ml">
            <div class="radio radio-primary">
                <input class="radio_animated" @isset(Auth::user()->parent) disabled @endisset id="jour" type="radio" name="cursus" value="jour" checked>
                <label class="mb-0" for="jour">Jour</label>
            </div>
            <div class="radio radio-primary">
                <input class="radio_animated" @isset(Auth::user()->parent) disabled @endisset id="soir" type="radio" name="cursus" value="soir">
                <label class="mb-0" for="soir">Soir</label>
            </div>
        </div>
    </div>
</div>
