@extends('layouts.master_cust')
@section('title','Tarot Booking Form')
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

    /* 2. Banner Header (Logo Gaban Out, Bingkai In) */
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
        max-width: 700px;
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

    .form-control {
        background: rgba(255, 255, 255, 0.03) !important;
        border: 1px solid rgba(212, 175, 55, 0.2) !important;
        color: #fff !important;
        border-radius: 12px !important;
        padding: 12px 20px !important;
        margin-bottom: 20px;
    }

    .form-control:focus {
        border-color: #e91e63 !important;
        background: rgba(255, 255, 255, 0.08) !important;
        box-shadow: none !important;
    }

    /* Checkbox/Addon Styling */
    .form-check {
        background: rgba(255, 255, 255, 0.02);
        padding: 15px 15px 15px 40px;
        border-radius: 12px;
        border: 1px solid rgba(212, 175, 55, 0.1);
        margin-bottom: 10px;
        transition: 0.3s;
    }

    .form-check:hover {
        border-color: #e91e63;
        background: rgba(233, 30, 99, 0.05);
    }

    .form-check-input:checked {
        background-color: #e91e63;
        border-color: #e91e63;
    }

    /* Total & Submit */
    .price-display {
        font-family: 'Playfair Display', serif;
        color: #d4af37;
        font-size: 1.8rem;
        border-top: 1px solid #3d3020;
        padding-top: 20px;
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
                <img src="{{ asset('cust/image/tarotbg.jpg') }}" alt="Tarot Reading Session">
                <h1 class="section-title mt-5">TAROT ONLINE READING</h1>
                <p style="color: #888; letter-spacing: 2px;">Persiapkan pertanyaan Anda, biarkan semesta menjawab.</p>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="booking-card-mystic wow fadeInUp">
            
            <form action="/booking/store" method="POST">
                @csrf

                {{-- Hidden Inputs (LOGIKA TETEP SAMA) --}}
                <input type="hidden" name="type" value="online">
                <input type="hidden" name="package_id" value="{{ $package->id }}">
                <input type="hidden" id="question-limit" value="{{ $package->question_limit }}">
                <input type="hidden" id="base-price" value="{{ $package->price }}">

                <div class="row">
                    <div class="col-md-12 text-center mb-4">
                        <h3 style="color: #d4af37; font-family: 'Playfair Display', serif;">Session Details</h3>
                        <div style="width: 50px; height: 1px; background: #e91e63; margin: 10px auto;"></div>
                    </div>

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

                    <div class="col-md-12 mt-3">
                        <label class="form-label">Pertanyaan Anda</label>
                        <p style="font-size: 0.85rem; color: #666; margin-top: -10px; margin-bottom: 15px;">
                            Sesuai paket: {{ $package->question_limit }} Pertanyaan
                        </p>
                        <div id="question-wrapper"></div>
                    </div>

                    <div class="col-md-12 mt-4">
                        <label class="form-label">Layanan Tambahan (Add On)</label>
                        <div class="row">
                            @foreach($addons as $addon)
                                <div class="col-md-12">
                                    <div class="form-check">
                                        <input 
                                            type="checkbox"
                                            name="addons[]"
                                            value="{{ $addon->id }}"
                                            class="form-check-input addon"
                                            data-price="{{ $addon->price }}"
                                            id="addon-{{ $addon->id }}"
                                        >
                                        <label class="form-check-label" for="addon-{{ $addon->id }}" style="color: #ccc; cursor: pointer;">
                                            {{ $addon->name }} <span style="color: #d4af37; margin-left: 10px;">(+Rp {{ number_format($addon->price,0,',','.') }})</span>
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="col-md-12 text-center">
                        <div class="price-display">
                            Total: <span style="color: #fff;">Rp</span> 
                            <span id="total-price">{{ number_format($package->price,0,',','.') }}</span>
                        </div>
                        <button type="submit" class="btn-pink-mystic">Pesan Sesi Sekarang</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection