@extends('layouts.master_cust')
@section('title', 'Exclusive Services')
@section('content')
<style>
    .service-section {
        background-color: #050505;
        position: relative;
        overflow: hidden;
        padding: 100px 0;
        color: #ffffff;
        
        /* LAYER 1: Nebula Glow (Efek cahaya remang di pojok) */
        background-image: 
            radial-gradient(circle at 10% 10%, rgba(233, 30, 99, 0.05) 0%, transparent 40%),
            radial-gradient(circle at 90% 80%, rgba(212, 175, 55, 0.05) 0%, transparent 40%),
            
            /* LAYER 2: Efek Titik-Titik Bintang (Gue balikin & gue perbanyak) */
            url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='200' viewBox='0 0 200 200'%3E%3Ccircle cx='20' cy='30' r='0.6' fill='%23d4af37' opacity='0.4'/%3E%3Ccircle cx='150' cy='10' r='0.4' fill='%23fff' opacity='0.2'/%3E%3Ccircle cx='80' cy='160' r='0.7' fill='%23fff' opacity='0.3'/%3E%3Ccircle cx='180' cy='130' r='0.5' fill='%23d4af37' opacity='0.4'/%3E%3Ccircle cx='40' cy='180' r='0.4' fill='%23fff' opacity='0.2'/%3E%3C/svg%3E");
    }

    /* LAYER 3: Ornamen Lingkaran Zodiak Besar di Belakang Card */
    .service-section::before {
        content: "";
        position: absolute;
        top: 50%;
        left: 50%;
        width: 800px;
        height: 800px;
        transform: translate(-50%, -50%);
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 200 200'%3E%3Ccircle cx='100' cy='100' r='90' fill='none' stroke='%23d4af37' stroke-width='0.2' opacity='0.1'/%3E%3Ccircle cx='100' cy='100' r='70' fill='none' stroke='%23d4af37' stroke-width='0.1' opacity='0.1'/%3E%3Cpath d='M100 10 L100 190 M10 100 L190 100 M36.4 36.4 L163.6 163.6 M36.4 163.6 L163.6 36.4' stroke='%23d4af37' stroke-width='0.1' opacity='0.1'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-size: contain;
        z-index: 0;
        pointer-events: none;
    }

    .container {
        position: relative;
        z-index: 2; /* Biar konten di atas background zodiak */
    }

    /* Mempercantik Card & Background Kartu di dalamnya */
    .package-card {
        background-color: rgba(13, 13, 13, 0.95); /* Sedikit transparan biar dapet efek glow belakang */
        border: 1px solid #3d3020;
        border-radius: 15px;
        padding: 35px 25px;
        min-height: 280px;
        max-width: 320px;
        margin: 0 auto;
        position: relative;
        overflow: hidden;
        transition: 0.4s ease;
    }

    /* Background Kartu Tarot yang Lebih "Wah" */
    .package-card::after {
        content: "";
        position: absolute;
        inset: 0;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 150'%3E%3Crect x='5' y='5' width='90' height='140' rx='6' fill='none' stroke='%23d4af37' stroke-width='0.5' opacity='0.2'/%3E%3Cpath d='M50 20 L50 130 M20 75 L80 75' stroke='%23d4af37' stroke-width='0.2' opacity='0.3'/%3E%3Ccircle cx='50' cy='75' r='25' fill='none' stroke='%23d4af37' stroke-width='0.4' opacity='0.4'/%3E%3Cpath d='M35 60 L65 90 M65 60 L35 90' stroke='%23d4af37' stroke-width='0.3' opacity='0.3'/%3E%3C/svg%3E");
        background-position: center;
        background-repeat: no-repeat;
        background-size: 130px;
        opacity: 0.6;
        z-index: -1;
    }

    .package-title {
        color: #d4af37;
        font-family: 'Playfair Display', serif;
        font-size: 1.6rem;
        font-weight: 900;
        text-transform: uppercase;
        margin-bottom: 15px;
    }

    .btn-pink {
        background: linear-gradient(45deg, #e91e63, #c2185b);
        color: white !important;
        font-weight: 800;
        border-radius: 8px;
        border: none;
        padding: 12px;
    }
</style>
<div class="service-section">
    <div class="container">
        
        {{-- Section Title --}}
        <div class="text-center mb-5 pb-4 wow fadeInDown animated">
            <h1 style="color: #d4af37; font-family: 'Playfair Display', serif; font-weight: 900; letter-spacing: 6px;">SERVICE MODELS</h1>
            <div style="width: 50px; height: 2px; background: #d4af37; margin: 15px auto;"></div>
        </div>

        @php
            $services = [
                ['label' => 'Tarot Reading', 'data' => $tarot, 'route' => 'tarot', 'mode' => 'dual', 'divider' => 'pink'],
                ['label' => 'Palmistry', 'data' => $palm, 'route' => 'palm', 'mode' => 'dual', 'divider' => 'pink'],
                ['label' => 'Direct Chat', 'data' => $chat, 'route' => 'chat', 'mode' => 'single', 'divider' => 'pink'],
                ['label' => 'Voice Call', 'data' => $call, 'route' => 'call', 'mode' => 'single', 'divider' => 'none']
            ];
        @endphp

        @foreach($services as $s)
        <div class="mb-5 pb-5"> {{-- Jarak antar kategori --}}
            
            {{-- Category Title dengan Divider Kiri (Mengikuti referensi desain) --}}
            <div class="d-flex align-items-center mb-4 wow fadeInLeft animated">
                <div class="category-divider-left" style="width: 5px; height: 30px; background: #e91e63; margin-right: 15px; border-radius: 5px;"></div>
                <h5 class="mb-0" style="color: #fff; letter-spacing: 4px;">
                    {{ strtoupper($s['label']) }}
                </h5>
            </div>
            
            <div class="row g-5 justify-content-center"> {{-- Gutter G-5 biar gak dempet --}}
                @foreach($s['data'] as $p)
                <div class="col-xl-3 col-lg-4 col-md-6 card-wrapper wow fadeInUp animated">
                    <div class="card package-card text-center">
                        <h5 class="package-title">{{ $p->name }}</h5>
                        <p>{{ $p->description }}</p>

                        <div class="mt-auto d-flex flex-column gap-3"> {{-- Jarak antar tombol --}}
                            @if($s['mode'] == 'dual')
                                <a href="/{{ $s['route'] }}/online/{{ $p->id }}" class="btn btn-pink">ONLINE</a>
                                <a href="/{{ $s['route'] }}/offline/{{ $p->id }}" style="color: #d4af37; font-size: 0.8rem; text-decoration: none; font-weight: bold;">OFFLINE</a>
                            @else
                                <a href="/{{ $s['route'] }}/{{ $p->id }}" class="btn btn-pink">SELECT PACKAGE</a>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            {{-- Menambahkan divider garis bawah kecuali section terakhir --}}
            @if($s['divider'] == 'pink')
                <div class="section-divider mt-5"></div>
            @endif
        </div>
        @endforeach

    </div>
</div>

{{-- Memasukkan skrip WoW.js jika Anda ingin efek animasi fadeInDown/Up bekerja --}}
@section('js')
<script>
    new WOW().init();
</script>
@stop

@endsection