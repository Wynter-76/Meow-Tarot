@extends('layouts.master_cust')
@section('title','Palm Reading Offline')
@section('content')

<style>
    /* Pakai Style yang sama dengan Online untuk konsistensi */
    .booking-page-wrapper {
        background-color: #050505; position: relative; overflow: hidden; padding-bottom: 100px;
        min-height: 100vh; color: #ccc;
        background-image: radial-gradient(circle at 0% 0%, rgba(233, 30, 99, 0.1) 0%, transparent 50%),
                          radial-gradient(circle at 100% 100%, rgba(212, 175, 55, 0.1) 0%, transparent 50%);
    }

    .booking-banner { padding: 60px 0 40px; text-align: center; }
    .booking-banner img {
        width: 100%; max-width: 900px; border-radius: 20px; border: 2px solid #3d3020;
        padding: 10px; background: rgba(13, 13, 13, 0.5); outline: 1px solid rgba(212, 175, 55, 0.4);
        outline-offset: -18px; box-shadow: 0 20px 50px rgba(0,0,0,0.8);
    }

    .booking-card-mystic {
        max-width: 750px; margin: 0 auto; background: rgba(10, 10, 10, 0.85);
        backdrop-filter: blur(15px); border: 1px solid #3d3020; outline: 1px solid rgba(212, 175, 55, 0.3);
        outline-offset: -12px; border-radius: 30px; padding: 50px 45px;
    }

    .section-title { color: #d4af37; font-family: 'Playfair Display', serif; letter-spacing: 4px; text-transform: uppercase; margin-bottom: 35px; }
    .form-label { color: #d4af37; font-weight: 600; margin-bottom: 10px; display: block; }
    
    .form-control, .form-select {
        background: rgba(255, 255, 255, 0.03) !important; border: 1px solid rgba(212, 175, 55, 0.2) !important;
        color: #fff !important; border-radius: 12px !important; padding: 12px 20px !important; margin-bottom: 20px;
    }

    .form-select option { background: #111; color: #fff; }

    .btn-pink-mystic {
        background: linear-gradient(45deg, #e91e63, #c2185b); color: white; border: none;
        padding: 18px 40px; border-radius: 50px; font-weight: bold; width: 100%; text-transform: uppercase;
    }
</style>

<div class="booking-page-wrapper">
    <div class="booking-banner">
        <div class="container">
            <div class="wow fadeInDown">
                <img src="{{ asset('cust/image/palreading.jpg') }}" alt="Palm Reading Offline">
                <h1 class="section-title mt-5">PALM READING OFFLINE</h1>
                <p style="color: #888; letter-spacing: 2px;">Bertemu langsung untuk pembacaan energi yang lebih dalam.</p>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="booking-card-mystic wow fadeInUp">
            <form action="/booking/store" method="POST">
                @csrf
                <input type="hidden" name="type" value="offline">
                <input type="hidden" name="package_id" value="{{ $package->id }}">
                <input type="hidden" id="base-price" value="{{ $package->price }}">

                <div class="mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="name" class="form-control" placeholder="Siapa namamu?" required>
                </div>

                <div class="row">
                    <div class="col-md-6"><label class="form-label">Email</label><input type="email" name="email" class="form-control" required></div>
                    <div class="col-md-6"><label class="form-label">WhatsApp</label><input type="text" name="phone" class="form-control" required></div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <label class="form-label">Pilih Tanggal</label>
                        <input type="date" name="booking_date" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Pilih Jam</label>
                        <select name="booking_time" class="form-select">
                            @for ($i = 15; $i <= 23; $i++)
                                <option>{{ $i }}:00</option>
                            @endfor
                        </select>
                    </div>
                </div>

                <div class="text-center mt-5" style="border-top: 1px solid #3d3020; padding-top: 25px;">
                    <h4 style="color: #d4af37; font-family: 'Playfair Display', serif;">Total: Rp <span id="total-price">{{ number_format($package->price,0,',','.') }}</span></h4>
                    <button type="submit" class="btn-pink-mystic">BOOK MY SESSION</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection