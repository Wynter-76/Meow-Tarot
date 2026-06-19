@extends('layouts.dashboard')

@section('title','Booking Masuk')

@section('content')

<!-- Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Booking Masuk</h1>
</div>

<!-- Card -->
<div class="card shadow mb-4">

    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            Daftar Booking Customer
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
                        <th>Tipe</th>
                        <th>Tanggal</th>
                        <th>Jam</th>
                        <th>Status</th>
                        <th width="230">Aksi</th>
                    </tr>
                </thead>

                <tbody>

                @forelse($booking as $item)

                    <tr>

                        <td>{{ $loop->iteration }}</td>

                        <td>{{ $item->name }}</td>
                        
                        <td>{{ $item->type}}</td>

                        <td>{{ $item->package->name ?? '-' }}</td>

                        <td>{{ $item->booking_date }}</td>

                        <td>{{ $item->booking_time }}</td>

                        <td>

                            @if($item->status == 'pending')
                                <span class="badge badge-warning">
                                    Pending
                                </span>

                            @elseif($item->status == 'processing')
                                <span class="badge badge-info">
                                    Processing
                                </span>

                            @elseif($item->status == 'scheduled')
                                <span class="badge badge-info">
                                    Scheduled
                                </span>

                            @else
                                <span class="badge badge-success">
                                    Done
                                </span>
                            @endif

                        </td>

                        <td>

                            <a href="{{ url('/rooms/booking/'.$item->id) }}"
                               class="btn btn-sm mb-1"
                               style="background:#7c5cff; color:#fff;">
                                <i class="fas fa-comments"></i> Chat
                            </a>

                            @if($item->status == 'scheduled')

                                <a href="{{ url('/reader/start/'.$item->id) }}"
                                class="btn btn-primary btn-sm">

                                    <i class="fas fa-play"></i>
                                    Proses
                                </a>

                            @elseif($item->status == 'processing')

                                <a href="{{ url('/reader/kirim-hasil/'.$item->id) }}"
                                class="btn btn-primary btn-sm">

                                    Kirim Hasil
                                </a>

                            @else
                                <span class="text-muted">-</span>
                            @endif

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="7" class="text-center">
                            Belum ada booking masuk
                        </td>
                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection