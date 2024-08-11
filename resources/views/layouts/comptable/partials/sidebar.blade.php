<header class="main-nav">
    <div class="sidebar-user text-center">
        <a class="setting-primary" href="javascript:void(0)"><i data-feather="settings"></i></a><img class="img-90 rounded-circle" src="{{asset('assets/images/dashboard/1.png')}}" alt="" />
        <div class="badge-bottom"><span class="badge badge-primary">{{ Auth::user()->type }}</span></div>
        <a href="{{ route('admin.comptable-profil') }}"> <h6 class="mt-3 f-14 f-w-600">{{ Auth::user()->fullname }}</h6></a>
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
                        <a class="nav-link menu-title link-nav {{routeActive('admin.dashboard-comptable')}}" href="{{ route('admin.dashboard-comptable') }}"><i data-feather="home"></i><span>Tableau de bord</span></a>
                    </li>
                    {{-- <li class="sidebar-main-title">
                        <div>
                            <h6>Présence</h6>
                        </div>
                    </li> --}}
                    {{-- <li class="dropdown">
                        <a class="nav-link menu-title {{ prefixActive('/personnel/liste-presence') }}" href="javascript:void(0)"><i data-feather="file-text"></i><span>Liste Présence</span></a>
                        <ul class="nav-submenu menu-content"  style="display: {{ prefixBlock('/personnel/liste-presence') }};">
                            @foreach (Auth::user()->classes as $classe)
                            <li><a href="{{ route('prof.liste-presence', $classe->id) }}" class="{{routeActive('prof.liste-presence', $classe->id)}}">{{ $classe->nom }}</a></li>
                            @endforeach
                        </ul>
                    </li> --}}
                    {{-- <li class="dropdown">
                        <a class="nav-link menu-title {{ prefixActive('/personnel/consultation-presence') }}" href="javascript:void(0)"><i data-feather="file-text"></i><span>Consultations</span></a>
                        <ul class="nav-submenu menu-content"  style="display: {{ prefixBlock('/personnel/consultation-presence') }};">
                            @foreach (Auth::user()->classes as $classe)
                            <li><a href="{{ route('prof.consultation-poste-liste-presence', $classe->id) }}" class="{{routeActive('prof.consultation-poste-liste-presence', $classe->id)}}">{{ $classe->nom }}</a></li>
                            @endforeach
                        </ul>
                    </li> --}}
                    {{-- <li class="dropdown">
                        <a class="nav-link menu-title {{ prefixActive('/personnel/consultation-presence') }}" href="javascript:void(0)"><i data-feather="file-text"></i><span>Notes</span></a>
                        <ul class="nav-submenu menu-content"  style="display: {{ prefixBlock('/personnel/consultation-presence') }};">
                            @foreach (Auth::user()->classes as $classe)
                            <li><a href="{{ route('prof.notes', $classe->id) }}" class="{{routeActive('prof.notes', $classe->id)}}">{{ $classe->nom }}</a></li>
                            @endforeach
                        </ul>
                    </li> --}}
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
                            <h6>Inscriptions</h6>
                        </div>
                    </li>
                    <li>
                        <a class="nav-link menu-title link-nav {{routeActive('admin.liste-etudiant-inscription')}}" href="{{ route('admin.liste-etudiant-inscription') }}"><i data-feather="list"></i><span>Inscriptions</span></a>
                    </li>
                    <li class="sidebar-main-title">
                        <div>
                            <h6>Reçus étudiant</h6>
                        </div>
                    </li>
                    <li>
                        <a class="nav-link menu-title link-nav {{routeActive('admin.liste-etudiant-scolarite')}}" href="{{ route('admin.liste-etudiant-scolarite') }}"><i data-feather="shopping-bag"></i><span>Reçus étudiant</span></a>
                    </li>
                    <li class="sidebar-main-title">
                        <div>
                            <h6>Reçus Professeur</h6>
                        </div>
                    </li>
                    <li>
                        <a class="nav-link menu-title link-nav {{routeActive('admin.liste-professeur-recu')}}" href="{{ route('admin.liste-professeur-recu') }}"><i data-feather="shopping-bag"></i><span>Reçus Professeur</span></a>
                    </li>
                    <li class="sidebar-main-title">
                        <div>
                            <h6>Professeurs</h6>
                        </div>
                    </li>
                    <li>
                        <a class="nav-link menu-title link-nav {{routeActive('admin.comptable-liste-professeurs')}}" href="{{ route('admin.comptable-liste-professeurs') }}"><i data-feather="align-justify"></i><span>Liste Professeurs</span></a>
                    </li>
                    <li class="sidebar-main-title">
                        <div>
                            <h6>Fiche de Vacation</h6>
                        </div>
                    </li>
                    <li>
                        <a class="nav-link menu-title link-nav {{routeActive('admin.fiche-vacation')}}" href="{{ route('admin.fiche-vacation') }}"><i data-feather="file-minus"></i><span>Fiche de vacation</span></a>
                    </li>
                    {{-- <li class="dropdown">
                        <a class="nav-link menu-title {{ prefixActive('/comptable/scolarite') }}" href="javascript:void(0)"><i data-feather="file-text"></i><span>Scolarité</span></a>
                        <ul class="nav-submenu menu-content"  style="display: {{ prefixBlock('/comptable/scolarite') }};">
                            <li><a href="{{ route('admin.liste-etudiant-scolarite') }}" class="{{routeActive('admin.liste-etudiant-scolarite')}}">Liste étudiants</a></li>
                        </ul>
                    </li> --}}
                    <li class="sidebar-main-title">
                        <div>
                            <h6>Echéancier</h6>
                        </div>
                    </li>
                    <li>
                        <a class="nav-link menu-title link-nav {{routeActive('admin.liste-etudiant-echeancier')}}" href="{{ route('admin.liste-etudiant-echeancier') }}"><i data-feather="align-justify"></i><span>Echéancier</span></a>
                    </li>
                    {{-- <li class="dropdown">
                        <a class="nav-link menu-title {{ prefixActive('/personnel/classe') }}" href="javascript:void(0)"><i data-feather="file-text"></i><span>Classe</span></a>
                        <ul class="nav-submenu menu-content"  style="display: {{ prefixBlock('/personnel/classe') }};">
                            <li><a href="{{ route('admin.classe.index') }}" class="{{routeActive('admin.classe.index')}}">Liste classe</a></li>
                            <li><a href="{{ route('admin.classe.create') }}" class="{{routeActive('admin.classe.create')}}">Nouvelle classe</a></li>
                        </ul>
                    </li> --}}
                    {{-- <li class="sidebar-main-title">
                        <div>
                            <h6>Chat App</h6>
                        </div>
                    </li>
                    <li>
                        <a class="nav-link menu-title link-nav {{routeActive('chat-app')}}" href="{{ route('chat-app') }}"><i data-feather="message-square"></i><span>Chap</span></a>
                    </li> --}}
                </ul>
            </div>
            <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
        </div>
    </nav>
</header>
