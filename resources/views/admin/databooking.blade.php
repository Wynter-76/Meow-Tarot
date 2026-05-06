@extends('layouts.dashboard')

@section('title','Data Booking')

@section('content')

<!-- Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Data Booking</h1>
</div>

<!-- Card -->
<div class="card shadow mb-4">

    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            Seluruh Booking Customer
        </h6>
    </div>

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-bordered" width="100%" cellspacing="0">

                <thead>
                    <tr>
                        <th>No</th>
                        <th>Customer</th>
                        <th>Paket</th>
                        <th>Tanggal</th>
                        <th>Jam</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Payment</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>

                @forelse($booking as $item)

                    <tr>

                        <td>{{ $loop->iteration }}</td>

                        <td>{{ $item->name }}</td>

                        <td>{{ $item->package->name ?? '-' }}</td>

                        <td>{{ $item->booking_date }}</td>

                        <td>{{ $item->booking_time }}</td>

                        <td>
                            Rp {{ number_format($item->total_price,0,',','.') }}
                        </td>

                        <td>

                            @if($item->status == 'pending')
                                <span class="badge badge-warning">Pending</span>

                            @elseif($item->status == 'process')
                                <span class="badge badge-info">Process</span>

                            @elseif($item->status == 'done')
                                <span class="badge badge-success">Done</span>

                            @else
                                <span class="badge badge-danger">
                                    {{ $item->status }}
                                </span>
                            @endif

                        </td>

                        <td>

                            @if($item->payment_status == 'paid')
                                <span class="badge badge-success">
                                    Paid
                                </span>
                            @else
                                <span class="badge badge-warning">
                                    Pending
                                </span>
                            @endif

                        </td>
                        
                        <td>
                            @if($item->status == 'pending')
                                <a href="{{ url('/admin/approve/'.$item->id) }}"
                                class="btn btn-success btn-sm">
                                    Approve
                                </a>

                                <a href="{{ url('/admin/reject/'.$item->id) }}"
                                class="btn btn-danger btn-sm"
                                onclick="return confirm('Yakin mau reject booking ini?')">
                                    Reject
                                </a>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="8" class="text-center">
                            Belum ada booking
                        </td>
                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>
</div>

@endsection