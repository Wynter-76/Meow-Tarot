@extends('layouts.master_cust')
@section('title','Tarot Offline Booking')
@section('content')

<style>
    /* 1. Background & Layout */
    .booking-page-wrapper {
        background-color: #050505;
        position: relative;
        overflow: hidden;
        padding-bottom: 100px;
        min-height: 100vh;
        color: #ccc;
        background-image: 
            radial-gradient(circle at 0% 0%, rgba(233, 30, 99, 0.1) 0%, transparent 50%),
            radial-gradient(circle at 100% 100%, rgba(212, 175, 55, 0.1) 0%, transparent 50%);
    }

    /* 2. Banner Header */
    .booking-banner {
        padding: 60px 0 40px;
        text-align: center;
    }

    .booking-banner img {
        width: 100%;
        max-width: 900px;
        border-radius: 20px;
        border: 2px solid #3d3020;
        padding: 10px;
        background: rgba(13, 13, 13, 0.5);
        outline: 1px solid rgba(212, 175, 55, 0.4);
        outline-offset: -18px;
        box-shadow: 0 20px 50px rgba(0,0,0,0.8);
    }

    /* 3. Glassmorphism Card */
    .booking-card-mystic {
        max-width: 750px;
        margin: 0 auto;
        background: rgba(10, 10, 10, 0.85);
        backdrop-filter: blur(15px);
        border: 1px solid #3d3020;
        outline: 1px solid rgba(212, 175, 55, 0.3);
        outline-offset: -12px;
        border-radius: 30px;
        padding: 50px 45px;
        box-shadow: 0 30px 70px rgba(0,0,0,1);
        position: relative;
        z-index: 10;
    }

    .section-title {
        color: #d4af37;
        font-family: 'Playfair Display', serif;
        letter-spacing: 4px;
        text-transform: uppercase;
        margin-bottom: 35px;
    }

    /* 4. Form Styling */
    .form-label {
        color: #d4af37;
        font-weight: 600;
        letter-spacing: 1px;
        margin-bottom: 10px;
        display: block;
    }

    .form-control, .form-select {
        background: rgba(255, 255, 255, 0.03) !important;
        border: 1px solid rgba(212, 175, 55, 0.2) !important;
        color: #fff !important;
        border-radius: 12px !important;
        padding: 12px 20px !important;
        margin-bottom: 20px;
    }

    .form-control:focus, .form-select:focus {
        border-color: #e91e63 !important;
        background: rgba(255, 255, 255, 0.08) !important;
        box-shadow: none !important;
    }

    /* Dropdown/select options */
    .form-select option {
        background: #111;
        color: #fff;
    }

    .form-select option:disabled {
        color: #555 !important;
        background: #222 !important;
    }

    /* Total & Submit */
    .price-display {
        font-family: 'Playfair Display', serif;
        color: #d4af37;
        font-size: 2rem;
        border-top: 1px solid #3d3020;
        padding-top: 25px;
        margin-top: 30px;
    }

    .btn-pink-mystic {
        background: linear-gradient(45deg, #e91e63, #c2185b);
        color: white;
        border: none;
        padding: 18px 40px;
        border-radius: 50px;
        font-weight: bold;
        letter-spacing: 2px;
        width: 100%;
        margin-top: 20px;
        transition: 0.3s;
        text-transform: uppercase;
    }

    .btn-pink-mystic:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(233, 30, 99, 0.4);
    }
</style>

<div class="booking-page-wrapper">
    
    {{-- Banner Section --}}
    <div class="booking-banner">
        <div class="container">
            <div class="wow fadeInDown">
                <img src="{{ asset('cust/image/tarotbg.jpg') }}" alt="Tarot Offline Session">
                <h1 class="section-title mt-5">TAROT OFFLINE READING</h1>
                <p style="color: #888; letter-spacing: 2px;">Bertemu langsung, selaraskan energi, temukan jawaban.</p>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="booking-card-mystic wow fadeInUp">
            
            <form action="/booking/store" method="POST">
                @csrf

                {{-- Hidden Inputs (Logika Backend Aman) --}}
                <input type="hidden" name="type" value="offline">
                <input type="hidden" name="package_id" value="{{ $package->id }}">
                <input type="hidden" id="base-price" value="{{ $package->price }}">
                
                {{-- Limit pertanyaan dari relasi paket untuk dibaca script JS --}}
                <input type="hidden" id="question-limit" value="{{ $package->question_limit ?? 0 }}">

                <div class="row">
                    <div class="col-md-12 text-center mb-4">
                        <h3 style="color: #d4af37; font-family: 'Playfair Display', serif;">Offline Appointment</h3>
                        <div style="width: 60px; height: 1px; background: #e91e63; margin: 10px auto;"></div>
                    </div>

                    {{-- Data Pribadi --}}
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control" placeholder="Siapa namamu?" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="nama@email.com" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">WhatsApp</label>
                            <input type="text" name="phone" class="form-control" placeholder="0812xxxx" required>
                        </div>
                    </div>

                    {{-- Penjadwalan Offline --}}
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Pilih Tanggal Pertemuan</label>
                            <input type="date" name="booking_date" id="booking_date" class="form-control" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Pilih Jam</label>
                            <select name="booking_time" id="booking_time" class="form-select" required>
                                <option value="" selected disabled>-- Pilih Tanggal Terlebih Dahulu --</option>
                                <option value="15:00">15:00</option>
                                <option value="16:00">16:00</option>
                                <option value="17:00">17:00</option>
                                <option value="18:00">18:00</option>
                                <option value="19:00">19:00</option>
                                <option value="20:00">20:00</option>
                                <option value="21:00">21:00</option>
                                <option value="22:00">22:00</option>
                                <option value="23:00">23:00</option>
                            </select>
                        </div>
                    </div>

                    {{-- Wrapper Tempat Munculnya Textarea Pertanyaan Otomatis --}}
                    <div class="col-md-12" id="question-wrapper"></div>

                    {{-- Total Harga & Submit --}}
                    <div class="col-md-12 text-center mt-4">
                        <div class="price-display">
                            Total: <span style="color: #fff;">Rp</span> 
                            <span id="total-price">{{ number_format($package->price, 0, ',', '.') }}</span>
                        </div>
                        <button type="submit" class="btn-pink-mystic">Konfirmasi Kedatangan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="{{ asset('cust/js/custom.js') }}"></script>

@endsection