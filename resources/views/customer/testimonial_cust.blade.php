@extends('layouts.master_cust')
@section('title','Testimonial')
@section('content')

<style>
    /* 1. Background Utama */
    .testimonial-page {
        background-color: #050505;
        position: relative;
        overflow: hidden;
        padding: 80px 0 100px; /* Jarak atas bawah lebih lega */
        min-height: 100vh; 
        background-image: 
            radial-gradient(circle at 0% 0%, rgba(233, 30, 99, 0.08) 0%, transparent 50%),
            radial-gradient(circle at 100% 100%, rgba(212, 175, 55, 0.08) 0%, transparent 50%),
            url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='200' viewBox='0 0 200 200'%3E%3Ccircle cx='20' cy='30' r='0.6' fill='%23d4af37' opacity='0.4'/%3E%3Ccircle cx='150' cy='10' r='0.4' fill='%23fff' opacity='0.2'/%3E%3Ccircle cx='80' cy='160' r='0.7' fill='%23fff' opacity='0.3'/%3E%3Ccircle cx='180' cy='130' r='0.5' fill='%23d4af37' opacity='0.4'/%3E%3C/svg%3E");
    }

    /* Dekorasi Geometris di Background */
    .testimonial-page::before {
        content: "";
        position: absolute;
        top: 10%; left: 50%; width: 100%; max-width: 900px; height: 900px; transform: translateX(-50%);
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Cpath d='M50 5 L90 25 L90 75 L50 95 L10 75 L10 25 Z' fill='none' stroke='%23d4af37' stroke-width='0.1' opacity='0.1'/%3E%3Ccircle cx='50' cy='50' r='45' fill='none' stroke='%23d4af37' stroke-width='0.05' opacity='0.1'/%3E%3C/svg%3E");
        background-repeat: no-repeat; background-size: contain; z-index: 0; pointer-events: none;
    }

    /* 2. Form Testimoni - Fokus Utama */
    .form-wrapper {
        max-width: 650px;
        margin: 0 auto 80px;
        background: rgba(10, 10, 10, 0.9);
        backdrop-filter: blur(15px);
        border: 1px solid #3d3020;
        outline: 1px solid rgba(212, 175, 55, 0.5);
        outline-offset: -12px;
        border-radius: 30px;
        padding: 55px 45px;
        position: relative;
        z-index: 10;
        box-shadow: 0 30px 70px rgba(0,0,0,1);
    }

    .form-wrapper:hover {
        outline-color: #e91e63; /* Berubah pink saat hover */
        transition: 0.5s;
    }

    .form-control {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(212, 175, 55, 0.2);
        color: #fff;
        border-radius: 15px;
        padding: 20px;
        font-style: italic;
    }

    .form-control:focus {
        background: rgba(255, 255, 255, 0.08);
        border-color: #d4af37;
        color: #fff;
        box-shadow: none;
    }

    .btn-pink-celestial {
        background: linear-gradient(45deg, #e91e63, #c2185b);
        border: none;
        border-radius: 12px;
        padding: 15px 40px;
        font-weight: bold;
        color: white;
        letter-spacing: 2px;
        transition: 0.3s;
        width: 100%;
        max-width: 250px;
    }

    .btn-pink-celestial:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(233, 30, 99, 0.3);
    }

    /* 3. List Testimoni */
    .section-title {
        color: #d4af37;
        font-family: 'Playfair Display', serif;
        text-align: center;
        letter-spacing: 5px;
        margin-bottom: 50px;
        text-transform: uppercase;
    }

    .testimonial-card {
        background: rgba(13, 13, 13, 0.95);
        border: 1px solid #3d3020;
        border-radius: 25px;
        padding: 30px;
        height: 100%;
        transition: 0.4s;
        position: relative;
    }

    .testimonial-card:hover {
        border-color: #d4af37;
        transform: translateY(-8px);
        background: rgba(18, 18, 18, 1);
    }
</style>

<div class="testimonial-page">
    <div class="container">
        
        {{-- Judul Halaman --}}
        <div class="text-center mb-5 wow fadeInDown">
            <h2 style="color: #d4af37; font-family: 'Playfair Display', serif; letter-spacing: 8px;">TESTIMONIALS</h2>
            <div style="width: 60px; height: 2px; background: #e91e63; margin: 15px auto;"></div>
        </div>

        {{-- Session Alert --}}
        @if(session('success'))
            <div class="alert alert-success text-center mb-5" style="background: rgba(40, 167, 69, 0.2); border: 1px solid #28a745; color: #fff; border-radius: 15px;">
                {{ session('success') }}
            </div>
        @endif

        {{-- Form Input (Langsung Tampil) --}}
        <div class="form-wrapper wow fadeInUp">
            <div class="text-center mb-4">
                <h4 style="color: #d4af37; font-family: 'Playfair Display', serif; letter-spacing: 3px;">WRITE YOUR JOURNEY</h4>
                <p style="color: #666; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 1px;">Share the wisdom you've found</p>
            </div>
            
            <form action="{{ url('/testimonial/store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <textarea name="message" class="form-control" rows="5" placeholder="Describe your experience with the cards..." required></textarea>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn-pink-celestial">SEND TESTIMONIAL</button>
                </div>
            </form>
        </div>

        {{-- Garis Pemisah --}}
        <div style="width: 100px; height: 1px; background: #3d3020; margin: 0 auto 80px;"></div>

        {{-- Voices of Seekers --}}
        <h2 class="section-title">VOICES OF THE SEEKERS</h2>
        
        <div class="row">
            @forelse($testimonials as $item)
                <div class="col-md-4 mb-4 wow fadeInUp">
                    <div class="testimonial-card">
                        <i class="fa fa-quote-left" style="color: #e91e63; opacity: 0.4; font-size: 1.4rem; margin-bottom: 20px;"></i>
                        <h5 style="color: #d4af37; font-family: 'Playfair Display', serif; font-weight: bold; letter-spacing: 1px;">
                            {{ strtoupper($item->user->name ?? 'Seeker') }}
                        </h5>
                        <p style="color: #ccc; line-height: 1.7; font-style: italic; font-size: 0.95rem;">
                            "{{ $item->message }}"
                        </p>
                    </div>
                </div>
            @empty
                <div class="col-md-12 text-center">
                    <p style="color: #555; font-style: italic;">No testimonials yet. Be the first to share your light.</p>
                </div>
            @endforelse
        </div>

    </div> {{-- End Container --}}
</div> {{-- End Page Wrapper --}}

@endsection