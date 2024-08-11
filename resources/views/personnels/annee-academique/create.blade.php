@extends('layouts.personnel.master')

@section('title')Nouvelle Année academique
 {{ $title }}
@endsection

@push('css')
@endpush

@section('content')
@component('components.breadcrumb')
    @slot('breadcrumb_title')
        <h3>Nouvelles Année Académique</h3>
    @endslot
    <li class="breadcrumb-item">Accueil</li>
    <li class="breadcrumb-item active">Nouvelles Année Académique</li>
@endcomponent

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header pb-0">
                    <h5>Nouvelle année académique</h5>
                </div>
                <form action="{{ route('admin.annee-academique.store') }}" method="POST" class="form theme-form">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Début</label>
                                    <div class="col-sm-9">
                                        <input class="form-control digits @error('debut') is-invalid @enderror" name="debut" value="{{ old('debut') }}" type="number" placeholder="Début" />
                                        @error('debut')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Fin</label>
                                    <div class="col-sm-9">
                                        <input class="form-control digits @error('fin') is-invalid @enderror" type="number" name="fin" value="{{ old('fin') }}" placeholder="Fin" />
                                        @error('fin')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <div class="col-sm-9 offset-sm-3">
                            <button class="btn btn-primary" type="submit">Valider</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection