@extends('layouts.dashboard')

@section('title','Riwayat Booking')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Riwayat Booking</h1>
</div>

<div class="card shadow mb-4">

    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            Daftar Riwayat Booking Layanan
        </h6>
    </div>

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-bordered table-hover table-striped" width="100%" cellspacing="0">

                <thead class="thead-light">
                    <tr>
                        <th>No</th>
                        <th>Customer</th>
                        <th>Paket</th>
                        <th>Tipe</th>
                        <th>Tanggal Booking</th>
                        <th>Total Harga</th>
                        <th>Status Bayar</th>
                        <th>Status Booking</th>
                        <th width="100">Hasil</th>
                    </tr>
                </thead>

                <tbody>

                @forelse($riwayat as $item)

                    <tr>

                        <td>{{ $loop->iteration }}</td>

                        <td>
                            <strong>{{ $item->name }}</strong><br>
                            <small class="text-muted">{{ $item->email }}</small>
                        </td>

                        <td>{{ $item->package->name ?? '-' }}</td>
                        
                        <td>
                            <span class="badge badge-light text-dark">
                                {{ ucfirst($item->type) }}
                            </span>
                        </td>

                        <td>{{ \Carbon\Carbon::parse($item->booking_date)->translatedFormat('d M Y') }}</td>

                        <td>
                            Rp {{ number_format($item->total_price, 0, ',', '.') }}
                        </td>

                        <td>
                            @php
                                $payColor = match($item->payment_status) {
                                    'paid'    => 'success',
                                    'pending' => 'warning',
                                    'failed'  => 'danger',
                                    default   => 'secondary'
                                };
                            @endphp
                            <span class="badge badge-{{ $payColor }}">
                                {{ ucfirst($item->payment_status ?? 'Pending') }}
                            </span>
                        </td>

                        <td>
                            @php
                                $statusColor = match($item->status) {
                                    'pending'   => 'warning',
                                    'scheduled' => 'info',
                                    'done'      => 'success',
                                    'cancelled' => 'danger',
                                    default     => 'secondary'
                                };
                                
                                $statusLabel = match($item->status) {
                                    'pending'   => 'Pending',
                                    'scheduled' => 'Scheduled / Process',
                                    'done'      => 'Done',
                                    'cancelled' => 'Cancelled',
                                    default     => ucfirst($item->status)
                                };
                            @endphp
                            <span class="badge badge-{{ $statusColor }}">
                                {{ $statusLabel }}
                            </span>
                        </td>

                        <td>
                            <a href="{{ url('/reader/detail/'.$item->id) }}"
                               class="btn btn-primary btn-sm btn-block">
                                <i class="fas fa-eye fa-sm"></i> Detail
                            </a>
                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="9" class="text-center text-muted py-4">
                            <i class="fas fa-folder-open fa-2x mb-2 d-block text-gray-400"></i>
                            Belum ada riwayat transaksi booking.
                        </td>
                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection