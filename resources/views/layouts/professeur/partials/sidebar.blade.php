<header class="main-nav">
    <div class="sidebar-user text-center">
        <a class="setting-primary" href="javascript:void(0)"><i data-feather="settings"></i></a><img class="img-90 rounded-circle" src="{{asset('assets/images/dashboard/1.png')}}" alt="" />
        <div class="badge-bottom"><span class="badge badge-primary">{{ Auth::user()->type }}</span></div>
        <a href="{{ route('prof.profil') }}"> <h6 class="mt-3 f-14 f-w-600">{{ Auth::user()->fullname }}</h6></a>
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
                            <h6>Tableau de Bord</h6>
                        </div>
                    </li>
                    <li>
                        <a class="nav-link menu-title link-nav {{routeActive('prof.dashboard')}}" href="{{ route('prof.dashboard') }}"><i data-feather="database"></i><span>Tableau de bord</span></a>
                    </li>
                    @if (Auth::user()->classes->count() !== 0)
                        <li class="sidebar-main-title">
                            <div>
                                <h6>Présence</h6>
                            </div>
                        </li>
                        <li class="dropdown">
                            <a class="nav-link menu-title {{ prefixActive('/personnel/liste-presence') }}" href="javascript:void(0)"><i data-feather="file-text"></i><span>Liste Présence</span></a>
                            <ul class="nav-submenu menu-content"  style="display: {{ prefixBlock('/personnel/liste-presence') }};">
                                @foreach (Auth::user()->classes as $classe)
                                <li><a href="{{ route('prof.classe-details-presence', $classe->id) }}" class="{{routeActive('prof.classe-details-presence', $classe->id)}}">{{ $classe->nom }}</a></li>
                                @endforeach
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a class="nav-link menu-title {{ prefixActive('/personnel/consultation-presence') }}" href="javascript:void(0)"><i data-feather="file-text"></i><span>Consultations</span></a>
                            <ul class="nav-submenu menu-content"  style="display: {{ prefixBlock('/personnel/consultation-presence') }};">
                                @foreach (Auth::user()->classes as $classe)
                                <li><a href="{{ route('prof.classe-details-presence-consultation', $classe->id) }}" class="{{routeActive('prof.classe-details-presence-consultation', $classe->id)}}">{{ $classe->nom }}</a></li>
                                @endforeach
                            </ul>
                        </li>
                        <li class="sidebar-main-title">
                            <div>
                                <h6>Ressources</h6>
                            </div>
                        </li>
                        <li class="dropdown">
                            <a class="nav-link menu-title {{ prefixActive('/professeur/ressources') }}" href="javascript:void(0)"><i data-feather="file-text"></i><span>Ressources</span></a>
                            <ul class="nav-submenu menu-content"  style="display: {{ prefixBlock('/professeur/ressources') }};">
                                <li><a href="{{ route('prof.ressource-index') }}" class="{{routeActive('prof.ressource-index')}}">Liste ressources</a></li>
                                <li><a href="{{ route('prof.ressource-upload-form') }}" class="{{routeActive('prof.ressource-upload-form')}}">Nouvelles ressources</a></li>
                            </ul>
                        </li>
                        {{-- <li class="sidebar-main-title">
                            <div>
                                <h6>Notes</h6>
                            </div>
                        </li>
                        <li class="dropdown">
                            <a class="nav-link menu-title {{ prefixActive('/professeur/notes') }}" href="javascript:void(0)"><i data-feather="file-text"></i><span>Notes</span></a>
                            <ul class="nav-submenu menu-content"  style="display: {{ prefixBlock('/professeur/notes') }};">
                                @foreach (Auth::user()->classes as $classe)
                                <li><a href="{{ route('prof.classe-notes', $classe->id) }}" class="{{routeActive('prof.classe-notes', $classe->id)}}">{{ $classe->nom }}</a></li>
                                @endforeach
                            </ul>
                        </li> --}}
                        <li class="sidebar-main-title">
                            <div>
                                <h6>Cahier Texte</h6>
                            </div>
                        </li>
                        <li class="dropdown">
                            <a class="nav-link menu-title {{ prefixActive('/professeur/cahier-texte') }}" href="javascript:void(0)"><i data-feather="file-text"></i><span>Cahier Texte</span></a>
                            <ul class="nav-submenu menu-content"  style="display: {{ prefixBlock('/professeur/cahier-texte') }};">
                                @foreach (Auth::user()->classes as $classe)
                                <li><a href="{{ route('prof.cahier-texte-index', $classe->id) }}" class="{{routeActive('prof.cahier-texte-index', $classe->id)}}">{{ $classe->nom }}</a></li>
                                @endforeach
                                {{-- <li><a href="{{ route('prof.notes') }}" class="{{routeActive('prof.notes')}}">Nouvelle note</a></li>
                                <li><a href="{{ route('admin.filiere.create') }}" class="{{routeActive('admin.filiere.create')}}">Notes</a></li> --}}
                            </ul>
                        </li>
                        <li class="sidebar-main-title">
                            <div>
                                <h6>Emploi du temps</h6>
                            </div>
                        </li>
                        <li>
                            <a class="nav-link menu-title link-nav {{routeActive('prof.schedule')}}" href="{{ route('prof.schedule') }}"><i data-feather="database"></i><span>Emploi du temps</span></a>
                        </li>
                    @endif
                    <li class="sidebar-main-title">
                        <div>
                            <h6>Enregistrement</h6>
                        </div>
                    </li>
                    <li>
                        <a class="nav-link menu-title link-nav {{routeActive('prof.enregistrement')}}" href="{{ route('prof.enregistrement') }}"><i data-feather="database"></i><span>Enregistrement</span></a>
                    </li>
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
