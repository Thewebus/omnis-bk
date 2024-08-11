<header class="main-nav">
    <div class="sidebar-user text-center">
        <a class="setting-primary" href="javascript:void(0)"><i data-feather="settings"></i></a><img class="img-90 rounded-circle" src="{{asset('assets/images/dashboard/1.png')}}" alt="" />
        {{-- http://ua.omnis-ci.com/assets/images/dashboard/1.png --}}
        <div class="badge-bottom"><span class="badge badge-primary">{{ Auth::user()->type }}</span></div>
        <a href="{{ route('admin.profil-informaticien') }}"> <h6 class="mt-3 f-14 f-w-600">{{ Auth::user()->fullname }}</h6></a>
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
                        <a class="nav-link menu-title link-nav {{routeActive('admin.dashboard-informatique')}}" href="{{ route('admin.dashboard-informatique') }}"><i data-feather="database"></i><span>Tableau de bord</span></a>
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
                            <h6>Signataires Bulletin</h6>
                        </div>
                    </li>
                    <li class="dropdown">
                        <a class="nav-link menu-title {{ prefixActive('/informaticien/signataires') }}" href="javascript:void(0)"><i data-feather="file-text"></i><span>Signataires</span></a>
                        <ul class="nav-submenu menu-content"  style="display: {{ prefixBlock('/informaticien/signataires') }};">
                            <li><a href="{{ route('admin.signataires.create') }}" class="{{routeActive('admin.signataires.create')}}">Nouveau</a></li>
                            <li><a href="{{ route('admin.signataires.index') }}" class="{{routeActive('admin.signataires.index')}}">Liste</a></li>
                        </ul>
                    </li>
                    <li class="sidebar-main-title">
                        <div>
                            <h6>Services & Personnels</h6>
                        </div>
                    </li>
                    <li class="dropdown">
                        <a class="nav-link menu-title {{ prefixActive('/informaticien/services') }}" href="javascript:void(0)"><i data-feather="file-text"></i><span>Services</span></a>
                        <ul class="nav-submenu menu-content"  style="display: {{ prefixBlock('/informaticien/services') }};">
                            <li><a href="{{ route('admin.services.create') }}" class="{{routeActive('admin.services.create')}}">Nouveau</a></li>
                            <li><a href="{{ route('admin.services.index') }}" class="{{routeActive('admin.services.index')}}">Liste</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a class="nav-link menu-title {{ prefixActive('/informaticien/personnels') }}" href="javascript:void(0)"><i data-feather="users"></i><span>Personnels</span></a>
                        <ul class="nav-submenu menu-content"  style="display: {{ prefixBlock('/informaticien/personnels') }};">
                            <li><a href="{{ route('admin.personnels.create') }}" class="{{routeActive('admin.personnels.create')}}">Nouveau</a></li>
                            <li><a href="{{ route('admin.personnels.index') }}" class="{{routeActive('admin.personnels.index')}}">Liste</a></li>
                        </ul>
                    </li>
                    <li class="sidebar-main-title">
                        <div>
                            <h6>Professeurs</h6>
                        </div>
                    </li>
                    <li class="dropdown">
                        <a class="nav-link menu-title {{ prefixActive('/informaticien/professeurs') }}" href="javascript:void(0)"><i data-feather="file-text"></i><span>Professeurs</span></a>
                        <ul class="nav-submenu menu-content"  style="display: {{ prefixBlock('/informaticien/professeurs') }};">
                            <li><a href="{{ route('admin.professeurs.create') }}" class="{{routeActive('admin.professeurs.create')}}">Nouveau</a></li>
                            <li><a href="{{ route('admin.professeurs.index') }}" class="{{routeActive('admin.professeurs.index')}}">Liste</a></li>
                        </ul>
                    </li>
                    <li class="sidebar-main-title">
                        <div>
                            <h6>Instituts</h6>
                        </div>
                    </li>
                    <li class="dropdown">
                        <a class="nav-link menu-title {{ prefixActive('/informaticien/institut') }}" href="javascript:void(0)"><i data-feather="file-text"></i><span>Instituts</span></a>
                        <ul class="nav-submenu menu-content"  style="display: {{ prefixBlock('/informaticien/institut') }};">
                            <li><a href="{{ route('admin.institut.create') }}" class="{{routeActive('admin.institut.create')}}">Nouveau</a></li>
                            <li><a href="{{ route('admin.institut.index') }}" class="{{routeActive('admin.institut.index')}}">Liste</a></li>
                        </ul>
                    </li>
                    <li class="sidebar-main-title">
                        <div>
                            <h6>Inscriptions</h6>
                        </div>
                    </li>
                    <li class="dropdown">
                        <a class="nav-link menu-title {{ prefixActive('/informaticien/inscription') }}" href="javascript:void(0)"><i data-feather="file-text"></i><span>Inscriptions</span></a>
                        <ul class="nav-submenu menu-content"  style="display: {{ prefixBlock('/informaticien/inscription') }};">
                            <li><a href="{{ route('admin.inscription-etudiant') }}" class="{{routeActive('admin.inscription-etudiant')}}">Nouvelles inscriptions</a></li>
                            <li><a href="{{ route('admin.inscription-etudiant-existant') }}" class="{{routeActive('admin.inscription-etudiant-existant')}}">Inscpt. Etd. Existant</a></li>
                            <li><a href="{{ route('admin.inscription-validee-liste-etudiant') }}" class="{{routeActive('admin.inscription-validee-liste-etudiant')}}">Inscription validées</a></li>
                        </ul>
                    </li>
                    <li class="sidebar-main-title">
                        <div>
                            <h6>Facultés & Classes & salles</h6> 
                        </div>
                    </li>
                    <li class="dropdown">
                        <a class="nav-link menu-title {{ prefixActive('/informaticien/facultes') }}" href="javascript:void(0)"><i data-feather="file-text"></i><span>Facultés</span></a>
                        <ul class="nav-submenu menu-content"  style="display: {{ prefixBlock('/informaticien/facultes') }};">
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
                    <li class="sidebar-main-title">
                        <div>
                            <h6>UE & Matières</h6>
                        </div>
                    </li>
                    <li class="dropdown">
                        <a class="nav-link menu-title {{ prefixActive('/informaticien/unite-enseignement') }}" href="javascript:void(0)"><i data-feather="file-text"></i><span>UE</span></a>
                        <ul class="nav-submenu menu-content"  style="display: {{ prefixBlock('/informaticien/unite-enseignement') }};">
                            <li><a href="{{ route('admin.unite-enseignement.index') }}" class="{{routeActive('admin.unite-enseignement.index')}}">Liste UE</a></li>
                            <li><a href="{{ route('admin.unite-enseignement.create') }}" class="{{routeActive('admin.unite-enseignement.create')}}">Nouvelle UE</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a class="nav-link menu-title {{ prefixActive('/informaticien/matiere') }}" href="javascript:void(0)"><i data-feather="file-text"></i><span>Matière</span></a>
                        <ul class="nav-submenu menu-content"  style="display: {{ prefixBlock('/informaticien/matiere') }};">
                            <li><a href="{{ route('admin.matiere.index') }}" class="{{routeActive('admin.matiere.index')}}">Liste matières</a></li>
                            <li><a href="{{ route('admin.matiere.create') }}" class="{{routeActive('admin.matiere.create')}}">Nouvelle matière</a></li>
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
                            <h6>Affections</h6>
                        </div>
                    </li>
                    <li class="dropdown">
                        <a class="nav-link menu-title {{ prefixActive('/informaticien/affectations') }}" href="javascript:void(0)"><i data-feather="file-text"></i><span>Affectations</span></a>
                        <ul class="nav-submenu menu-content"  style="display: {{ prefixBlock('/informaticien/affectations') }};">
                            <li><a href="{{ route('admin.affectation-edutiant') }}" class="{{routeActive('admin.affectation-edutiant')}}">Etudiants</a></li>
                            <li><a href="{{ route('admin.affectation-liste-professeur') }}" class="{{routeActive('admin.affectation-liste-professeur')}}">Professeurs</a></li>
                        </ul>
                    </li>
                    <li class="sidebar-main-title">
                        <div>
                            <h6>Emploi du temps</h6>
                        </div>
                    </li>
                    <li class="dropdown">
                        <a class="nav-link menu-title {{ prefixActive('/informaticien/emploi-du-temps') }}" href="javascript:void(0)"><i data-feather="file-text"></i><span>Emploi du temps</span></a>
                        <ul class="nav-submenu menu-content"  style="display: {{ prefixBlock('/informaticien/emploi-du-temps') }};">
                            <li><a href="{{ route('admin.emploi-du-temps.index') }}" class="{{routeActive('admin.emploi-du-temps.index')}}">Liste classes</a></li>
                        </ul>
                    </li>
                    <li class="sidebar-main-title">
                        <div>
                            <h6>Notes & Bulletins & PV</h6>
                        </div>
                    </li>
                    <li>
                        <a class="nav-link menu-title link-nav {{routeActive('admin.liste-classes-notes')}}" href="{{ route('admin.liste-classes-notes') }}"><i data-feather="database"></i><span>Notes</span></a>
                    </li>
                    <li>
                        <a class="nav-link menu-title link-nav {{routeActive('admin.liste-classe-bulletins', 1)}}" href="{{ route('admin.liste-classe-bulletins', 1) }}"><i data-feather="database"></i><span>Bulletin LMD</span></a>
                    </li>
                    <li>
                        <a class="nav-link menu-title link-nav {{routeActive('admin.liste-classe-bulletins-bts', 1)}}" href="{{ route('admin.liste-classe-bulletins-bts', 1) }}"><i data-feather="database"></i><span>Bulletin BTS</span></a>
                    </li>
                    <li>
                        <a class="nav-link menu-title link-nav {{routeActive('admin.liste-classe-pv')}}" href="{{ route('admin.liste-classe-pv', 1) }}"><i data-feather="database"></i><span>PV</span></a>
                    </li>
                    <li class="sidebar-main-title">
                        <div>
                            <h6>2e Session</h6>
                        </div>
                    </li>
                    <li>
                        <a class="nav-link menu-title link-nav {{routeActive('admin.deliberation')}}" href="{{ route('admin.deliberation') }}"><i data-feather="database"></i><span>Déliberations</span></a>
                    </li>
                    <li>
                        <a class="nav-link menu-title {{ prefixActive('/informaticien/session-2') }}" href="javascript:void(0)"><i data-feather="file-text"></i><span>2e Session</span></a>
                        <ul class="nav-submenu menu-content"  style="display: {{ prefixBlock('/informaticien/session-2') }};">
                            <li><a href="{{ route('admin.deliberation-sesson2') }}" class="{{routeActive('admin.deliberation-sesson2')}}">Délibérations</a></li>
                            <li><a href="{{ route('admin.sesson-2-nouvelles-note') }}" class="{{routeActive('admin.sesson-2-nouvelles-note')}}">Nouvelles notes</a></li>
                            @if (Auth::user()->email == "v.bourgou2@gmail.com" || Auth::user()->email == "youssouf.sidick.ys@outlook.com" || Auth::user()->email == "madjouattara05@gmail.com")
                            <li><a href="{{ route('admin.session-2-note-modification') }}" class="{{routeActive('admin.session-2-note-modification')}}">Modification notes</a></li>
                            @endif
                            <li><a href="{{ route('admin.session-2-note') }}" class="{{routeActive('admin.session-2-note')}}">Liste notes</a></li>
                            <li><a href="{{ route('admin.liste-classe-bulletins', 2) }}" class="{{routeActive('admin.liste-classe-bulletins', 2)}}">Bulletins</a></li>
                        </ul>
                    </li>
                    <li>
                        <a class="nav-link menu-title {{ prefixActive('/informaticien/rattrapage') }}" href="javascript:void(0)"><i data-feather="file-text"></i><span>Rattrapages</span></a>
                        <ul class="nav-submenu menu-content"  style="display: {{ prefixBlock('/informaticien/rattrapage') }};">
                            <li><a href="{{ route('admin.rattrapage.inscrit') }}" class="{{routeActive('admin.rattrapage.inscrit')}}">Inscrits</a></li>
                            <li><a href="{{ route('admin.rattrapage.non-inscrit') }}" class="{{routeActive('admin.rattrapage.non-inscrit')}}">Non Inscrits</a></li>
                            <li><a href="{{ route('admin.rattrapage.index') }}" class="{{routeActive('admin.rattrapage.index')}}">Notes Rattrapage</a></li>
                        </ul>
                        <a class="nav-link menu-title link-nav {{routeActive('admin.liste-classe-pv')}}" href="{{ route('admin.liste-classe-pv', 2) }}"><i data-feather="database"></i><span>PV Session 2</span></a>
                    </li>
                    <li class="sidebar-main-title">
                        <div>
                            <h6>Documents</h6>
                        </div>
                    </li>
                    <li>
                        <a class="nav-link menu-title link-nav {{routeActive('admin.attestation-admission')}}" href="{{ route('admin.attestation-admission') }}"><i data-feather="database"></i><span>Cert. admission</span></a>
                    </li>
                    <li class="sidebar-main-title">
                        <div>
                            <h6>Chat App</h6>
                        </div>
                    </li>
                    <li>
                        <a class="nav-link menu-title link-nav {{routeActive('admin.chat')}}" href="{{ route('admin.chat') }}"><i data-feather="message-square"></i><span>Chap</span></a>
                    </li>
                    <li class="sidebar-main-title">
                        <div>
                            <h6>Statistiques</h6>
                        </div>
                    </li>
                    <li>
                        <a class="nav-link menu-title link-nav {{routeActive('admin.statisques-facultes')}}" href="{{ route('admin.statisques-facultes') }}"><i data-feather="pie-chart"></i><span>Statistiques</span></a>
                    </li>
                    {{-- <li>
                        <a class="nav-link menu-title {{ prefixActive('/informaticien/statistiques') }}" href="javascript:void(0)"><i data-feather="pie-chart"></i><span>Statistiques</span></a>
                        <ul class="nav-submenu menu-content"  style="display: {{ prefixBlock('/informaticien/statistiques') }};">
                            <li>
                                <a class="submenu-title  {{ in_array(Route::currentRouteName(), ['admin.statistiques-session']) ? 'active' : '' }}" href="javascript:void(0)">
                                    Session 1<span class="sub-arrow"><i class="fa fa-chevron-right"></i></span>
                                </a>
                                <ul class="nav-sub-childmenu submenu-content" style="display: {{ in_array(Route::currentRouteName(), ['admin.statistiques-session']) ? 'block' : 'none' }};">
                                    <li><a href="{{ route('admin.statistiques-session', ['session' => 1, 'semestre' => 1 ]) }}" class="{{routeActive('admin.statistiques-session')}}">Semestre 1</a></li>
                                    <li><a href="{{ route('admin.statistiques-session', ['session' => 1, 'semestre' => 2 ]) }}" class="{{routeActive('admin.statistiques-session')}}">Semestre 2</a></li>
                                </ul>
                            </li>
                            <li>
                                <a class="submenu-title  {{ in_array(Route::currentRouteName(), ['admin.statistiques-session']) ? 'active' : '' }}" href="javascript:void(0)">
                                    Session 2<span class="sub-arrow"><i class="fa fa-chevron-right"></i></span>
                                </a>
                                <ul class="nav-sub-childmenu submenu-content" style="display: {{ in_array(Route::currentRouteName(), ['admin.statistiques-session']) ? 'block' : 'none' }};">
                                    <li><a href="{{ route('admin.statistiques-session', ['session' => 2, 'semestre' => 1 ]) }}" class="{{routeActive('admin.statistiques-session')}}">Semestre 1</a></li>
                                    <li><a href="{{ route('admin.statistiques-session', ['session' => 2, 'semestre' => 2 ]) }}" class="{{routeActive('admin.statistiques-session')}}">Semestre 2</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li> --}}
                </ul>
            </div>
            <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
        </div>
    </nav>
</header>
