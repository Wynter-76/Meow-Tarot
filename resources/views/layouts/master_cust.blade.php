<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Title dinamis -->
    <title>@yield('title','Meow Tarot')</title>

    <!-- CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

    <!-- Fonts -->
    <link rel="stylesheet" href="{{ asset('cust/fonts/ProximaNovaA-Semibold.css') }}">
    <link rel="stylesheet" href="{{ asset('cust/fonts/ProximaNova-Extrabld.css') }}">
    <link rel="stylesheet" href="{{ asset('cust/fonts/ProximaNovaA-Regular.css') }}">
    <link rel="stylesheet" href="{{ asset('cust/fonts/ProximaNovaA-Bold.css') }}">

    <!-- CSS Utama -->
    <link rel="stylesheet" href="{{ asset('cust/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('cust/css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('cust/css/style.css') }}">
</head>

<body>

    <!-- Navbar -->
    @include('layouts.navbar_cust')

    <!-- Konten -->
    @yield('content')

    @include('layouts.footer_cust')

    <div class="modal fade" id="modalHistory" tabindex="-1">
    <div class="modal-dialog" style="max-width: 90%;">
        <div class="modal-content">

        <div class="modal-header">
            <h5 class="modal-title">Riwayat Booking</h5>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Paket</th>
                        <th>Status</th>
                        <th>Hasil</th>
                    </tr>
                </thead>

                <tbody>
                @auth

                @forelse(Auth::user()->bookings as $item)
                    <tr>
                        <td>{{ $item->package->name ?? '-' }}</td>
                        <td>{{ $item->status }}</td>
                        <td>
                            @if($item->status == 'done')
                                {{ $item->reading_result }}
                            @else
                                <span class="text-muted">Menunggu hasil</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">
                            Belum ada data
                        </td>
                    </tr>
                @endforelse

            @endauth
                </tbody>

            </table>

        </div>

        </div>
    </div>
    </div>
    <!-- JS -->
    <script src="{{ asset('cust/js/vendor/jquery-1.11.2.min.js') }}"></script>
    <script src="{{ asset('cust/js/vendor/bootstrap.min.js') }}"></script>
    <script src="{{ asset('cust/js/wow.min.js') }}"></script>
    <script src="{{ asset('cust/js/custom.js') }}"></script>

</body>
</html>