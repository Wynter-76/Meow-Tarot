@extends('layouts.master_cust')

@section('content')

<div class="container mt-5">
    <h3>Riwayat Booking</h3>

    <table class="table">
        <thead>
            <tr>
                <th>Paket</th>
                <th>Status</th>
                <th>Hasil</th>
            </tr>
        </thead>

        <tbody>
        @foreach($data as $item)
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
        @endforeach
        </tbody>
    </table>
</div>

@endsection