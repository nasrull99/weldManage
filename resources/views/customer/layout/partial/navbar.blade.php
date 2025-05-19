<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">

    <nav class="navbar bg-body-tertiary">
        <div class="container-fluid align-items-center d-flex">
            <a class="navbar-brand text-white" href="{{ route('dashboard') }}">
                <img src="{{ url('images/logoAMD-no-bg-white.png') }}" alt="Logo" width="30" height="24" class="d-inline-block align-text-top rounded">
                AMD SYNERGY
            </a>
            <!-- Sidebar Toggle Button right after logo -->
            <button class="btn btn-link btn-sm" id="sidebarToggle" href="#!">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </nav>

    <!-- Navbar Search-->
    <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
        {{-- <div class="input-group">
            <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
            <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
        </div> --}}
    </form>

    <!-- Navbar-->
    <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i>{{ Auth::user()->name }}</a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="{{ route('customer.changePasswordForm') }}">Change Password</a></li>                <li><hr class="dropdown-divider" /></li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <a class="dropdown-item":href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                            this.closest('form').submit();"
                                >
                        {{ __('Log Out') }}
                    </a>
                </form>
            </ul>
        </li>
    </ul>
</nav>