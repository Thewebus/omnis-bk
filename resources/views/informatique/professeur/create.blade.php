@extends('layouts.informatique.master')

@section('title')Nouveau professeur
 {{ $title }}
@endsection

@push('css')
@endpush


@section('content')
    @component('components.breadcrumb')
		@slot('breadcrumb_title')
			<h3>Nouveau professeur</h3>
		@endslot
        <li class="breadcrumb-item"><a href="{{ route('admin.professeurs.index') }}">Professeurs</a> </li>
		{{-- <li class="breadcrumb-item">Data Tables</li> --}}
		<li class="breadcrumb-item active">Nouveau professeur</li>
	@endcomponent
    <div class="card">
        <div class="card-header pb-0">
            <h5>Entrez les informations</h5>
        </div>
        <form class="form theme-form" action="{{ route('admin.professeurs.store') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Nom & prénoms</label>
                            <div class="col-sm-9">
                                <input class="form-control @error('fullname') is-invalid @enderror" type="text" name="fullname" value="{{ old("fullname") }}" placeholder="Entrez le nom & prénoms" />
                                @error('fullname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Email</label>
                            <div class="col-sm-9">
                                <input class="form-control @error('email') is-invalid @enderror" type="email" name="email" value="{{ old('email') }}" placeholder="Entrez l'email" />
                                @error('email')
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

@push('scripts')
@endpush
@endsection

