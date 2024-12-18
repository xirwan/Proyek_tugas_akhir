<!-- start: header -->
<header class="header">
    <div class="logo-container">
        <a href="{{ route('dashboard') }}" class="logo">
            <img src="{{asset('admintemp/img/logo.png')}}" width="50" height="50" alt="GBI" />
        </a>
        <div class="d-md-none toggle-sidebar-left" data-toggle-class="sidebar-left-opened" data-target="html" data-fire-event="sidebar-left-opened">
            <i class="fas fa-bars" aria-label="Toggle sidebar"></i>
        </div>
    </div>
    <!-- start: search & user box -->
    <div class="header-right">
        <span class="separator"></span>
        <div id="userbox" class="userbox">
            <a href="#" data-toggle="dropdown">
                <div class="profile-info">
                    <span class="name">{{ Auth::user()->name }}</span>
                    <span class="role">
                        @if(Auth::user()->getRoleNames()->first() === 'SuperAdmin')
                            Admin
                        @elseif(Auth::user()->getRoleNames()->first() === 'Admin')
                            Pembina
                        @else
                            {{ Auth::user()->getRoleNames()->first() }}
                        @endif
                    </span>
                </div>
                <i class="fa custom-caret"></i>
            </a>
            <div class="dropdown-menu">
                <ul class="list-unstyled mb-2">
                    <li class="divider"></li>
                    <li>
                        @if(auth()->user()->hasRole('Jemaat'))
                            <a role="menuitem" tabindex="-1" href="{{ route('userprofile.edit') }}"><i class="bx bx-user-circle"></i> My Profile</a>
                        @else
                            <a role="menuitem" tabindex="-1" href="{{ route('profile.edit') }}"><i class="bx bx-user-circle"></i> My Profile</a>
                        @endif
                    </li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}" style="display: none;" id="logout-form">
                            @csrf
                        </form>
                        <a role="menuitem" tabindex="-1" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="bx bx-power-off"></i> Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- end: search & user box -->
</header>
<!-- end: header -->