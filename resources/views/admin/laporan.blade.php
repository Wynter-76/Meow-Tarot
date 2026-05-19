@extends('layouts.dashboard')
@section('title', 'Laporan')
@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Laporan Transaksi</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/admin/dashboard">Dashboard</a></li>
                    <li class="breadcrumb-item active">Laporan</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">

        {{-- Summary Cards --}}
        <div class="row">
            <div class="col-md-4">
                <div class="info-box bg-gradient-primary">
                    <span class="info-box-icon text-white"><i class="fas fa-shopping-cart"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text text-white" style="color: #fff !important; font-weight: 500;">Total Transaksi</span>
                        <span class="info-box-number text-white" style="color: #fff !important; font-size: 1.5rem; font-weight: 700;">{{ $totalBooking }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info-box bg-gradient-success">
                    <span class="info-box-icon text-white"><i class="fas fa-money-bill-wave"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text text-white" style="color: #fff !important; font-weight: 500;">Total Revenue (Paid)</span>
                        <span class="info-box-number text-white" style="color: #fff !important; font-size: 1.5rem; font-weight: 700;">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info-box bg-gradient-warning">
                    <span class="info-box-icon text-white"><i class="fas fa-clock"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text text-white" style="color: #fff !important; font-weight: 500;">Pending Pembayaran</span>
                        <span class="info-box-number text-white" style="color: #fff !important; font-size: 1.5rem; font-weight: 700;">{{ $totalPending }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info-box bg-gradient-info">
                    <span class="info-box-icon text-white"><i class="fas fa-check-circle"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text text-white" style="color: #fff !important; font-weight: 500;">Transaksi Lunas</span>
                        <span class="info-box-number text-white" style="color: #fff !important; font-size: 1.5rem; font-weight: 700;">{{ $totalPaid }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info-box bg-gradient-danger">
                    <span class="info-box-icon text-white"><i class="fas fa-times-circle"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text text-white" style="color: #fff !important; font-weight: 500;">Transaksi Dibatalkan</span>
                        <span class="info-box-number text-white" style="color: #fff !important; font-size: 1.5rem; font-weight: 700;">{{ $totalCancelled }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info-box bg-gradient-secondary">
                    <span class="info-box-icon text-white"><i class="fas fa-calendar-check"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text text-white" style="color: #fff !important; font-weight: 500;">Terjadwal</span>
                        <span class="info-box-number text-white" style="color: #fff !important; font-size: 1.5rem; font-weight: 700;">{{ $totalScheduled }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Top Info --}}
        <div class="row">
            <div class="col-md-6">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-star mr-1"></i> Paket Terpopuler</h3>
                    </div>
                    <div class="card-body">
                        @if($topPackage && $topPackage->package)
                            <h4>{{ $topPackage->package->name }}</h4>
                            <p class="text-muted">Dipesan sebanyak <strong>{{ $topPackage->total }}</strong> kali</p>
                        @else
                            <p class="text-muted">Belum ada data</p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-outline card-success">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-user mr-1"></i> Customer Terbanyak Order</h3>
                    </div>
                    <div class="card-body">
                        @if($topCustomer && $topCustomer->user)
                            <h4>{{ $topCustomer->user->name }}</h4>
                            <p class="text-muted">Total order: <strong>{{ $topCustomer->total }}</strong> kali</p>
                        @else
                            <p class="text-muted">Belum ada data</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Tabel Transaksi + Export --}}
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-table mr-1"></i> Detail Semua Transaksi</h3>
                <div class="card-tools">
                    <a href="{{ route('admin.laporan.pdf') }}" class="btn btn-sm btn-danger">
                        <i class="fas fa-file-pdf"></i> Export PDF
                    </a>
                    <a href="{{ route('admin.laporan.excel') }}" class="btn btn-sm btn-success ml-1">
                        <i class="fas fa-file-excel"></i> Export Excel
                    </a>
                </div>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover table-striped table-sm" id="laporanTable">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th>No</th>
                            <th>Nama Customer</th>
                            <th>Email</th>
                            <th>Paket</th>
                            <th>Tipe</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Status Bayar</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bookings as $i => $b)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $b->name }}</td>
                            <td>{{ $b->email }}</td>
                            <td>{{ $b->package->name ?? '-' }}</td>
                            <td>{{ ucfirst($b->type) }}</td>
                            <td>{{ $b->booking_date }}</td>
                            <td>
                                @php
                                    $statusColor = match($b->status) {
                                        'pending'   => 'warning',
                                        'scheduled' => 'info',
                                        'done'      => 'success',
                                        'cancelled' => 'danger',
                                        default     => 'secondary'
                                    };
                                @endphp
                                <span class="badge badge-{{ $statusColor }}">
                                    {{ ucfirst($b->status) }}
                                </span>
                            </td>
                            <td>
                                @php
                                    $payColor = match($b->payment_status) {
                                        'paid'    => 'success',
                                        'pending' => 'warning',
                                        'failed'  => 'danger',
                                        default   => 'secondary'
                                    };
                                @endphp
                                <span class="badge badge-{{ $payColor }}">
                                    {{ ucfirst($b->payment_status) }}
                                </span>
                            </td>
                            <td>Rp {{ number_format($b->total_price, 0, ',', '.') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted">Belum ada transaksi</td>
                        </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr class="bg-light font-weight-bold">
                            <td colspan="8" class="text-right">Total Revenue (Paid):</td>
                            <td>Rp {{ number_format($totalRevenue, 0, ',', '.') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</section>

@endsection