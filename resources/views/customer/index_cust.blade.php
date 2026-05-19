@extends('layouts.master_cust')
@section('title','Meow Tarot')
@section('content')
<style>
    /* Global Home Styling */
    body { background-color: #050505; }

    .cover-section, .purilfy-section, .benefit-section, .message-section, .client-section, .table-section {
        background-color: #050505;
        position: relative;
        overflow: hidden;
        color: #fff;
        /* Efek Titik Bintang Kesukaan Lu */
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='200' viewBox='0 0 200 200'%3E%3Ccircle cx='20' cy='30' r='0.6' fill='%23d4af37' opacity='0.4'/%3E%3Ccircle cx='150' cy='10' r='0.4' fill='%23fff' opacity='0.2'/%3E%3Ccircle cx='80' cy='160' r='0.7' fill='%23fff' opacity='0.3'/%3E%3Ccircle cx='180' cy='130' r='0.5' fill='%23d4af37' opacity='0.4'/%3E%3C/svg%3E");
    }

    /* Hero Section */
    .cover-section {
        padding: 120px 0;
        border-bottom: 1px solid rgba(212, 175, 55, 0.1);
    }
    .slider-item h2 {
        color: #d4af37;
        font-family: 'Playfair Display', serif;
        font-size: 3.5rem;
        font-weight: 900;
        letter-spacing: 8px;
        margin-top: 20px;
    }

    /* Typography & Section Titles */
    .section-title {
        color: #d4af37;
        font-family: 'Playfair Display', serif;
        font-weight: 800;
        letter-spacing: 4px;
        text-transform: uppercase;
        margin-bottom: 30px;
    }

    /* Service & Benefit Items (Bikin Mungil & Estetik) */
    .benefit-item {
        padding: 30px 15px;
        transition: 0.4s;
    }
    .benefit-item img {
        border-radius: 50%;
        border: 2px solid #3d3020;
        padding: 10px;
        transition: 0.4s;
        margin: 0 auto 20px;
    }
    .benefit-item:hover img {
        border-color: #d4af37;
        box-shadow: 0 0 20px rgba(212, 175, 55, 0.2);
    }
    .benefit-item h2 {
        color: #fff;
        font-size: 1.4rem;
        font-weight: 700;
    }

    /* Client & Testimonial Card */
    .client-item {
        background: rgba(20, 20, 20, 0.6);
        border: 1px solid #3d3020;
        padding: 30px;
        border-radius: 15px;
        position: relative;
    }
    .client-content i { color: #e91e63; font-size: 1.5rem; margin-bottom: 15px; }

    /* Pricing Table (Sesuai tema Catalog kemarin) */
    .table-item {
        background: #0d0d0d;
        border: 1px solid #3d3020;
        padding: 40px 20px;
        border-radius: 15px;
        position: relative;
        overflow: hidden;
        transition: 0.4s;
    }
    .table-item::after {
        content: "";
        position: absolute;
        inset: 0;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 150'%3E%3Ccircle cx='50' cy='75' r='30' fill='none' stroke='%23d4af37' stroke-width='0.2' opacity='0.2'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: center;
        z-index: 0;
    }
    .table-item:hover { border-color: #d4af37; transform: translateY(-10px); }
    .table-item h3 { color: #d4af37; font-weight: 800; z-index: 1; position: relative; }
    .table-item ul { list-style: none; padding: 0; margin: 20px 0; color: #ccc; z-index: 1; position: relative; }
    
    .table-item a {
        background: linear-gradient(45deg, #e91e63, #c2185b);
        color: #fff;
        padding: 10px 25px;
        border-radius: 5px;
        text-decoration: none;
        font-weight: bold;
        display: inline-block;
        z-index: 1;
        position: relative;
    }
.benefit-section, .client-section, .table-section {
        background-color: #050505;
        position: relative;
        overflow: hidden;
        /* Layer: Nebula Glow + Stars (Bintik-bintik kesukaan lo) */
        background-image: 
            radial-gradient(circle at 10% 10%, rgba(233, 30, 99, 0.05) 0%, transparent 40%),
            radial-gradient(circle at 90% 80%, rgba(212, 175, 55, 0.05) 0%, transparent 40%),
            url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='200' viewBox='0 0 200 200'%3E%3Ccircle cx='20' cy='30' r='0.6' fill='%23d4af37' opacity='0.4'/%3E%3Ccircle cx='150' cy='10' r='0.4' fill='%23fff' opacity='0.2'/%3E%3Ccircle cx='80' cy='160' r='0.7' fill='%23fff' opacity='0.3'/%3E%3Ccircle cx='180' cy='130' r='0.5' fill='%23d4af37' opacity='0.4'/%3E%3C/svg%3E");
    }

    /* Efek Zodiak Raksasa di Belakang Kotak (Sama kek Katalog) */
    .benefit-section::before {
        content: "";
        position: absolute;
        top: 50%; left: 50%;
        width: 800px; height: 800px;
        transform: translate(-50%, -50%);
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 200 200'%3E%3Ccircle cx='100' cy='100' r='90' fill='none' stroke='%23d4af37' stroke-width='0.2' opacity='0.08'/%3E%3Ccircle cx='100' cy='100' r='70' fill='none' stroke='%23d4af37' stroke-width='0.1' opacity='0.08'/%3E%3Cpath d='M100 10 L100 190 M10 100 L190 100 M36.4 36.4 L163.6 163.6' stroke='%23d4af37' stroke-width='0.1' opacity='0.1'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-size: contain;
        z-index: 0;
        animation: slowRotate 100s linear infinite; /* Putar pelan banget */
    }

    @keyframes slowRotate {
        from { transform: translate(-50%, -50%) rotate(0deg); }
        to { transform: translate(-50%, -50%) rotate(360deg); }
    }

    /* Update Kotak Layanan (Benefit Item) agar ada Sacred Geometry-nya */
    .benefit-item {
        background: rgba(13, 13, 13, 0.9);
        border: 1px solid #3d3020;
        border-radius: 25px; /* Tetap smooth sesuai request terakhir */
        padding: 45px 35px;
        position: relative;
        z-index: 1;
        overflow: hidden;
        transition: 0.4s ease;
    }

    /* Efek Sacred Geometry di dalam Kotak */
    .benefit-item::after {
        content: "";
        position: absolute;
        inset: 0;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Ccircle cx='50' cy='50' r='40' fill='none' stroke='%23d4af37' stroke-width='0.2' opacity='0.15'/%3E%3Cpath d='M50 10 L90 50 L50 90 L10 50 Z' fill='none' stroke='%23d4af37' stroke-width='0.2' opacity='0.1'/%3E%3C/svg%3E");
        background-position: center;
        background-repeat: no-repeat;
        background-size: 150px;
        z-index: -1;
        opacity: 0.5;
    }

    .benefit-item:hover {
        border-color: #d4af37;
        transform: translateY(-12px);
        box-shadow: 0 15px 40px rgba(0,0,0,0.8);
    }

    /* Judul Section dengan Glow Emas */
    .section-title {
        color: #d4af37;
        text-shadow: 0 0 15px rgba(212, 175, 55, 0.3);
        font-family: 'Playfair Display', serif;
        letter-spacing: 5px;
    }

        /* Daily Card Section */
    .daily-section {
        background-color: #050505;
        background-image:
            radial-gradient(circle at 50% 50%, rgba(212,175,55,0.04) 0%, transparent 60%),
            url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='200' viewBox='0 0 200 200'%3E%3Ccircle cx='20' cy='30' r='0.6' fill='%23d4af37' opacity='0.4'/%3E%3Ccircle cx='150' cy='10' r='0.4' fill='%23fff' opacity='0.2'/%3E%3Ccircle cx='80' cy='160' r='0.7' fill='%23fff' opacity='0.3'/%3E%3Ccircle cx='180' cy='130' r='0.5' fill='%23d4af37' opacity='0.4'/%3E%3C/svg%3E");
    }

    .daily-card-flip {
        animation: cardFloat 5s ease-in-out infinite;
    }

    @keyframes cardFloat {
        0%, 100% { transform: translateY(0px) rotate(-2deg); }
        50%       { transform: translateY(-15px) rotate(2deg); }
    }

    .daily-info {
        background: rgba(13,13,13,0.8);
        border: 1px solid #3d3020;
        border-radius: 20px;
        padding: 40px;
        position: relative;
        overflow: hidden;
    }

    .daily-info::before {
        content: "";
        position: absolute;
        top: -30px; right: -30px;
        width: 150px; height: 150px;
        background: radial-gradient(circle, rgba(212,175,55,0.06) 0%, transparent 70%);
        border-radius: 50%;
    }
</style>
<div class="cover-section" id="top-button">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center wow fadeInDown animated">
                <div class="slider-item">
                    <img src="{{asset('cust/image/logotarot.png')}}" width="177" height="144" style="filter: drop-shadow(0 0 10px rgba(212,175,55,0.3));"> 
                    <h2>GET YOUR INSIGHT</h2>
                    <p style="letter-spacing: 3px; color: #888;">Begin your Tarot reading journey with us.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="purilfy-section" style="padding: 60px 0; border-bottom: 1px solid rgba(233, 30, 99, 0.1);">
    <div class="container text-center">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="purifliy-item wow fadeInDown animated">
                    <h3 style="font-weight: 300; letter-spacing: 5px;">HAVING QUESTIONS ABOUT YOUR LIFE?</h3>
                    <p class="text-muted">Clear all the doubts in your mind with our professional readers.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="benefit-section" style="padding: 120px 0;">
    <div class="container">
        <div class="row mb-5 text-center">
            <div class="col-md-12">
                <h2 class="section-title wow fadeInDown">OUR SERVICES</h2>
                <div style="width: 60px; height: 2px; background: #e91e63; margin: 20px auto 50px;"></div>
            </div>
        </div>
        
        <div class="row g-5"> {{-- Jarak antar kotak lega --}}
            @php
                $homeServices = [
                    ['title' => 'Tarot Reading', 'img' => 'tarotpaket.jpg', 'desc' => 'Explore your destiny through sacred cards.', 'delay' => '0.2s'],
                    ['title' => 'Palm Reading', 'img' => 'palmreading.jpg', 'desc' => 'Read the secrets written in your hands.', 'delay' => '0.4s'],
                    ['title' => 'Interactive Chat', 'img' => 'chat.jpg', 'desc' => 'Private spiritual guidance via chat.', 'delay' => '0.6s'],
                    ['title' => 'Interactive Call', 'img' => 'call.jpg', 'desc' => 'Deep connection with our expert readers.', 'delay' => '0.8s'],
                ];
            @endphp

            @foreach($homeServices as $hs)
            <div class="col-md-3">
                <div class="benefit-item text-center wow fadeInUp" data-wow-delay="{{ $hs['delay'] }}">
                    <div class="img-wrapper mb-4">
                        <img src="{{asset('cust/image/'.$hs['img'])}}" 
                             style="width: 130px; height: 130px; border-radius: 50%; border: 2px solid #3d3020; padding: 5px; filter: drop-shadow(0 0 10px rgba(212,175,55,0.2));" 
                             class="img-responsive center-block">
                    </div>
                    <h2 style="font-size: 1.5rem; color: #d4af37; font-weight: 800; text-transform: uppercase;">{{ $hs['title'] }}</h2>
                    <p style="color: #bbb; font-size: 0.9rem; margin-top: 15px; line-height: 1.6;">{{ $hs['desc'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<div class="daily-section" style="padding: 100px 0; border-top: 1px solid rgba(212,175,55,0.1);">
    <div class="container">
        <div class="row mb-5 text-center">
            <div class="col-md-12">
                <h2 class="section-title wow fadeInDown">TODAY'S CARD</h2>
                <p style="color:#888; letter-spacing:3px; font-size:0.85rem;">
                    {{ strtoupper(\Carbon\Carbon::now()->translatedFormat('l, d F Y')) }}
                </p>
                <div style="width:60px; height:2px; background:#e91e63; margin:20px auto 50px;"></div>
            </div>
        </div>

        @if($dailyCard)
        <div class="row justify-content-center align-items-center">

            <div class="col-md-4 text-center wow fadeInLeft">
                <div class="daily-card-flip">
                    <img src="{{ asset('cust/image/daily_card/' . $dailyCard->card_image) }}"
                         alt="{{ $dailyCard->card_name }}"
                         style="width:200px; border-radius:15px; border:2px solid #d4af37;
                                box-shadow: 0 0 40px rgba(212,175,55,0.25), 0 0 80px rgba(212,175,55,0.1);">
                </div>
                <p style="color:#d4af37; letter-spacing:3px; font-size:0.75rem;
                           margin-top:20px; text-transform:uppercase;">
                    ✦ Draw of the Day ✦
                </p>
            </div>

            {{-- Info Kartu --}}
            <div class="col-md-6 wow fadeInRight" style="padding-left:40px; margin-top:30px;">
                <div class="daily-info">
                    <h3 style="color:#d4af37; font-family:'Playfair Display',serif;
                                font-size:2.2rem; font-weight:800;
                                letter-spacing:4px; margin-bottom:15px;">
                        {{ strtoupper($dailyCard->card_name) }}
                    </h3>

                    <div style="display:flex; gap:10px; flex-wrap:wrap; margin-bottom:25px;">
                        @foreach(explode(',', $dailyCard->keyword) as $kw)
                        <span style="background:rgba(212,175,55,0.1);
                                     border:1px solid rgba(212,175,55,0.3);
                                     color:#d4af37; padding:4px 14px;
                                     border-radius:20px; font-size:0.78rem; letter-spacing:2px;">
                            {{ trim($kw) }}
                        </span>
                        @endforeach
                    </div>

                    <p style="color:#bbb; font-size:1.05rem; line-height:1.9;">
                        {{ $dailyCard->meaning }}
                    </p>
                </div>
            </div>

        </div>
        @else
        <div class="text-center">
            <p style="color:#555; letter-spacing:2px;">No card assigned for today.</p>
        </div>
        @endif
    </div>
</div>

<div class="message-section" style="padding: 100px 0; background: rgba(10,10,10,0.9); position: relative; overflow: hidden;">

    <div style="position:absolute; top:50%; left:50%; transform:translate(-50%,-50%);
                width:600px; height:600px; border-radius:50%;
                background: radial-gradient(circle, rgba(233,30,99,0.04) 0%, transparent 70%);
                pointer-events:none;"></div>
    <div style="position:absolute; top:20px; left:10%; font-size:80px; color:rgba(212,175,55,0.04); pointer-events:none;">✦</div>
    <div style="position:absolute; bottom:20px; right:10%; font-size:100px; color:rgba(233,30,99,0.04); pointer-events:none;">☽</div>

    <div class="container" style="position:relative; z-index:1;">

        <div class="row mb-5 text-center">
            <div class="col-md-12">
                <p style="color:#e91e63; letter-spacing:5px; font-size:0.8rem; text-transform:uppercase; margin-bottom:14px;">Who We Are</p>
                <h2 class="section-title wow fadeInDown">OUR PROFILE</h2>
                <div style="width:60px; height:2px; background:#e91e63; margin:18px auto 50px;"></div>
            </div>
        </div>

        <div class="row align-items-center">

            {{-- Kiri --}}
            <div class="col-md-6 wow fadeInLeft" style="padding-right:50px;">
                <p style="color:#d4af37; font-size:0.8rem; letter-spacing:5px; text-transform:uppercase; margin-bottom:18px;">✦ About Meow Tarot</p>
                <h3 style="color:#fff; font-family:'Playfair Display',serif; font-size:2.2rem; font-weight:700; line-height:1.35; margin-bottom:22px;">
                    Guiding Souls Through the<br>
                    <span style="color:#d4af37;">Language of the Cards</span>
                </h3>
                <p style="color:#bbb; font-size:1.90rem; line-height:1.95; margin-bottom:16px;">
                    Meow Tarot adalah platform spiritual yang menghadirkan pembacaan Tarot, Palmistry, dan konsultasi personal secara online maupun offline. Dipercayai oleh ratusan jiwa yang mencari kejelasan dan arah dalam perjalanan hidup mereka.
                </p>
                <p style="color:#888; font-size:1.70rem; line-height:1.85;">
                    Setiap sesi dirancang untuk memberikan wawasan mendalam, bukan sekadar ramalan — melainkan panduan untuk memahami dirimu lebih jauh dan menghadapi setiap babak kehidupan dengan lebih bijak.
                </p>
                <a href="{{ route('customer.about_cust') }}"
                   style="display:inline-block; margin-top:28px; padding:13px 32px;
                          border:1px solid #d4af37; color:#d4af37; border-radius:30px;
                          font-size:0.85rem; letter-spacing:3px; text-decoration:none; transition:0.3s;"
                   onmouseover="this.style.background='#d4af37';this.style.color='#000';"
                   onmouseout="this.style.background='transparent';this.style.color='#d4af37';">
                    LEARN MORE ✦
                </a>
            </div>

            {{-- Kanan --}}
            <div class="col-md-6 wow fadeInRight" style="padding-left:10px; margin-top:30px;">

                {{-- Quote card --}}
                <div style="background:rgba(20,20,20,0.95); border:1px solid #3d3020;
                             border-radius:18px; padding:38px 38px 32px; position:relative; overflow:hidden; margin-bottom:20px;">
                    <div style="position:absolute; top:-5px; left:22px; font-size:90px;
                                 color:rgba(212,175,55,0.09); font-family:Georgia,serif; line-height:1;">"</div>
                    <p style="color:#ccc; font-size:1.1rem; font-style:italic; line-height:1.85;
                               position:relative; z-index:1; margin-bottom:22px;">
                        The cards don't predict your future — they illuminate the paths before you, so you may walk with clarity and intention.
                    </p>
                    <div style="display:flex; align-items:center; gap:14px;">
                        <div style="width:40px; height:2px; background:#d4af37;"></div>
                        <span style="color:#d4af37; font-size:0.85rem; letter-spacing:3px;">MEOW TAROT</span>
                    </div>
                    <div style="position:absolute; bottom:15px; right:20px; font-size:42px; color:rgba(212,175,55,0.09);">✦</div>
                </div>

                {{-- Value cards dengan gap --}}
                <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:14px;">
                    @foreach([['☽','Honest Reading','Pembacaan jujur tanpa manipulasi'],['✦','Professional','Reader berpengalaman & terlatih'],['♦','Confidential','Privasi klien selalu terjaga']] as $v)
                    <div style="background:rgba(15,15,15,0.95); border:1px solid #2a2a2a;
                                 border-radius:14px; padding:24px 16px; text-align:center; transition:0.3s;"
                         onmouseover="this.style.borderColor='#d4af37';"
                         onmouseout="this.style.borderColor='#2a2a2a';">
                        <div style="font-size:28px; color:#d4af37; margin-bottom:12px; line-height:1;">{{ $v[0] }}</div>
                        <p style="color:#fff; font-size:0.9rem; font-weight:700; margin-bottom:8px; letter-spacing:1px;">{{ $v[1] }}</p>
                        <p style="color:#666; font-size:0.78rem; line-height:1.5; margin:0;">{{ $v[2] }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Stats bar --}}
        <div class="row wow fadeInUp" style="margin-top:60px;">
            <div class="col-md-12">
                <div style="background:rgba(15,15,15,0.9); border:1px solid #2a2a2a;
                             border-radius:16px; padding:40px 30px;
                             display:grid; grid-template-columns:repeat(4,1fr); gap:20px; text-align:center;">
                    @foreach([['500+','Happy Clients'],['1000+','Readings Done'],['3+','Years Experience'],['4','Service Types']] as $i => $s)
                    <div style="{{ $i > 0 ? 'border-left:1px solid #2a2a2a;' : '' }}">
                        <div style="color:#d4af37; font-size:2.4rem; font-weight:800;
                                     font-family:'Playfair Display',serif; line-height:1; margin-bottom:10px;">{{ $s[0] }}</div>
                        <div style="color:#555; font-size:0.72rem; letter-spacing:4px; text-transform:uppercase;">{{ $s[1] }}</div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>
</div>

<div class="client-section" style="padding: 80px 0;">
    <div class="container text-center">
        <h2 class="section-title">CLIENTS ABOUT US</h2>
        <p class="mb-5 text-muted">Best Teachers Are Here For You</p>
        <div class="row mt-4">
            {{-- Testimonial items tetap 3 kolom seperti aslimu --}}
            @foreach(['Tanny Tan', 'Georgie Drake', 'Elva McCoy'] as $name)
            <div class="col-md-4">
                <div class="client-item wow fadeInDown animated">
                    <div class="client-content text-left">
                        <i class="fa fa-quote-left"></i>
                        <p class="small italic">"Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore."</p>
                    </div>
                    <h3 style="color: #d4af37; font-size: 1.1rem; margin-top: 20px;">{{ $name }}</h3>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<div class="table-section" style="padding: 80px 0; border-top: 1px solid rgba(212,175,55,0.1);">
    <div class="container text-center">
        <h2 class="section-title">PRICING TABLE</h2>
        <p class="text-muted mb-5">Our Pricing list for The Customers</p>
        <div class="row g-4">
            <div class="col-md-4 wow fadeInDown animated" data-wow-delay="0.2s">
                <div class="table-item">
                    <h3>PACKAGE 1</h3>
                    <ul><li>1 Tarot for 1 Question</li></ul>
                    <a href="{{ route('customer.service_cust') }}">PURCHASE</a>
                </div>
            </div>
            <div class="col-md-4 wow fadeInDown animated" data-wow-delay="0.4s">
                <div class="table-item" style="border-color: #d4af37; box-shadow: 0 0 15px rgba(212,175,55,0.1);">
                    <h3>PACKAGE 2</h3>
                    <ul><li>3 Card for 1 Question</li></ul>
                    <a href="{{ route('customer.service_cust') }}">PURCHASE</a>
                </div>
            </div>
            <div class="col-md-4 wow fadeInDown animated" data-wow-delay="0.6s">
                <div class="table-item">
                    <h3>PACKAGE 3</h3>
                    <ul><li>6 Card for 2 Questions</li></ul>
                    <a href="{{ route('customer.service_cust') }}">PURCHASE</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection