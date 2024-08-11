@extends('layouts.auth.master')

@section('title')login
 {{ $title }}
@endsection

@push('css')
@endpush

@section('content')
    <section>
        <style>
            .bgc {
                background-image: url("{{ asset('assets/images/bg/bgc.jpg') }}");
                background-size: cover;
                background-position: center;
                background-repeat: no-repeat;
                width: 100%;
                height: 100%;
            }

            @media (max-width: 768px) {
                .bgc {
                    background-image: url("{{ asset('assets/images/bg/bgc.jpg') }}");
                }
            }
        </style>
    <div class="container-fluid p-0">
        <div class="row">
            <div class="col-12">
                <div class="login-card bgc">
                    <form class="theme-form login-form" action="{{ route('prof.signin-post') }}" method="POST">
                        @csrf
                        <h4>Connexion</h4>
                        <h6>Connectez-vous a votre compte</h6>
                        <div class="form-group">
                            <label>Adresse Email</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="icon-email"></i></span>
                                <input class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" type="email" placeholder="Test@gmail.com" />
                                @error('email')
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
                                <input class="form-control @error('password') is-invalid @enderror" type="password" value="{{ old('pasword') }}" name="password" placeholder="*********" />
                                <div class="show-hide"><span class="show"></span></div>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="checkbox">
                                <input id="checkbox1" type="checkbox" />
                                <label for="checkbox1">Remember password</label>
                            </div>
                            <a class="link" href="#">Forgot password?</a>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary btn-block" type="submit">Connexion</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
@endpush

@endsection
