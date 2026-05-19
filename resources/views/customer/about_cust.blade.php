@extends('layouts.master_cust')
@section('title','About Us')
@section('content')

<style>
    /* 1. Background & Base Layout */
    .about-page-wrapper {
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

    /* 2. Banner Section */
    .about-banner {
        padding: 80px 0 40px;
        text-align: center;
    }

    .about-banner img {
        width: 100%;
        max-width: 950px;
        height: auto;
        border-radius: 20px;
        border: 2px solid #3d3020;
        padding: 12px;
        background: rgba(13, 13, 13, 0.5);
        outline: 1px solid rgba(212, 175, 55, 0.4);
        outline-offset: -20px;
        box-shadow: 0 25px 60px rgba(0,0,0,0.9);
    }

    /* 3. Section Titles */
    .section-title {
        color: #d4af37;
        font-family: 'Playfair Display', serif;
        letter-spacing: 5px;
        margin-bottom: 30px;
        text-transform: uppercase;
        text-shadow: 0 0 10px rgba(212, 175, 55, 0.3);
    }

    /* 4. Value & Process Cards (Garis Tepi) */
    .info-card {
        background: rgba(15, 15, 15, 0.8);
        border: 1px solid #3d3020;
        outline: 1px solid rgba(212, 175, 55, 0.3);
        outline-offset: -10px;
        padding: 35px;
        border-radius: 25px;
        height: 100%;
        transition: 0.4s ease;
    }

    .info-card:hover {
        transform: translateY(-10px);
        outline-color: #e91e63;
        border-color: #e91e63;
    }

    .icon-circle {
        width: 60px;
        height: 60px;
        line-height: 60px;
        background: rgba(233, 30, 99, 0.1);
        border-radius: 50%;
        text-align: center;
        color: #e91e63;
        margin-bottom: 20px;
        border: 1px solid rgba(233, 30, 99, 0.3);
    }

    /* 5. Typography */
    .lead-text {
        font-size: 1.2rem;
        color: #fff;
        line-height: 1.8;
        font-style: italic;
        margin-bottom: 30px;
    }

    .cta-section {
        background: linear-gradient(rgba(0,0,0,0.8), rgba(0,0,0,0.8)), url('{{ asset("assets/img/pattern-bg.jpg") }}');
        border: 1px solid #3d3020;
        border-radius: 30px;
        padding: 60px;
        margin-top: 80px;
        text-align: center;
    }
</style>

<div class="about-page-wrapper">
    
    {{-- Hero Banner --}}
    <div class="about-banner">
        <div class="container">
            <div class="wow fadeInDown">
                <img src="{{ asset('cust/image/tarotpaket.jpg') }}" alt="Sacred Tarot Journey">
                <h1 class="section-title mt-5">THE MYSTIC STORY</h1>
                <p style="color: #888; letter-spacing: 3px; font-weight: 300;">Intuition. Wisdom. Enlightenment.</p>
            </div>
        </div>
    </div>

    <div class="container">
        
        {{-- Row 1: Who We Are --}}
        <div class="row align-items-center mb-5">
            <div class="col-md-6 wow fadeInLeft">
                <div style="padding: 15px; border: 1px solid #3d3020; border-radius: 20px; background: rgba(20,20,20,0.5);">
                    <img src="{{ asset('cust/image/palmreading.jpg') }}" class="img-responsive img-rounded" alt="Tarot Session">
                </div>
            </div>
            <div class="col-md-6 wow fadeInRight">
                <h2 class="section-title">Niat & Visi Kami</h2>
                <p class="lead-text">"Membantu Anda melihat melampaui batas pandangan mata, menuju kedalaman jiwa."</p>
                <p>Kami percaya bahwa setiap kartu tarot yang ditarik bukanlah sebuah kebetulan, melainkan cerminan dari energi semesta yang saat ini mengelilingi Anda. Misi kami adalah memberikan panduan spiritual yang jujur dan memberdayakan.</p>
            </div>
        </div>

        <hr style="border-color: #3d3020; margin: 80px 0;">

        {{-- Row 2: Our Core Values (Cards) --}}
        <h2 class="section-title text-center mb-5">Kenapa Memilih Kami?</h2>
        <div class="row">
            <div class="col-md-4 mb-4 wow fadeInUp" data-wow-delay="0.1s">
                <div class="info-card text-center">
                    <div class="icon-circle mx-auto"><i class="fa fa-eye"></i></div>
                    <h4>Kejujuran Mutlak</h4>
                    <p>Kami tidak memberikan harapan palsu. Apa yang tertulis di kartu, itulah yang kami sampaikan dengan penuh kebijaksanaan.</p>
                </div>
            </div>
            <div class="col-md-4 mb-4 wow fadeInUp" data-wow-delay="0.2s">
                <div class="info-card text-center">
                    <div class="icon-circle mx-auto"><i class="fa fa-shield"></i></div>
                    <h4>Privasi Suci</h4>
                    <p>Setiap curahan hati dan hasil bacaan dijaga kerahasiaannya seperti rahasia bintang-bintang di langit.</p>
                </div>
            </div>
            <div class="col-md-4 mb-4 wow fadeInUp" data-wow-delay="0.3s">
                <div class="info-card text-center">
                    <div class="icon-circle mx-auto"><i class="fa fa-heart"></i></div>
                    <h4>Empati Mendalam</h4>
                    <p>Kami mendengarkan dengan hati sebelum menerjemahkan dengan intuisi untuk solusi yang menenangkan.</p>
                </div>
            </div>
        </div>

        {{-- Row 3: Our Process --}}
        <div class="row mt-5 pt-5">
            <div class="col-md-12">
                <div class="info-card">
                    <div class="row">
                        <div class="col-md-7">
                            <h2 class="section-title">Bagaimana Kami Bekerja?</h2>
                            <ul style="list-style: none; padding-left: 0; color: #bbb;">
                                <li class="mb-3"><i class="fa fa-check-circle text-pink mr-2"></i> <strong>Penyelarasan Energi:</strong> Pembersihan ruang dan meditasi sebelum setiap sesi dimulai.</li>
                                <li class="mb-3"><i class="fa fa-check-circle text-pink mr-2"></i> <strong>Interpretasi Simbol:</strong> Menerjemahkan bahasa visual tarot ke dalam pesan yang aplikatif bagi hidup Anda.</li>
                                <li class="mb-3"><i class="fa fa-check-circle text-pink mr-2"></i> <strong>Saran Spiritual:</strong> Memberikan arahan praktis untuk menghadapi tantangan masa depan.</li>
                            </ul>
                        </div>
                        <div class="col-md-5 text-center">
                             <i class="fa fa-magic" style="font-size: 10rem; color: rgba(212, 175, 55, 0.1); margin-top: 20px;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Row 4: Call to Action --}}
        <div class="cta-section wow zoomIn">
            <h2 style="color: #d4af37; font-family: 'Playfair Display', serif;">Siap Menemukan Jawaban?</h2>
            <p class="mb-4">Jangan biarkan keraguan menghalangi langkah Anda. Semesta punya pesan untuk Anda hari ini.</p>
            <a href="{{ url('/service') }}" class="btn" style="background: linear-gradient(45deg, #e91e63, #c2185b); color: white; padding: 15px 40px; border-radius: 50px; font-weight: bold; letter-spacing: 2px;"> MULAI PEMBACAAN </a>
        </div>

    </div>
</div>

@endsection