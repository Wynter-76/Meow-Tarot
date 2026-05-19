@extends('layouts.master_cust')
@section('title','Transaction Successful')
@section('content')

<style>
    .success-wrapper {
        background-color: #050505;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 50px 0;
        background-image: radial-gradient(circle at center, rgba(212, 175, 55, 0.15) 0%, transparent 70%);
    }
    .success-card {
        background: rgba(10, 10, 10, 0.9);
        backdrop-filter: blur(15px);
        border: 1px solid #3d3020;
        outline: 1px solid rgba(212, 175, 55, 0.3);
        outline-offset: -12px;
        border-radius: 40px;
        padding: 60px;
        text-align: center;
        max-width: 600px;
        box-shadow: 0 0 50px rgba(0,0,0,1);
    }
    .check-icon {
        font-size: 5rem;
        color: #d4af37;
        margin-bottom: 30px;
        text-shadow: 0 0 20px rgba(212, 175, 55, 0.5);
    }
    .success-title {
        font-family: 'Playfair Display', serif;
        color: #fff;
        letter-spacing: 3px;
        margin-bottom: 20px;
    }
    .instruction-box {
        background: rgba(233, 30, 99, 0.05);
        border: 1px solid rgba(233, 30, 99, 0.2);
        padding: 20px;
        border-radius: 20px;
        margin: 30px 0;
        color: #ccc;
    }
    .btn-home {
        background: linear-gradient(45deg, #e91e63, #c2185b);
        color: #fff;
        padding: 15px 40px;
        border-radius: 50px;
        text-decoration: none;
        font-weight: bold;
        transition: 0.3s;
        display: inline-block;
    }
    .btn-home:hover {
        transform: scale(1.05);
        color: #fff;
        box-shadow: 0 10px 20px rgba(233, 30, 99, 0.3);
    }
</style>

<div class="success-wrapper">
    <div class="success-card wow zoomIn">
        <div class="check-icon">
            <i class="fa fa-check-circle"></i>
        </div>
        <h2 class="success-title">TRANSACTION SUCCESSFUL</h2>
        <p style="color: #888;">Energi Anda telah terhubung. Pembayaran berhasil dikonfirmasi oleh semesta.</p>
        
        <div class="instruction-box">
            <p style="margin-bottom: 5px;"><strong>Langkah Selanjutnya:</strong></p>
            <p style="font-size: 0.9rem;">Admin kami akan menghubungi Anda melalui <strong>WhatsApp</strong> dalam 1x24 jam untuk jadwal sesi Anda.</p>
        </div>

        <a href="/home" class="btn-home">BACK TO HOME</a>
    </div>
</div>

@endsection