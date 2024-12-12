<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle (Topbar) -->
    <form class="form-inline">
        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
        </button>
    </form>

    <!-- Topbar Search -->
    <img src="{{ asset('vendor/img/bcimage1.png') }}" style="height: 50px;" alt="">

    @if (Auth::user()->type == 'registrar' && Route::currentRouteName() === 'registrar.index')
    <div class="w-100 d-flex justify-content-end">
        <div class="input-group w-50">
            <input type="text" id="search" class="form-control bg-light border-1 small"
                placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
            <div class="input-group-append mr-3">
                <button class="btn btn-primary" type="button" id="clearSearch">
                    <i class="fas fa-times fa-sm"></i> Clear
                </button>
            </div>
        </div>
    </div>
    @endif
    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">

        <!-- Nav Item - Alerts -->

        <!-- Nav Item - Messages -->

        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->name }}</span>
                @if (Auth::user()->type == 'registrar')
                <img class="img-profile rounded-circle" src="{{ asset('vendor/img/undraw_profile_1.svg') }}">

                @elseif (Auth::user()->type == 'teacher')
                <img class="img-profile rounded-circle" src="{{ asset('vendor/img/undraw_profile_2.svg') }}">

                @else
                <img class="img-profile rounded-circle" src="{{ asset('vendor/img/undraw_profile.svg') }}">
                @endif

            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Profile
                </a>
                <a class="dropdown-item" href="#">
                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                    Settings
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                </a>
            </div>
        </li>

    </ul>

</nav>