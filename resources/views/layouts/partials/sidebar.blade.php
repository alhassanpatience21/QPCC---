<aside class="left-sidebar">
    <div class="scroll-sidebar">
        <div class="user-profile position-relative" style="background: url({{asset('images/background/user-info.jpg')}}) no-repeat;">
            <div class="profile-img">
                <img src="{{ asset('images/users/profile.png') }}" alt="user" class="w-100"/>
            </div>
            <div class="profile-text pt-1">
                <a href="#" class="dropdown-toggle u-dropdown w-100 text-white d-block position-relative" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">{{ auth()->user()->name }}</a>
                <div class="dropdown-menu animated flipInY">
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="ti-settings"></i>
                        Account Setting
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();  document.getElementById('logout-form').submit();">
                        <i class="fa fa-power-off"></i>
                        Logout
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
        </div>

        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li class="nav-small-cap">
                    <i class="mdi mdi-dots-horizontal"></i>
                    <span class="hide-menu">Sidebar</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link  waves-dark" href="{{ route('home') }}">
                        <i class="mdi mdi-gauge"></i>
                        <span class="hide-menu">Dashboard </span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark" href="{{ route('accounts.index') }}">
                        <i class="mdi mdi-account"></i>
                        <span class="hide-menu">Accounts</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark" href="{{ route('deposits.index') }}">
                        <i class="ti-wallet"></i>
                        <span class="hide-menu">Deposits</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark" href="{{ route('withdrawals.index') }}">
                        <i class="ti-infinite"></i>
                        <span class="hide-menu">Withdrawals</span>
                    </a>
                </li>

                @can('view-any', 'App\Models\User')
                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                        <i class="mdi mdi-checkbox-marked-circle-outline"></i>
                        <span class="hide-menu">Approvals</span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level">
                        <li class="sidebar-item">
                            <a href="{{ route('approvals') }}" class="sidebar-link">
                                <i class="mdi mdi-checkbox-marked-circle-outline"></i>
                                <span class="hide-menu">Deposits</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="{{ route('withdrawal.approvals') }}" class="sidebar-link">
                                <i class="mdi mdi-checkbox-marked-circle-outline"></i>
                                <span class="hide-menu">Withdrawals</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="ti-money"></i><span class="hide-menu">Loans</span></a>
                    <ul aria-expanded="false" class="collapse first-level">
                        <li class="sidebar-item">
                            <a href="{{ route('loans.index') }}" class="sidebar-link">
                                <i class="mdi mdi-emoticon"></i>
                                <span class="hide-menu">Outstanding Loans</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="{{ route('loans.index', 'type=completed') }}" class="sidebar-link">
                                <i class="mdi mdi-emoticon"></i>
                                <span class="hide-menu">Completed Loans</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('loan-repayments.index') }}" class="sidebar-link">
                                <i class="mdi mdi-emoticon"></i>
                                <span class="hide-menu">Repayment Approvals</span>
                            </a>
                        </li>
                    </ul>
                </li>
                @endcannot

                @cannot('view-any', 'App\Models\User')
                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark" href="{{ route('loans.index') }}">
                        <i class="ti-money"></i>
                        <span class="hide-menu">Loans</span>
                    </a>
                </li>
                @endcannot

                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark" href="{{ route('passbook-fees') }}">
                        <i class="fas fa-book"></i>
                        <span class="hide-menu">Passbook Fees</span>
                    </a>
                </li>

                @can('view-any', 'App\Models\User')
                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark" href="{{ route('commissions.index') }}">
                        <i class="fas fa-box"></i>
                        <span class="hide-menu">Commissions</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark" href="{{ route('sms.index') }}">
                        <i class="mdi mdi-email-secure"></i>
                        <span class="hide-menu">SMS</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a href="{{ route('bank-accounts.index') }}" class="sidebar-link">
                        <i class="mdi mdi-chart-line"></i>
                        <span class="hide-menu">Bank Accounts</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a href="{{ route('reports') }}" class="sidebar-link">
                        <i class="mdi mdi-file"></i>
                        <span class="hide-menu">Reports</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a href="{{ route('users.index') }}" class="sidebar-link">
                        <i class="mdi mdi-account"></i>
                        <span class="hide-menu">Users</span>
                    </a>
                </li>
                @endcan
            </ul>
        </nav>
    </div>
</aside>

<div class="page-wrapper">
    @include('layouts.partials.breadcrums')
    <div class="container-fluid">
