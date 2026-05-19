@extends('layouts.dashboard')

@section('title','Kirim Hasil')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Kirim Hasil Pembacaan</h1>
</div>

<div class="card shadow mb-4">

    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            Form Hasil Reading
        </h6>
    </div>

    <div class="card-body">
        <form action="{{ url('/reader/hasil/'.$booking->id) }}" method="POST">
            @csrf

            <div class="row">
                <div class="col-md-5">
                    <div class="form-group">
                        <label class="font-weight-bold">Nama Customer</label>
                        <input type="text" class="form-control" value="{{ $booking->name }}" readonly>
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold">Email</label>
                        <input type="text" class="form-control" value="{{ $booking->email }}" readonly>
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold">Paket & Tipe</label>
                        <input type="text" class="form-control text-uppercase" value="{{ $booking->package->name ?? '-' }} ({{ $booking->type }})" readonly>
                    </div>
                </div>

                <div class="col-md-7">
                    @if($booking->type == 'online')
                        
                        <div class="form-group">
                            <label class="font-weight-bold text-danger">
                                <i class="fas fa-question-circle"></i> Daftar Pertanyaan Customer
                            </label>
                            <div class="p-3 bg-light rounded border mb-3" style="max-height: 160px; overflow-y: auto;">
                                @forelse($booking->questions as $index => $q)
                                    <div class="alert alert-info mb-2 py-2 px-3 shadow-sm">
                                        <strong class="d-block small text-secondary">Pertanyaan {{ $index + 1 }}:</strong>
                                        <span class="text-dark font-italic">"{{ $q->question }}"</span>
                                    </div>
                                @empty
                                    <p class="small text-muted m-0 text-center">Tidak ada pertanyaan khusus.</p>
                                @endforelse
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold text-purple" style="color: #6f42c1;">
                                <i class="fas fa-image"></i> Lampiran Foto Telapak Tangan / File
                            </label>

                            <div class="p-3 bg-light rounded border">
                                <div class="row">
                                    {{-- Kita cek apakah ada file/foto yang diupload customer --}}
                                    @if($booking->files && $booking->files->count() > 0)
                                        @foreach($booking->files as $file)
                                            <div class="col-6 col-sm-4 mb-2">
                                                <div class="card bg-dark text-white text-center shadow-sm trigger-zoom" 
                                                     style="cursor: pointer;" 
                                                     data-toggle="modal" 
                                                     data-target="#imageModal" 
                                                     data-src="{{ asset('storage/' . $file->file_path) }}">
                                                    
                                                    {{-- Thumbnail Foto --}}
                                                    <img src="{{ asset('storage/' . $file->file_path) }}"
                                                         class="card-img-top" 
                                                         alt="Foto Tangan"
                                                         style="height: 100px; object-fit: cover; border-bottom: 1px solid #444;">
                                                    
                                                    <div class="card-body p-1">
                                                        <span class="small" style="font-size: 0.75rem;"><i class="fas fa-search-plus"></i> Lihat Foto</span>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="col-12 text-center py-2">
                                            <span class="text-muted small"><i class="fas fa-exclamation-triangle"></i> Customer belum/tidak mengunggah foto.</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                    @else
                        <div class="alert alert-warning text-center py-5">
                            <i class="fas fa-users fa-2x mb-2"></i>
                            <h6>Sesi Tatap Muka (Offline)</h6>
                            <p class="small m-0 text-muted">Pertanyaan diajukan dan foto tangan dianalisis langsung saat pertemuan fisik.</p>
                        </div>
                    @endif
                </div>
            </div>

            <hr class="my-4">

            <div class="form-group">
                <label class="font-weight-bold text-success">
                    <i class="fas fa-edit"></i> Isi Hasil Reading
                </label>
                <textarea name="hasil" rows="8" class="form-control" placeholder="Tulis penjabaran hasil tarot / palm reading secara detail di sini..." required></textarea>
            </div>

            <button class="btn btn-primary px-4 shadow-sm">
                <i class="fas fa-paper-plane"></i> Kirim Hasil
            </button>
            <a href="{{ url('/reader/bookingmasuk') }}" class="btn btn-secondary px-4">Kembali</a>
        </form>
    </div>
</div>

<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content bg-dark border-0">
            <div class="modal-header border-0 p-2">
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center p-0">
                <img src="" id="modalImagePreview" class="img-fluid rounded-bottom" style="max-height: 80vh; object-fit: contain;">
            </div>
        </div>
    </div>
</div>

{{-- Script jQuery Ringkas Untuk Mengisi Sumber Gambar ke dalam Modal Zoom --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('.trigger-zoom').on('click', function() {
            var imageSrc = $(this).data('src');
            $('#modalImagePreview').attr('src', imageSrc);
        });
    });
</script>

@endsection