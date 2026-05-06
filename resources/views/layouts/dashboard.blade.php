<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<title>@yield('title','Meow Tarot')</title>

<!-- Font -->
<link href="{{ asset('admin_reader/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900" rel="stylesheet">

<!-- CSS -->
<link href="{{ asset('admin_reader/css/sb-admin-2.min.css') }}" rel="stylesheet">

</head>

<body id="page-top">

<!-- Page Wrapper -->
<div id="wrapper">

    <!-- Sidebar -->
    @include('layouts.sidebar_adminreader')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <!-- Topbar -->
            @include('layouts.topbar_adminreader')

            <!-- Begin Page Content -->
            <div class="container-fluid">

                @yield('content')

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End Main Content -->

        <!-- Footer -->
        <footer class="sticky-footer bg-white">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>Copyright &copy; Meow Tarot 2026</span>
                </div>
            </div>
        </footer>

    </div>
</div>

<!-- Scroll Top -->
<a class="scroll-to-top rounded" href="#page-top">
<i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal -->
<div class="modal fade" id="logoutModal" tabindex="-1">
<div class="modal-dialog">
<div class="modal-content">

<div class="modal-header">
<h5 class="modal-title">Logout?</h5>
<button class="close" type="button" data-dismiss="modal">
<span>&times;</span>
</button>
</div>

<div class="modal-body">
Pilih logout jika ingin keluar.
</div>

<div class="modal-footer">
<button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
<a href="{{ route('logout') }}" class="btn btn-primary">Logout</a>
</div>

</div>
</div>
</div>

<!-- JS -->
<script src="{{ asset('admin_reader/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('admin_reader/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('admin_reader/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
<script src="{{ asset('admin_reader/js/sb-admin-2.min.js') }}"></script>

</body>
</html>