@extends('layouts.etudiant.master')

@section('title')Resultat Test
 {{ ($title) }}
@endsection

@push('css')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/sweetalert2.css')}}">
@endpush

@section('content')
@component('components.etudiant.breadcrumb')
    @slot('breadcrumb_title')
        <h3>Resultat Test</h3>
    @endslot
    <li class="breadcrumb-item active">Résultat test</li>
    {{-- <li class="breadcrumb-item active">Sample Page</li> --}}
@endcomponent

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header pb-0">
                    <h5>Resultats de test</h5>
                    <span>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Atque beatae quod eius repudiandae fuga dolore modi!</span>
                </div>
                <div class="card-body">
                    <p>
                        @isset(Auth::user()->test->status)
                            Vous avez obtenu les notes suivantes dans les différentes matières : <br>
                            Mathématique : <strong>{{ Auth::user()->test->note_math }}/20</strong><br>
                            Anglais : <strong>{{ Auth::user()->test->note_ang }}/20</strong><br>
                            Français : <strong>{{ Auth::user()->test->note_fr }}/20</strong><br>
                            Moyenne : <strong>{{ round(Auth::user()->test->moyenne, 2) }}/20</strong><br>
                            Décision finale : <strong>{{ Auth::user()->test->status }}</strong><br>
                            @if (Auth::user()->test->status == "admis")
                            <div class="alert alert-warning dark alert-dismissible fade show" role="alert">
                                <i data-feather="bell"></i>
                                <p>Veuillez vous rendre dans la partie <b>"Inscription"</b>  puis remplissez le formulaire.</p>
                                <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            @endif
                        @else
                            <div class="alert alert-warning dark alert-dismissible fade show" role="alert">
                                <i data-feather="bell"></i>
                                <p>Vos résultats ne sont pas encore disponible.</p>
                                <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endisset
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

@isset(Auth::user()->dateCompo->date_compo)
    <!-- Vertically centered modal-->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenter" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Informations validées</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Votre inscription a été validée et votre date de composition à été fixé au {{ Auth::user()->dateCompo->date_compo }}. </p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endisset

@push('scripts')
    <script src="{{asset('assets/js/sweet-alert/sweetalert.min.js')}}"></script>
    <script src="{{asset('assets/js/sweet-alert/app.js')}}"></script>
    @if (Session('success'))
        <script>
            $(function() {
                $('#exampleModalCenter').modal('show');
            });
        </script>
    @endif
@endpush

@endsection
