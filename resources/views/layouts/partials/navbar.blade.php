<header class="topbar bg-success">
    <nav class="navbar top-navbar navbar-expand-md navbar-dark bg-success my-auto">
        <div class="navbar-header bg-success">
            <a class="nav-toggler waves-effect waves-light d-block d-md-none " href="javascript:void(0)">
                <i class="ti-menu ti-close"></i>
            </a>

            <a class="navbar-brand bg-success" href="{{ url('home') }}">
                <b class="logo-icon">
                    <img src="{{ asset('assets/img/credit-union.png')}}" width="50" alt="logo">
                </b>
                <span class="logo-text">
                    <small class="text-white"><b>{{ env('APP_NAME') }}</b></small>
                </span>
            </a>
            <a class="topbartoggler d-block d-md-none bg-success waves-effect waves-light" href="javascript:void(0)" data-toggle="collapse" data-target="#navbarSupportedContent"  aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="ti-more"></i>
            </a>
        </div>
        <div class="navbar-collapse collapse my-auto bg-success" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto float-left my-auto bg-success">
                <li class="nav-item bg-success">
                    <a class="nav-link sidebartoggler d-none bg-success d-md-block waves-effect waves-dark my-auto" href="javascript:void(0)">
                        <i class="ti-menu"></i>
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav float-right">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <img src="{{ asset('images/logo-icon.png') }}" alt="user" width="30" class="profile-pic rounded-circle" />
                    </a>
                    <div class="dropdown-menu mailbox dropdown-menu-right scale-up">
                        <ul class="dropdown-user list-style-none">
                            <li>
                                <div class="dw-user-box p-3 d-flex">
                                    <div class="u-img"><img src="{{ asset('images/logo-icon.png') }}" alt="user" class="rounded" width="80"></div>
                                    <div class="u-text ml-2">
                                        <h4 class="mb-0">{{ auth()->user()->name }}</h4>
                                        <p class="text-muted mb-1 font-14">{{ auth()->user()->email }}</p>
                                    </div>
                                </div>
                            </li>
                            <li role="separator" class="dropdown-divider"></li>
                            <li class="user-list"><a class="px-3 py-2" href="#"><i class="ti-settings"></i> Account Setting</a></li>
                            <li role="separator" class="dropdown-divider"></li>
                            <li class="user-list">
                                <a class="px-3 py-2" href="{{ route('logout') }}" onclick="event.preventDefault();  document.getElementById('logout-form').submit();">
                                    <i class="fa fa-power-off"></i>
                                    Logout
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</header>
