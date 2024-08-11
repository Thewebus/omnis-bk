@extends('layouts.personnel.master')

@section('title')Nouvelles notes
 {{ $title }}
@endsection

@push('css')
@endpush

@section('content')
@component('components.breadcrumb')
    @slot('breadcrumb_title')
        <h3>Nouvelles notes</h3>
    @endslot
    <li class="breadcrumb-item">Resultats</li>
    <li class="breadcrumb-item active">Nouvelles notes</li>
@endcomponent

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header pb-0">
                    <h5>Notes étudiant : {{ $etudiant->fullname }}</h5>
                </div>
                <form action="{{ route('admin.insertion-notes', $etudiant->test->id) }}" method="POST" class="form theme-form">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Français</label>
                                    <div class="col-sm-9">
                                        <input class="form-control digits @error('fr') is-invalid @enderror" name="fr" value="{{ old('fr') }}" type="number" @if ($etudiant->test->status) disabled @endif placeholder="Note français" />
                                        @error('fr')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Anglais</label>
                                    <div class="col-sm-9">
                                        <input class="form-control digits @error('ang') is-invalid @enderror" type="number" name="ang" value="{{ old('ang') }}" @if ($etudiant->test->status) disabled @endif placeholder="Note anglais" />
                                        @error('ang')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Mathematique</label>
                                    <div class="col-sm-9">
                                        <input class="form-control digits @error('math') is-invalid @enderror" type="number" value="{{ old('math') }}" name="math" @if ($etudiant->test->status) disabled @endif placeholder="Note mathématique" />
                                        @error('math')
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
                            @if ($etudiant->test->status)
                                <button class="btn btn-primary" disabled type="submit">Valider</button>
                            @else
                                <button class="btn btn-primary" type="submit">Valider</button>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>

        @if ($etudiant->test->status)
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header pb-0">
                    <h5>Résultats {{ $etudiant->fullname }}</h5>
                    <span>lorem ipsum dolor sit amet, consectetur adipisicing elit</span>
                </div>
                <div class="card-body">
                    <p>
                        L'étudiant <strong>{{ $etudiant->fullname }}</strong> a été <strong>{{ $etudiant->test->status }}</strong> avec une moyenne de <strong>{{ round($etudiant->test->moyenne, 2) }}/20</strong>
                    </p>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Vertically centered modal-->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenter" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Décision finale</h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>L'étudiant <strong>{{ $etudiant->fullname }}</strong> a été <strong>{{ $etudiant->test->status }}</strong> avec une moyenne de <strong>{{ round($etudiant->test->moyenne, 2) }}/20</strong></p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    @if (Session('success'))
    <script>
        $(function() {
            $('#exampleModalCenter').modal('show');
        });
    </script>
    @endif
@endpush

@endsection
