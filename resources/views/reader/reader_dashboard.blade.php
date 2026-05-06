@extends('layouts.dashboard')

@section('title','Dashboard Reader')

@section('content')

<!-- Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard Reader</h1>
</div>

<!-- Statistik -->
<div class="row">

    <!-- Booking Masuk -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">

            <div class="card-body">
                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                    Booking Masuk
                </div>

                <div class="h5 mb-0 font-weight-bold text-gray-800">
                    {{ $bookingMasuk }}
                </div>
            </div>

        </div>
    </div>

    <!-- Diproses -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">

            <div class="card-body">
                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                    Sedang Diproses
                </div>

                <div class="h5 mb-0 font-weight-bold text-gray-800">
                    {{ $diproses }}
                </div>
            </div>

        </div>
    </div>

    <!-- Selesai -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">

            <div class="card-body">
                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                    Selesai
                </div>

                <div class="h5 mb-0 font-weight-bold text-gray-800">
                    {{ $selesai }}
                </div>
            </div>

        </div>
    </div>

</div>

<!-- Booking terbaru -->
<div class="card shadow mb-4">

    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            Booking Terbaru
        </h6>
    </div>

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-bordered">

                <thead>
                    <tr>
                        <th>No</th>
                        <th>Customer</th>
                        <th>Paket</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>

                @foreach($latest as $item)

                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->package->name ?? '-' }}</td>
                        <td>{{ $item->booking_date }}</td>
                        <td>{{ ucfirst($item->status) }}</td>
                    </tr>

                @endforeach

                </tbody>

            </table>

        </div>

    </div>
</div>

@endsection