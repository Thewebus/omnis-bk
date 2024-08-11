@extends('layouts.auth.master')

@section('title')Inscription
 {{ $title }}
@endsection

@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/sweetalert2.css') }}">
@endpush

@section('content')
    <section>
	    <div class="container-fluid p-0">
	        <div class="row m-0">
	            <div class="col-xl-5">
                    <img class="bg-img-cover bg-center" src="{{ asset('assets/images/login/4.jpg') }}" alt="looginpage" />
                </div>
	            <div class="col-xl-7 p-0">
	                <div class="login-card">
	                    <form class="theme-form login-form" method="POST" action="{{ route('register') }}">
	                        @csrf
                            <h4>Créez votre compte</h4>
	                        <h6>Remplissez le formulaire pour créer votre compte</h6>
	                        <div class="form-group">
	                            <label>Nom & Prénoms</label>
	                            <div class="input-group">
	                                <span class="input-group-text"><i class="icon-user"></i></span>
	                                <input required class="form-control @error('nom_complet') is-invalid @enderror" name="nom_complet" value="{{ old('nom_complet') }}" type="text" placeholder="Nom complet" />
                                    @error('nom_complet')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
	                        </div>
                            <div class="form-group">
	                            <label>Email Address</label>
	                            <div class="input-group">
	                                <span class="input-group-text"><i class="icon-email"></i></span>
	                                <input required class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" type="email" placeholder="Test@gmail.com" />
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
	                        </div>
							<div class="form-group">
	                            <label>Numéro de téléphone</label>
	                            <div class="input-group">
	                                <span class="input-group-text"><i class="icofont icofont-phone"></i></span>
	                                <input required class="form-control @error('numero') is-invalid @enderror" name="numero" value="{{ old('numero') }}" type="number" placeholder="Numéro de téléphone" />
                                    @error('numero')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
	                        </div>
	                        <div class="form-group">
	                            <label>Mot de passe</label>
	                            <div class="input-group">
	                                <span class="input-group-text"><i class="icon-lock"></i></span>
	                                <input required class="form-control @error('password') is-invalid @enderror" type="password" name="password" placeholder="*********" />
	                                <div class="show-hide"><span class="show"> </span></div>
	                                @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
	                        </div>
                            <div class="form-group">
	                            <label>Confirmation Mot de passe</label>
	                            <div class="input-group">
	                                <span class="input-group-text"><i class="icon-lock"></i></span>
	                                <input required class="form-control" type="password" name="password_confirmation" placeholder="*********" />
	                                <div class="show-hide"><span class="show"> </span></div>
                                </div>
	                        </div>
	                        <div class="form-group">
	                            <button class="btn btn-primary btn-block" type="submit"><span style="background-color:blue">S'enregistrer</span> </button>
	                        </div>
	                        {{-- <p>Already have an account?<a class="ms-2" href="{{ route('login') }}">Sign in</a></p> --}}
	                    </form>
	                </div>
	            </div>
	        </div>
	    </div>
	</section>


    @push('scripts')
    <script src="{{ asset('assets/js/sweet-alert/sweetalert.min.js') }}"></script>
    @endpush

@endsection
