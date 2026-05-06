@extends('layouts.dashboard')

@section('title','Laporan')

@section('content')

<!-- Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Laporan Sistem</h1>

    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
        <i class="fas fa-download fa-sm text-white-50"></i>
        Export PDF
    </a>
</div>

<!-- Statistik -->
<div class="row">

    <!-- Total User -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                    Total User
                </div>

                <div class="h5 mb-0 font-weight-bold text-gray-800">
                    {{ $totalUser }}
                </div>
            </div>
        </div>
    </div>

    <!-- Booking -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                    Total Booking
                </div>

                <div class="h5 mb-0 font-weight-bold text-gray-800">
                    {{ $totalBooking }}
                </div>
            </div>
        </div>
    </div>

    <!-- Omzet -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                    Total Pendapatan
                </div>

                <div class="h5 mb-0 font-weight-bold text-gray-800">
                    Rp {{ number_format($totalIncome,0,',','.') }}
                </div>
            </div>
        </div>
    </div>

    <!-- Pending -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                    Pending Booking
                </div>

                <div class="h5 mb-0 font-weight-bold text-gray-800">
                    {{ $pending }}
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Table -->
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
                        <th>Total</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>

                @foreach($latest as $item)

                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->package->name ?? '-' }}</td>
                        <td>Rp {{ number_format($item->total_price,0,',','.') }}</td>
                        <td>{{ ucfirst($item->status) }}</td>
                    </tr>

                @endforeach

                </tbody>

            </table>

        </div>

    </div>
</div>

@endsection