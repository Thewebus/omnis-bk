@extends('layouts.auth.master')

@section('title')
    Connexion
    {{ $title }}
@endsection

@push('css')
@endpush

@section('content')
    <section>
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-7 order-1"><img class="bg-img-cover bg-center"
                        src="{{ asset('assets/images/login/1-1.jpg') }}" alt="looginpage" /></div>
                <div class="col-xl-5 p-0">
                    <div class="login-card">
                        <form method="POST" action="{{ route('login-parent') }}" class="theme-form login-form needs-validation">
                            @csrf
                            <h4>Connexion</h4>
                            <h6>Connectez vous au compte de vote enfant</h6>
                            <div class="form-group">
                                <label>Matricule</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="icon-email"></i></span>
                                    <input class="form-control @error('matricule') is-invalid @enderror" name="matricule"
                                        type="text" value="{{ old('matricule') }}"
                                        placeholder="Entrez le matricule de votre enfant" />
                                    @error('matricule')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="checkbox">
                                    <input id="remember" type="checkbox" name="remember" id="remember"
                                        {{ old('remember') ? 'checked' : '' }} />
                                    <label class="text-muted" for="remember">Se rappeler de moi</label>
                                </div>
                                {{-- <a class="link" href="{{ route('forget-password') }}">Forgot password?</a> --}}
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary btn-block" type="submit"><span style="background-color:blue">Connexion</span></button>
                            </div>
                            <p>Vous êtes étudiant ? <a class="ms-2" href="{{ route('login') }}">Connectez vous</a></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        (function() {
            "use strict";
            window.addEventListener(
                "load",
                function() {
                    // Fetch all the forms we want to apply custom Bootstrap validation styles to
                    var forms = document.getElementsByClassName("needs-validation");
                    // Loop over them and prevent submission
                    var validation = Array.prototype.filter.call(forms, function(form) {
                        form.addEventListener(
                            "submit",
                            function(event) {
                                if (form.checkValidity() === false) {
                                    event.preventDefault();
                                    event.stopPropagation();
                                }
                                form.classList.add("was-validated");
                            },
                            false
                        );
                    });
                },
                false
            );
        })();
    </script>


    @push('scripts')
    @endpush
@endsection
