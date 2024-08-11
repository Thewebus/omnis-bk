<header class="main-nav">
    <div class="sidebar-user text-center">
        <a class="setting-primary" href="javascript:void(0)"><i data-feather="settings"></i></a><img class="img-90 rounded-circle" src="{{asset('assets/images/dashboard/1.png')}}" alt="" />
        <div class="badge-bottom"><span class="badge badge-primary">{{ Auth::user()->type }}</span></div>
        <a href="{{ route('admin.personnel-profil') }}"> <h6 class="mt-3 f-14 f-w-600">{{ Auth::user()->fullname }}</h6></a>
        <p class="mb-0 font-roboto">{{ Auth::user()->type }}</p>
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
                            <h6>Tableau de bord</h6>
                        </div>
                    </li>
                    <li>
                        <a class="nav-link menu-title link-nav {{routeActive('admin.dashboard')}}" href="{{ route('admin.dashboard') }}"><i data-feather="database"></i><span>Tableau de bord</span></a>
                    </li>
                    <li class="sidebar-main-title">
                        <div>
                            <h6>Année courante</h6>
                        </div>
                    </li>
                    <li class="dropdown">
                        <a class="nav-link menu-title" href="javascript:void(0)">
                            <i data-feather="file-text"></i>
                            <span>
                                {{ !getSelectedAnneeAcademique() 
                                    ? (getLastAnneeAcademique()->debut . ' - ' . getLastAnneeAcademique()->fin) 
                                    : (getSelectedAnneeAcademique()->debut . ' - ' . getSelectedAnneeAcademique()->fin) 
                                }}
                            </span>
                        </a>
                        <ul class="nav-submenu menu-content">
                            @foreach ($allAnneeAcademiques as $anneeAcademique)
                                <li><a href="{{ route('admin.set-annee-academique', $anneeAcademique->id) }}" class="{{routeActive('admin.set-annee-academique', $anneeAcademique->id)}}">{{ $anneeAcademique->debut }} - {{ $anneeAcademique->fin }}</a></li>
                            @endforeach
                        </ul>
                    </li>
                    <li class="sidebar-main-title">
                        <div>
                            <h6>Années Academiques</h6>
                        </div>
                    </li>
                    <li class="dropdown">
                        <a class="nav-link menu-title {{ prefixActive('/personnel/annee-academique') }}" href="javascript:void(0)"><i data-feather="file-text"></i><span>Années Académqiues</span></a>
                        <ul class="nav-submenu menu-content"  style="display: {{ prefixBlock('/personnel/annee-academique') }};">
                            <li><a href="{{ route('admin.annee-academique.create') }}" class="{{routeActive('admin.annee-academique.create')}}">Nouveaux</a></li>
                            <li><a href="{{ route('admin.annee-academique.index') }}" class="{{routeActive('admin.annee-academique.index')}}">Années Académiques</a></li>
                        </ul>
                    </li>
                    <li class="sidebar-main-title">
                        <div>
                            <h6>Inscriptions</h6>
                        </div>
                    </li>
                    <li class="dropdown">
                        <a class="nav-link menu-title {{ prefixActive('/scolarite/inscription') }}" href="javascript:void(0)"><i data-feather="file-text"></i><span>Inscriptions</span></a>
                        <ul class="nav-submenu menu-content"  style="display: {{ prefixBlock('/scolarite/inscription') }};">
                            <li><a href="{{ route('admin.scolarite-inscription-etudiant') }}" class="{{routeActive('admin.scolarite-inscription-etudiant')}}">Nouvelles inscriptions</a></li>
                            <li><a href="{{ route('admin.scolarite-inscription-validee-liste-etudiant') }}" class="{{routeActive('admin.scolarite-inscription-validee-liste-etudiant')}}">Inscription validées</a></li>
                        </ul>
                    </li>
                    <li class="sidebar-main-title">
                        <div>
                            <h6>Facultés & Classes & salles</h6> 
                        </div>
                    </li>
                    <li class="dropdown">
                        <a class="nav-link menu-title {{ prefixActive('/informatique/facultes') }}" href="javascript:void(0)"><i data-feather="file-text"></i><span>Facultés</span></a>
                        <ul class="nav-submenu menu-content"  style="display: {{ prefixBlock('/informatique/facultes') }};">
                            <li><a href="{{ route('admin.facultes.index') }}" class="{{routeActive('admin.facultes.index')}}">Liste facultés</a></li>
                            <li><a href="{{ route('admin.facultes.create') }}" class="{{routeActive('admin.facultes.create')}}">Nouvelle faculté</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a class="nav-link menu-title {{ prefixActive('/informaticien/classe') }}" href="javascript:void(0)"><i data-feather="file-text"></i><span>Classe</span></a>
                        <ul class="nav-submenu menu-content"  style="display: {{ prefixBlock('/informaticien/classe') }};">
                            <li><a href="{{ route('admin.classe.index') }}" class="{{routeActive('admin.classe.index')}}">Liste classe</a></li>
                            <li><a href="{{ route('admin.classe.create') }}" class="{{routeActive('admin.classe.create')}}">Nouvelle classe</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a class="nav-link menu-title {{ prefixActive('/informaticien/salle') }}" href="javascript:void(0)"><i data-feather="file-text"></i><span>Salle</span></a>
                        <ul class="nav-submenu menu-content"  style="display: {{ prefixBlock('/informaticien/salle') }};">
                            <li><a href="{{ route('admin.salle.index') }}" class="{{routeActive('admin.salle.index')}}">Liste salle</a></li>
                            <li><a href="{{ route('admin.salle.create') }}" class="{{routeActive('admin.salle.create')}}">Nouvelle salle</a></li>
                        </ul>
                    </li>
                    {{-- <li class="sidebar-main-title">
                        <div>
                            <h6>Resultats</h6>
                        </div>
                    </li>
                    <li class="dropdown">
                        <a class="nav-link menu-title {{ prefixActive('/personnel/resultats') }}" href="javascript:void(0)"><i data-feather="file-text"></i><span>Resultats</span></a>
                        <ul class="nav-submenu menu-content"  style="display: {{ prefixBlock('/personnel/resultats') }};">
                            <li><a href="{{ route('admin.nouveaux-resultats') }}" class="{{routeActive('admin.nouveaux-resultats')}}">Nouveaux resultats</a></li>
                            <li><a href="{{ route('admin.resultats') }}" class="{{routeActive('admin.resultats')}}">Resultats</a></li>
                        </ul>
                    </li> --}}
                    <li class="sidebar-main-title">
                        <div>
                            <h6>Professeurs</h6>
                        </div>
                    </li>
                    <li>
                        <a class="nav-link menu-title link-nav {{routeActive('admin.professeurs-liste')}}" href="{{ route('admin.professeurs-liste') }}"><i data-feather="database"></i><span>Liste Professeurs</span></a>
                    </li>
                    <li class="sidebar-main-title">
                        <div>
                            <h6>Affections</h6>
                        </div>
                    </li>
                    <li class="dropdown">
                        <a class="nav-link menu-title {{ prefixActive('/scolarite/affectations') }}" href="javascript:void(0)"><i data-feather="file-text"></i><span>Affectations</span></a>
                        <ul class="nav-submenu menu-content"  style="display: {{ prefixBlock('/scolarite/affectations') }};">
                            <li><a href="{{ route('admin.scolarite.affectation-edutiant') }}" class="{{routeActive('admin.scolarite.affectation-edutiant')}}">Etudiants</a></li>
                            <li><a href="{{ route('admin.scolarite.affectation-liste-professeur') }}" class="{{routeActive('admin.scolarite.affectation-liste-professeur')}}">Professeurs</a></li>
                        </ul>
                    </li>
                    <li class="sidebar-main-title">
                        <div>
                            <h6>Etudiants</h6>
                        </div>
                    </li>
                    <li>
                        <a class="nav-link menu-title link-nav {{routeActive('admin.liste-etudiants')}}" href="{{ route('admin.liste-etudiants') }}"><i data-feather="database"></i><span>Liste étudiants</span></a>
                    </li>
                    <li class="sidebar-main-title">
                        <div>
                            <h6>Emploi du temps</h6>
                        </div>
                    </li>
                    <li class="dropdown">
                        <a class="nav-link menu-title {{ prefixActive('/scolarite/emploi-du-temps') }}" href="javascript:void(0)"><i data-feather="file-text"></i><span>Emploi du temps</span></a>
                        <ul class="nav-submenu menu-content"  style="display: {{ prefixBlock('/scolarite/emploi-du-temps') }};">
                            <li><a href="{{ route('admin.scolarite.emploi-du-temps.index') }}" class="{{routeActive('admin.scolarite.emploi-du-temps.index')}}">Liste classes</a></li>
                        </ul>
                    </li>
                    <li class="sidebar-main-title">
                        <div>
                            <h6>Cahier de Texte</h6>
                        </div>
                    </li>
                    <li>
                        <a class="nav-link menu-title link-nav {{routeActive('admin.cahier-text')}}" href="{{ route('admin.cahier-text') }}"><i data-feather="database"></i><span>Cahier de texte</span></a>
                    </li>
                    <li class="sidebar-main-title">
                        <div>
                            <h6>Notes & PV</h6>
                        </div>
                    </li>
                    <li>
                        <a class="nav-link menu-title link-nav {{routeActive('admin.scolarite-liste-classes-notes')}}" href="{{ route('admin.scolarite-liste-classes-notes') }}"><i data-feather="database"></i><span>Notes</span></a>
                    </li>
                    <li>
                        <a class="nav-link menu-title link-nav {{routeActive('admin.scolarite-liste-classe-pv', 1)}}" href="{{ route('admin.scolarite-liste-classe-pv', 1) }}"><i data-feather="database"></i><span>PV</span></a>
                    </li>
                    {{-- <li class="dropdown">
                        <a class="nav-link menu-title {{ prefixActive('/personnel/notes') }}" href="javascript:void(0)"><i data-feather="file-text"></i><span>Notes</span></a>
                        <ul class="nav-submenu menu-content"  style="display: {{ prefixBlock('/personnel/notes') }};">
                            <li><a href="{{ route('admin.liste-classes-notes') }}" class="{{routeActive('admin.liste-classes-notes')}}">Liste classes</a></li>
                        </ul>
                    </li> --}}
                    <li class="sidebar-main-title">
                        <div>
                            <h6>Progressions cours</h6>
                        </div>
                    </li>
                    <li>
                        <a class="nav-link menu-title link-nav {{routeActive('admin.liste-classe-progression')}}" href="{{ route('admin.liste-classe-progression') }}"><i data-feather="database"></i><span>Progresssions</span></a>
                    </li>
                    <li class="sidebar-main-title">
                        <div>
                            <h6>Chat App</h6>
                        </div>
                    </li>
                    <li>
                        <a class="nav-link menu-title link-nav {{routeActive('admin.chat')}}" href="{{ route('admin.chat') }}"><i data-feather="message-square"></i><span>Chap</span></a>
                    </li>
                </ul>
            </div>
            <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
        </div>
    </nav>
</header>
