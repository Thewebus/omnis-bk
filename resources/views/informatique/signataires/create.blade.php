@extends('layouts.informatique.master')

@section('title')Nouveau Signataire
 {{ $title }}
@endsection

@push('css')
@endpush

@section('content')
@component('components.breadcrumb')
    @slot('breadcrumb_title')
        <h3>Nouveau Signataire</h3>
    @endslot
    <li class="breadcrumb-item"><a href="{{ route('admin.services.index') }}">Signataire</a></li>
    <li class="breadcrumb-item active">Nouveau Signataire</li>
@endcomponent

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header pb-0">
                    <h5>Nouveau Signataire</h5>
                </div>
                <form action="{{ route('admin.signataires.store') }}" method="POST" class="form theme-form">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Nom & Prenoms</label>
                                    <div class="col-sm-9">
                                        <input class="form-control @error('fullname') is-invalid @enderror" name="fullname" value="{{ old('fullname') }}" type="text" placeholder="Nom & Prenoms" />
                                        @error('fullname')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Fonction</label>
                                    <div class="col-sm-9">
                                        <input class="form-control @error('fonction') is-invalid @enderror" name="fonction" value="{{ old('fonction') }}" type="text" placeholder="Fonction" />
                                        @error('fonction')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Signataire</label>
                                    <div class="col-sm-9">
                                        <div class="media">
                                            {{-- <label class="col-form-label m-r-10">Primary Color</label> --}}
                                            <div class="media-body icon-state switch-outline">
                                                <label class="switch">
                                                    <input type="checkbox" name="signataire"><span class="switch-state bg-primary"></span>
                                                </label>
                                            </div>
                                        </div>
                                        @error('signataire')
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
                            <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i> Valider</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="{{ asset('assets/js/bootstrap/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap/bootstrap.min.js') }}"></script>
@endpush

@endsection