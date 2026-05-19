@extends('layouts.master_cust')
@section('title', 'Riwayat Booking - Mystic Tarot')
@section('content')

<style>
    /* 1. Background & Layout (Senada dengan Booking Page) */
    .history-page-wrapper {
        background-color: #050505;
        position: relative;
        overflow: hidden;
        padding: 60px 0 100px;
        min-height: 100vh;
        color: #ccc;
        background-image: 
            radial-gradient(circle at 0% 0%, rgba(233, 30, 99, 0.08) 0%, transparent 50%),
            radial-gradient(circle at 100% 100%, rgba(212, 175, 55, 0.08) 0%, transparent 50%);
    }

    /* 2. Glassmorphism Card Wrapper */
    .history-card-mystic {
        background: rgba(10, 10, 10, 0.85);
        backdrop-filter: blur(15px);
        border: 1px solid #3d3020;
        outline: 1px solid rgba(212, 175, 55, 0.2);
        outline-offset: -10px;
        border-radius: 25px;
        padding: 40px;
        box-shadow: 0 30px 70px rgba(0,0,0,0.9);
    }

    .page-title {
        color: #d4af37;
        font-family: 'Playfair Display', serif;
        letter-spacing: 3px;
        text-transform: uppercase;
        font-weight: 700;
    }

    /* 3. Custom Mystic Table */
    .table-mystic {
        color: #ccc !important;
        vertical-align: middle;
        margin-top: 20px;
    }

    .table-mystic thead th {
        color: #d4af37 !important;
        border-bottom: 2px solid #3d3020 !important;
        letter-spacing: 1px;
        text-transform: uppercase;
        font-size: 0.9rem;
        padding: 15px;
    }

    .table-mystic tbody tr {
        border-bottom: 1px solid rgba(61, 48, 32, 0.5);
        transition: 0.3s;
    }

    .table-mystic tbody tr:hover {
        background: rgba(255, 255, 255, 0.02);
    }

    .table-mystic td {
        padding: 20px 15px;
    }

    /* 4. Badges / Status Badges */
    .badge-mystic {
        padding: 6px 14px;
        border-radius: 30px;
        font-size: 0.8rem;
        font-weight: 600;
        letter-spacing: 0.5px;
        display: inline-block;
        text-transform: uppercase;
    }

    /* Status Jadwal */
    .status-pending { background: rgba(255, 193, 7, 0.15); color: #ffc107; border: 1px solid rgba(255, 193, 7, 0.3); }
    .status-scheduled { background: rgba(0, 123, 255, 0.15); color: #007bff; border: 1px solid rgba(0, 123, 255, 0.3); }
    .status-done { background: rgba(40, 167, 69, 0.15); color: #28a745; border: 1px solid rgba(40, 167, 69, 0.3); }
    .status-cancelled { background: rgba(220, 53, 69, 0.15); color: #dc3545; border: 1px solid rgba(220, 53, 69, 0.3); }

    /* Status Payment */
    .pay-paid { color: #28a745; font-weight: bold; }
    .pay-pending { color: #ffc107; font-weight: bold; }
    .pay-failed { color: #dc3545; font-weight: bold; }

    /* 5. Result Box Layout */
    .result-box {
        background: rgba(255, 255, 255, 0.03);
        border: 1px dashed rgba(212, 175, 55, 0.3);
        padding: 12px;
        border-radius: 10px;
        color: #fff;
        font-style: italic;
        max-width: 300px;
        white-space: pre-line; /* Menjaga enter/spasi teks hasil reading */
    }
</style>

<div class="history-page-wrapper">
    <div class="container">
        <div class="history-card-mystic wow fadeInUp">
            
            <div class="d-flex justify-content-between align-items-center mb-4 pb-3" style="border-bottom: 1px solid #3d3020;">
                <div>
                    <h3 class="page-title m-0">Riwayat Sesi Tarot</h3>
                    <p class="text-muted small m-0 mt-1">Pantau jadwal pertemuan spiritual dan hasil pembacaan energimu.</p>
                </div>
                <a href="{{ url('/') }}" class="btn btn-outline-secondary btn-sm rounded-pill" style="color: #ccc; border-color: #3d3020;">
                    <i class="fas fa-arrow-left me-1"></i> Kembali ke Home
                </a>
            </div>

            <div class="table-responsive">
                <table class="table table-mystic text-nowrap">
                    <thead>
                        <tr>
                            <th>Detail Paket</th>
                            <th class="text-center">Jadwal Sesi</th>
                            <th class="text-center">Pembayaran</th>
                            <th class="text-center">Status Sesi</th>
                            <th>Hasil Pembacaan (Reading)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $item)
                            <tr>
                                <td>
                                    <strong style="color: #fff; font-size: 1.05rem;">{{ $item->package->name ?? '-' }}</strong>
                                    <div class="text-muted small mt-1">
                                        Tipe: <span class="badge bg-secondary text-uppercase" style="font-size: 0.7rem; padding: 3px 8px;">{{ $item->type }}</span>
                                    </div>
                                </td>

                                <td class="text-center">
                                    <div>{{ \Carbon\Carbon::parse($item->booking_date)->translatedFormat('d M Y') }}</div>
                                    <div class="text-muted small mt-1"><i class="far fa-clock me-1"></i>{{ $item->booking_time }} WIB</div>
                                </td>

                                <td class="text-center">
                                    @if($item->payment_status == 'paid')
                                        <span class="pay-paid"><i class="fas fa-check-circle me-1"></i>Lunas</span>
                                    @elseif($item->payment_status == 'pending')
                                        <span class="pay-pending"><i class="fas fa-hourglass-half me-1"></i>Pending</span>
                                    @else
                                        <span class="pay-failed"><i class="fas fa-times-circle me-1"></i>Gagal</span>
                                    @endif
                                </td>

                                <td class="text-center">
                                    @if($item->status == 'pending')
                                        <span class="badge-mystic status-pending">Menunggu</span>
                                    @elseif($item->status == 'scheduled')
                                        <span class="badge-mystic status-scheduled">Terjadwal</span>
                                    @elseif($item->status == 'done')
                                        <span class="badge-mystic status-done">Selesai</span>
                                    @elseif($item->status == 'cancelled')
                                        <span class="badge-mystic status-cancelled">Batal</span>
                                    @else
                                        <span class="badge-mystic status-pending">{{ $item->status }}</span>
                                    @endif
                                </td>

                                <td>
                                    @if($item->status == 'done')
                                        <div class="result-box">
                                            "{{ $item->reading_result ?? 'Hasil pembacaan sukses diselaraskan.' }}"
                                        </div>
                                    @else
                                        <span class="text-muted small"><i class="fas fa-lock me-1"></i>Menunggu sesi selesai...</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <div class="text-muted mb-3" style="font-size: 3rem;"><i class="fas fa-scroll"></i></div>
                                    <h5 class="text-muted">Belum ada riwayat booking</h5>
                                    <p class="text-muted small">Semua sesi tarot yang lo pesan nantinya bakal muncul di sini.</p>
                                    <a href="{{ url('/') }}" class="btn btn-sm btn-pink-mystic d-inline-block w-auto px-4 mt-2" style="border-radius: 20px;">
                                        Booking Sekarang
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

@endsection