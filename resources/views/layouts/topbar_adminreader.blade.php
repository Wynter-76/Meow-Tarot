<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle Mobile -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <!-- Title -->
    <div class="d-none d-sm-inline-block mr-auto ml-md-3 my-2 my-md-0">
        <h5 class="mb-0 text-gray-800">Meow Tarot Management</h5>
    </div>

    <!-- Navbar Right -->
    <ul class="navbar-nav ml-auto">

        <!-- Divider -->
        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- User -->
        <li class="nav-item dropdown no-arrow">

            <a class="nav-link dropdown-toggle" href="#" id="userDropdown"
               role="button" data-toggle="dropdown"
               aria-haspopup="true" aria-expanded="false">

                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                    {{ Auth::user()->name }}
                </span>

                <img class="img-profile rounded-circle"
                     src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=4e73df&color=fff">
            </a>

            <!-- Dropdown -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                 aria-labelledby="userDropdown">

                <div class="dropdown-divider"></div>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="dropdown-item">
                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                        Logout
                    </button>
                </form>

            </div>
        </li>

    </ul>

</nav>