@extends('layouts.dashboard')

@section('title','Riwayat Booking')

@section('content')

<!-- Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Riwayat Booking</h1>
</div>

<!-- Card -->
<div class="card shadow mb-4">

    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            Booking Selesai / Diproses
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
                        <th>Status</th>
                        <th>Hasil</th>
                    </tr>
                </thead>

                <tbody>

                @forelse($riwayat as $item)

                    <tr>

                        <td>{{ $loop->iteration }}</td>

                        <td>{{ $item->name }}</td>

                        <td>{{ $item->type}}</td>

                        <td>{{ $item->package->name ?? '-' }}</td>

                        <td>{{ $item->booking_date }}</td>

                        <td>

                            @if($item->status == 'done')
                                <span class="badge badge-success">
                                    Done
                                </span>
                            @else
                                <span class="badge badge-info">
                                    Process
                                </span>
                            @endif

                        </td>

                        <td>

                            <a href="{{ url('/reader/detail/'.$item->id) }}"
                               class="btn btn-primary btn-sm">

                                <i class="fas fa-eye"></i>
                                Detail
                            </a>

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="6" class="text-center">
                            Belum ada riwayat
                        </td>
                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection