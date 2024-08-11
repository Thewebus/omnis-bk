@extends('layouts.professeur.master')

@section('title')Liste présence
 {{ $title }}
@endsection

@push('css')
@endpush

@section('content')
@component('components.professeur.breadcrumb')
    @slot('breadcrumb_title')
    <h3>Liste de présence {{ $matiere->classe->nom }}</h3>
    @endslot
    <li class="breadcrumb-item">Présence</li>
    <li class="breadcrumb-item active">Liste présence</li>
@endcomponent

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header pb-0">
                    <h5>Liste de présence : {{ $matiere->nom }} | {{ $matiere->classe->nom }}</h5>
                    {{-- <span>lorem ipsum dolor sit amet, consectetur adipisicing elit</span> --}}
                </div>
                <div class="card-body">
                    <form action="{{ route('prof.poste-liste-presence', $matiere->id) }}" method="POST">
                        @csrf
                        <div class="col offset-4">
                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label">Durée du cours (Heure)</label>
                                <div class="col-sm-9">
                                    <input class="form-control @error('duree_cours') is-invalid @enderror" type="number" name="duree_cours" value="{{ old("duree_cours") }}" placeholder="Durée du cours" />
                                    @error('duree_cours')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        @foreach ($etudiants as $etudiant)
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <div class="row">
                                        <div class="col-1">
                                            {{ $loop->iteration }}
                                        </div>
                                        <div class="col-6">
                                            <input class="form-control" type="text" disabled value="{{ $etudiant->fullname }}">
                                            <input type="hidden" name="matiere_id" value="{{ $matiere->id }}">
                                        </div>
                                        <div class="col-5">
                                            <div class="form-group m-t-10 m-checkbox-inline mb-0 custom-radio-ml">
                                                <div class="radio radio-primary">
                                                    <input id="present{{ $etudiant->id }}" type="radio" name="{{ $etudiant->id }}" value="1">
                                                    <label class="mb-0" for="present{{ $etudiant->id }}">Présent</label>
                                                </div>
                                                <div class="radio radio-primary">
                                                    <input id="absent{{ $etudiant->id }}" type="radio" checked name="{{ $etudiant->id }}" value="0">
                                                    <label class="mb-0" for="absent{{ $etudiant->id }}">Absent</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        @endforeach

                        <button class="btn btn-light m-t-15 float-right" type="submit">Valider</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


  @push('scripts')
  @endpush

@endsection
