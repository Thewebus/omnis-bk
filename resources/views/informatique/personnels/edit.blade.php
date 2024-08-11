@extends('layouts.informatique.master')

@section('title')Modifiaction Service
 {{ $title }}
@endsection

@push('css')
@endpush

@section('content')
@component('components.breadcrumb')
    @slot('breadcrumb_title')
        <h3>Modifiaction Personnel</h3>
    @endslot
    <li class="breadcrumb-item"><a href="{{ route('admin.personnels.index') }}">Personnel</a></li>
    <li class="breadcrumb-item active">Modifiaction Personnel</li>
@endcomponent

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header pb-0">
                    <h5>Modification Personnel</h5>
                </div>
                <form action="{{ route('admin.personnels.update', $personnel->id) }}" method="POST" class="form theme-form">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Nom & Prénoms</label>
                                    <div class="col-sm-9">
                                        <input class="form-control @error('nom_prenoms') is-invalid @enderror" name="nom_prenoms" value="{{ old('nom_prenoms') ?? $personnel->fullname }}" type="text" placeholder="Nom & prenoms" />
                                        @error('nom_prenoms')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Numéro</label>
                                    <div class="col-sm-9">
                                        <input class="form-control @error('numero') is-invalid @enderror" name="numero" value="{{ old('numero') ?? $personnel->numero }}" type="number" placeholder="numero " />
                                        @error('numero')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Email</label>
                                    <div class="col-sm-9">
                                        <input class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') ?? $personnel->email }}" type="email" placeholder="email " />
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Service</label>
                                    <div class="col-sm-9">
                                        <select class="form-select digits @error('service') is-invalid @enderror" name="service">
                                                <option value="">Choisir le service</option>
                                                @foreach ($services as $service)
                                                    <option value="{{ $service->id }}" {{ $personnel->service_id == $service->id ? 'selected' : '' }}>{{ $service->nom }}</option>
                                                @endforeach
                                        </select>
                                        @error('service')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Role</label>
                                    <div class="col-sm-9">
                                        <select class="form-select digits @error('role') is-invalid @enderror" name="role">
                                                <option value="">Choisir le rôle</option>
                                                <option value="comptable" {{ $personnel->type == 'comptable' ? 'selected' : '' }}>COMPTABLE</option>
                                                <option value="informaticien" {{ $personnel->type == 'informaticien' ? 'selected' : '' }}>INFORMATIQUE</option>
                                                <option value="scolarite" {{ $personnel->type == 'scolarite' ? 'selected' : '' }}>SCOLARITE</option>
                                        </select>
                                        @error('role')
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
                            <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i> Modifier</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection