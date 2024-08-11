@extends('layouts.comingsoon.master')

@section('title')
    UA {{ $title }}
@endsection

@push('css')
@endpush

@section('content')
    {{-- start by fk-dev --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
    {{--  by fk-dev end --}}

    <!-- Loader starts-->
    <div class="loader-wrapper">
        <div class="theme-loader">
            <div class="loader-p"></div>
        </div>
    </div>
    <!-- Loader ends-->
    <!-- page-wrapper Start-->
    <div class="page-wrapper" id="pageWrapper">
        <!-- Page Body Start-->
        <div class="container-fluid p-0">
            <style>
                @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap');

                body {
                    font-family: "Poppins", sans-serif;
                    line-height: 1.7;
                    color: #6a6a6a;
                }

                h1,
                h2,
                h3,
                h4,
                h5,
                h6 {
                    font-weight: 700;
                    color: #323232;
                }

                a {
                    color: #323232;
                    text-decoration: none;
                    transition: all 0.4s ease;
                    font-weight: 500;
                }

                a:hover {
                    color: #0000ff;
                }

                .link::before {
                    content: "";
                    width: 10px;
                    height: 2px;
                    background-color: #0000ff;
                    display: inline-block;
                    vertical-align: middle;
                    margin-right: 10px;
                    transition: all 0.4s ease;
                }

                .link:hover::before {
                    width: 20px;
                }

                img {
                    width: 100%;
                }

                section {
                    padding: 120px 0;
                }

                /* HERO  */
                #hero {
                    background: linear-gradient(rgba(0, 0, 0, 0.1), rgba(0, 0, 0, 0.1)), url("{{ asset('assets/images/bg/bg_1-2.jpg') }}");
                    background-position: right;
                    background-size: cover;
                }


                /* BTN */
                .btn {
                    font-weight: 500;
                    padding: 10px 30px;
                    border-radius: 4;
                    transition: all 0.2s ease;
                }


                .btn-primary {
                    background-color: #0000ff;
                    border-color: #0000ff;
                }

                .btn-primary:hover {
                    background-color: #F58A47;
                    border-color: #F58A47;
                    transform: scale(1.1);
                }

                .btext {
                    background-color: #0000ff;
                    padding: 1px 20px;
                    color: white;
                }

                .btext1 {
                    font-size: 30px;
                    background-color: white;
                    color: blue;
                    padding: 1px 20px;
                    bottom: 80px;
                }
            </style>
            <!-- NAVBAR -->
            <nav class="navbar navbar-expand-lg navbar-light bg-white py-3">
                <div class="container">
                    <a class="navbar-brand" href="https://www.uatlantique.org">
                        {{-- <img src="{{ asset('assets/images/logo/logo-1.png') }}" alt=""> --}}
                        <img class="img-90 rounded-circle" src="{{ asset(env('LOGO_PATH')) }}" alt="">
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        {{-- <ul class="navbar-nav mx-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="https://www.uatlantique.org">ACCUEIL</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="https://www.uatlantique.org/faculte/">FORMATION</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="https://www.uatlantique.org/inovation/">INNOVATION</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#portfolio"></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="https://www.uatlantique.org/about/"> QUI SOMMES-NOUS ?</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="https://www.uatlantique.org/tchunissini/">TCHUNISSINI</a>
                            </li>
                        </ul> --}}
                        {{-- <a href="https://www.uatlantique.org/institut-de-formation-des-professionnels-de-la-sante-ifps/" class="btn btn-primary">FILIERE SANTE</a> --}}
                    </div>
                </div>
            </nav>
            <!-- //NAVBAR -->

            <!-- HERO -->
            <div id="hero" class="min-vh-100 d-flex align-items-center text-center">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-10 text-white">
                            <h1 class="display-4 text-black fw-bold "> <strong class="btext">BIENVENUE </strong><br>
                                <span class="btext1">Espace reservé aux étudiants</span>
                            </h1>
                            <p class="lead mt-3 mb-4 mx-auto" style="max-width: 600px; color: rgb(1, 1, 1);"></p>
                            <button class="btn btn-primary btn-block mt-3" type="button" data-bs-toggle="modal"
                                data-bs-target="#exampleModalCenter" style="background-color:#0000ff">Connexion</button>
                            <!-- Vertically centered modal-->
                            <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalCenter" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Connexion</h5>
                                            <button class="btn-close" type="button" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Connectez vous selon votre profil</p>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <a href="{{ route('login') }}"
                                                        class="btn btn-outline-secondary btn-block">Etudiant</a>
                                                </div>
                                                <div class="col-md-4">
                                                    <a href="{{ route('prof.login') }}"
                                                        class="btn btn-outline-primary btn-block">Professeur</a>
                                                </div>
                                                <div class="col-md-4">
                                                    <a href="{{ route('admin.login') }}"
                                                        class="btn btn-outline-warning btn-block">Personnel</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-secondary" type="button"
                                                data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('assets/js/countdown.js') }}"></script>
        <script src="{{ asset('assets/js/tooltip-init.js') }}"></script>
    @endpush

    {{-- Start by fk-dev --}}
    <script src="https://unpkg.com/ionicons@5.4.0/dist/ionicons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

    <script>
        $('#projects-carousel').owlCarousel({
            loop: true,
            margin: 24,
            dots: false,
            nav: false,
            smartSpeed: 1000,
            autoplay: true,
            autoplayTimeout: 5000,
            autoplayHoverPause: true,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 2
                },
                1000: {
                    items: 3
                }
            }
        });


        // REVIEWS
        $('#reviews-carousel').owlCarousel({
            loop: true,
            margin: 24,
            nav: false,
            smartSpeed: 1000,
            autoplay: true,
            autoplayTimeout: 5000,
            autoplayHoverPause: true,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 2
                },
                1000: {
                    items: 2
                }
            }
        });
    </script>
    {{-- Start by fk-dev --}}
@endsection
