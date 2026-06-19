<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/dashboard')}}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-cat"></i>
        </div>
        <div class="sidebar-brand-text mx-3">
            Meow Tarot
        </div>
    </a>

    <hr class="sidebar-divider my-0">

    <!-- Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{ url('/dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    <!-- ADMIN MENU -->
    @if(Auth::user()->role == 'admin')

    <div class="sidebar-heading">
        Admin Menu
    </div>

    <li class="nav-item">
        <a class="nav-link" href="{{ url('/admin/users') }}">
            <i class="fas fa-users"></i>
            <span>Kelola User</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ url('/admin/testimonial') }}">
            <i class="fas fa-comments"></i>
            <span>Testimonial</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ url('/admin/kelolapaket') }}">
            <i class="fas fa-box"></i>
            <span>Kelola Paket</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ url('/admin/databooking') }}">
            <i class="fas fa-calendar"></i>
            <span>Data Booking</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ url('/admin/laporan') }}">
            <i class="fas fa-chart-bar"></i>
            <span>Laporan</span>
        </a>
    </li>

    @endif

    <!-- READER MENU -->
    @if(Auth::user()->role == 'reader')

    <div class="sidebar-heading">
        Reader Menu
    </div>

    <li class="nav-item">
        <a class="nav-link" href="{{ url('/reader/bookingmasuk') }}">
            <i class="fas fa-list"></i>
            <span>Booking Masuk</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ url('/reader/riwayat') }}">
            <i class="fas fa-history"></i>
            <span>Riwayat</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ url('/rooms') }}">
            <i class="fas fa-comments"></i>
            <span>Room Chat</span>
        </a>
    </li>

    @endif

    <hr class="sidebar-divider d-none d-md-block">

    <!-- Toggle -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>