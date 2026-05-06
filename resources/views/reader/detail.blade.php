@extends('layouts.dashboard')

@section('title','Detail Booking')

@section('content')

<div class="card shadow p-4">

    <h4 class="mb-3">Detail Booking</h4>

    <p><b>Nama:</b> {{ $booking->name }}</p>
    <p><b>Email:</b> {{ $booking->email }}</p>
    <p><b>Paket:</b> {{ $booking->package->name ?? '-' }}</p>
    <p><b>Tipe:</b> {{ $booking->type}}</p>
    <p><b>Status:</b> {{ $booking->status }}</p>

    <hr>

    {{-- ADDON --}}
    <h5>Add On</h5>
    @if($booking->addons->count())
        <ul>
            @foreach($booking->addons as $addon)
                <li>{{ $addon->name }}</li>
            @endforeach
        </ul>
    @else
        <span class="text-muted">Tidak ada addon</span>
    @endif

    <hr>

    {{-- PERTANYAAN TAROT --}}
    <h5>Pertanyaan</h5>
    @if($booking->questions->count())
        <ul>
            @foreach($booking->questions as $q)
                <li>{{ $q->question }}</li>
            @endforeach
        </ul>
    @endif

    <hr>

    {{-- FILE PALM --}}
    @if($booking->file)
        <h5>Foto Tangan</h5>
        <img src="{{ asset('storage/'.$booking->file->file_path) }}"
             width="200">
    @endif

    <hr>

    {{-- HASIL --}}
    <h5>Hasil Reading</h5>
    @if($booking->reading_result)
        <p>{{ $booking->reading_result }}</p>
    @else
        <span class="text-muted">Belum ada hasil</span>
    @endif

    <a href="{{ url('/reader/riwayat') }}" class="btn btn-secondary mt-3">
        Kembali
    </a>

</div>

@endsection