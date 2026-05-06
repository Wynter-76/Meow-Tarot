@extends('layouts.dashboard')

@section('title','Kirim Hasil')

@section('content')

<!-- Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Kirim Hasil Pembacaan</h1>
</div>

<!-- Card -->
<div class="card shadow mb-4">

    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            Form Hasil Reading
        </h6>
    </div>

    <div class="card-body">
        <form action="{{ url('/reader/hasil/'.$booking->id) }}" method="POST">
            @csrf

            <!-- Customer -->
            <div class="form-group">
                <label>Nama Customer</label>
                <input type="text"
                       class="form-control"
                       value="{{ $booking->name }}"
                       readonly>
            </div>

            <!-- Email -->
            <div class="form-group">
                <label>Email</label>
                <input type="text"
                       class="form-control"
                       value="{{ $booking->email }}"
                       readonly>
            </div>

            <!-- Paket -->
            <div class="form-group">
                <label>Paket</label>
                <input type="text"
                       class="form-control"
                       value="{{ $booking->package->name ?? '-' }}"
                       readonly>
            </div>

            <!-- Hasil -->
            <div class="form-group">
                <label>Isi Hasil Reading</label>

                <textarea name="hasil"
                          rows="8"
                          class="form-control"
                          placeholder="Tulis hasil tarot / palm reading..."
                          required></textarea>
            </div>

            <!-- Tombol -->
            <button class="btn btn-primary">
                <i class="fas fa-paper-plane"></i>
                Kirim Hasil
            </button>

            <a href="{{ url('/reader/booking') }}"
               class="btn btn-secondary">

                Kembali
            </a>

        </form>

    </div>

</div>

@endsection