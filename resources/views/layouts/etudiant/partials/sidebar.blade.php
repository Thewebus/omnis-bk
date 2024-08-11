<header class="main-nav">
    <div class="sidebar-user text-center">
        <a class="setting-primary" href="javascript:void(0)"><i data-feather="settings"></i></a><img class="img-90 rounded-circle" src="{{asset('assets/images/dashboard/1.png')}}" alt="" />
        <div class="badge-bottom"><span class="badge badge-primary">Etudiant</span></div>
        <a href="{{ route('user.profile') }}"> <h6 class="mt-3 f-14 f-w-600">{{ Auth::user()->fullname }}</h6></a>
        <p class="mb-0 font-roboto">{{ Auth::user()->classe(1)->nom ?? __('Non inscrit') }}</p>
        {{-- <ul>
            <li>
                <span><span class="counter">19.8</span>k</span>
                <p>Follow</p>
            </li>
            <li>
                <span>2 year</span>
                <p>Experince</p>
            </li>
            <li>
                <span><span class="counter">95.2</span>k</span>
                <p>Follower</p>
            </li>
        </ul> --}}
    </div>
    <nav>
        <div class="main-navbar">
            <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
            <div id="mainnav">
                <ul class="nav-menu custom-scrollbar">
                    <li class="back-btn">
                        <div class="mobile-back text-end"><span>Back</span><i class="fa fa-angle-right ps-2" aria-hidden="true"></i></div>
                    </li>
                    <li class="sidebar-main-title">
                        <div>
                            <h6>Général</h6>
                        </div>
                    </li>
                    <li>
                        <a class="nav-link menu-title link-nav {{routeActive('user.dashboard-etudiant')}}" href="{{ route('user.dashboard-etudiant') }}"><i data-feather="database"></i><span>Tableau de bord</span></a>
                    </li>
                    @if (Auth::user()->classe(1))
                        <li class="sidebar-main-title">
                            <div>
                                <h6>Fiche d'Inscription</h6>
                            </div>
                        </li>
                        <li class="dropdown">
                            <a class="nav-link menu-title link-nav {{routeActive('user.fiche-inscription')}}" href="{{ route('user.fiche-inscription') }}"><i data-feather="database"></i><span>Fiche Inscription</span></a>
                        </li>
                    @else
                        <li class="sidebar-main-title">
                            <div>
                                <h6>Inscription</h6>
                            </div>
                        </li>
                        <li class="dropdown">
                            <a class="nav-link menu-title link-nav {{routeActive('user.inscription')}}" href="{{ route('user.inscription') }}"><i data-feather="database"></i><span>Formulaire d'Inscription</span></a>
                        </li>
                    @endif
                    {{-- <li class="sidebar-main-title">
                        <div>
                            <h6>Inscription old</h6>
                        </div>
                    </li>
                    <li>
                        <a class="nav-link menu-title link-nav {{routeActive('user.inscription-old')}}" href="{{ route('user.inscription-old') }}"><i data-feather="database"></i><span>Inscription</span></a>
                    </li> --}}
                    @if (!is_null(Auth::user()->classe(1)))
                        <li class="sidebar-main-title">
                            <div>
                                <h6>Ressources</h6>
                            </div>
                        </li>
                        <li>
                            <a class="nav-link menu-title link-nav {{routeActive('user.ressource-index')}}" href="{{ route('user.ressource-index') }}"><i data-feather="database"></i><span>Ressources</span></a>
                        </li>
                        @if (Auth::user()->notes->first()->show_note)
                            <li class="sidebar-main-title">
                                <div>
                                    <h6>Notes</h6>
                                </div>
                            </li>
                            <li>
                                <a class="nav-link menu-title link-nav {{routeActive('user.liste-matiere')}}" href="{{ route('user.liste-matiere') }}"><i data-feather="database"></i><span>Notes</span></a>
                            </li>
                        @endif
                        <li class="sidebar-main-title">
                            <div>
                                <h6>Echéancier</h6>
                            </div>
                        </li>
                        <li>
                            <a class="nav-link menu-title link-nav {{routeActive('user.echeancier.index')}}" href="{{ route('user.echeancier.index') }}"><i data-feather="database"></i><span>Echeancier</span></a>
                        </li>

                        {{-- <li class="dropdown">
                            <a class="nav-link menu-title link-nav {{routeActive('user.dashboard-etudiant')}}" style="display: {{ prefixBlock('/etudiant') }};" href="{{ route('user.dashboard-etudiant') }}"><i data-feather="monitor"></i><span>Echéancier</span></a>
                        </li> --}}
                        <li class="sidebar-main-title">
                            <div>
                                <h6>Scolarité</h6>
                            </div>
                        </li>
                        <li>
                            <a class="nav-link menu-title link-nav {{ routeActive('user.scolarite') }}" href="{{ route('user.scolarite') }}"><i data-feather="database"></i><span>Paiement scolarité</span></a>
                        </li>
                        <li class="sidebar-main-title">
                            <div>
                                <h6>Emploi du temps</h6>
                            </div>
                        </li>
                        <li>
                            <a class="nav-link menu-title link-nav {{ routeActive('user.schedule') }}" href="{{ route('user.schedule') }}"><i data-feather="database"></i><span>Emploi du temps</span></a>
                        </li>
                        {{-- <li class="sidebar-main-title">
                            <div>
                                <h6>Reclamations</h6>
                            </div>
                        </li>
                        <li>
                            <a class="nav-link menu-title link-nav {{ routeActive('user.reclamations.index') }}" href="{{ route('user.reclamations.index') }}"><i data-feather="database"></i><span>Reclamations</span></a>
                        </li> --}}
                        <li>
                            <a class="nav-link menu-title link-nav {{ routeActive('user.reclamations.create') }}" href="{{ route('user.reclamations.create') }}"><i data-feather="database"></i><span>Nouvelles Reclamations</span></a>
                        </li>
                        <li class="sidebar-main-title">
                            <div>
                                <h6>Chat App</h6>
                            </div>
                        </li>
                        <li>
                            <a class="nav-link menu-title link-nav {{routeActive('user.chat-app')}}" href="{{ route('user.chat-app') }}"><i data-feather="message-square"></i><span>Chap</span></a>
                        </li>
                    @endif
                </ul>
            </div>
            <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
        </div>
    </nav>
</header>
