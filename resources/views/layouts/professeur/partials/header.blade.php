<div class="page-main-header">
    <div class="main-header-right row m-0">
        <div class="main-header-left">
            <div class="logo-wrapper"><a href="{{ route('prof.dashboard') }}"><img class="img-fluid" src="{{asset(env('LOGO_PATH'))}}" alt=""></a></div>
            <div class="dark-logo-wrapper"><a href="{{ route('prof.dashboard') }}"><img class="img-fluid" src="{{asset(env('LOGO_PATH'))}}" alt=""></a></div>
            <div class="toggle-sidebar"><i class="status_toggle middle" data-feather="align-center" id="sidebar-toggle">    </i></div>
        </div>
        <div class="left-menu-header col">
            <ul>
                <li>
                <form class="form-inline search-form">
                    <div class="search-bg"><i class="fa fa-search"></i>
                    <input class="form-control-plaintext" placeholder="Search here.....">
                    </div>
                </form>
                <span class="d-sm-none mobile-search search-bg"><i class="fa fa-search"></i></span>
                </li>
            </ul>
        </div>
        <div class="nav-right col pull-right right-menu p-0">
            <ul class="nav-menus">
                <li><a class="text-dark" href="#!" onclick="javascript:toggleFullScreen()"><i data-feather="maximize"></i></a></li>
                <li class="onhover-dropdown">
                    <div class="notification-box"><i data-feather="bell"></i><span class="dot-animated"></span></div>
                    <ul class="notification-dropdown onhover-show-div">
                        <li>
                            <p class="f-w-700 mb-0">{{ count(Auth::user()->notifications) }} nouvelles Notifications<span class="pull-right badge badge-primary badge-pill">{{ Auth::user()->notifications->count() }}</span></p>
                        </li>
                        @foreach (Auth::user()->notifications as $notification)
                        <li class="noti-primary">
                            <div class="media">
                                <span class="notification-bg bg-light-primary"><i data-feather="check-circle"> </i></span>
                                <div class="media-body">
                                    <p>{{ $notification->data['message'] }}</p>
                                    <span>{{ $notification->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </li>
                <li>
                    <div class="mode" style="cursor: pointer;"><i class="fa fa-moon-o"></i></div>
                </li>
                <li class="onhover-dropdown p-0">
                    <a href="{{ route('logout') }}" class="btn btn-primary-light"
                        onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                        {{ __('Déconnexion') }}
                    <i data-feather="log-out"></i></a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>
        <div class="d-lg-none mobile-toggle pull-right w-auto"><i data-feather="more-horizontal"></i></div>
    </div>
</div>
