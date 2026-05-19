@extends('layouts.master_cust')
@section('title','Finalize Your Journey - Payment')
@section('content')

<style>
    /* 1. Background & Setup */
    .payment-page-wrapper {
        background-color: #050505;
        position: relative;
        overflow: hidden;
        padding: 100px 0;
        min-height: 100vh;
        color: #ccc;
        background-image: 
            radial-gradient(circle at 0% 0%, rgba(233, 30, 99, 0.1) 0%, transparent 50%),
            radial-gradient(circle at 100% 100%, rgba(212, 175, 55, 0.1) 0%, transparent 50%);
    }

    /* 2. Glassmorphism Payment Card */
    .payment-card {
        max-width: 600px;
        margin: 0 auto;
        background: rgba(10, 10, 10, 0.85);
        backdrop-filter: blur(20px);
        border: 1px solid #3d3020;
        outline: 1px solid rgba(212, 175, 55, 0.3);
        outline-offset: -12px;
        border-radius: 40px;
        padding: 60px 40px;
        box-shadow: 0 40px 100px rgba(0,0,0,1);
        text-align: center;
        position: relative;
        z-index: 10;
    }

    .payment-card h2 {
        color: #d4af37;
        font-family: 'Playfair Display', serif;
        letter-spacing: 5px;
        text-transform: uppercase;
        margin-bottom: 10px;
    }

    .order-id {
        font-size: 0.8rem;
        color: #666;
        letter-spacing: 2px;
        margin-bottom: 30px;
        display: block;
    }

    /* 3. Detail Rincian */
    .payment-detail {
        background: rgba(255, 255, 255, 0.02);
        border-radius: 20px;
        padding: 25px;
        margin-bottom: 40px;
        border: 1px dashed rgba(212, 175, 55, 0.2);
    }

    .detail-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
        font-size: 0.95rem;
    }

    .total-amount {
        border-top: 1px solid rgba(212, 175, 55, 0.3);
        padding-top: 15px;
        margin-top: 15px;
        font-size: 1.5rem;
        color: #fff;
        font-family: 'Playfair Display', serif;
    }

    /* 4. Mystic Pay Button */
    .btn-pay-now {
        background: linear-gradient(45deg, #d4af37, #aa8e2d);
        color: #000;
        border: none;
        padding: 18px 50px;
        border-radius: 50px;
        font-weight: 900;
        letter-spacing: 3px;
        width: 100%;
        transition: 0.4s;
        box-shadow: 0 0 20px rgba(212, 175, 55, 0.3);
        text-transform: uppercase;
    }

    .btn-pay-now:hover {
        background: linear-gradient(45deg, #fff, #d4af37);
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(212, 175, 55, 0.5);
        color: #000;
    }

    .secure-badge {
        margin-top: 25px;
        font-size: 0.75rem;
        color: #555;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }
</style>

<div class="payment-page-wrapper">
    <div class="container">
        <div class="payment-card wow zoomIn">
            {{-- Icon Dekoratif --}}
            <div class="mb-4">
                <i class="fa fa-shield-alt" style="color: #d4af37; font-size: 3rem; opacity: 0.8;"></i>
            </div>

            <h2>Secure Checkout</h2>
            <span class="order-id">TRANSACTION ID: #{{ $booking->id }}</span>

            <div class="payment-detail">
                <div class="detail-item">
                    <span>Package</span>
                    <span style="color: #fff;">{{ $booking->package->name }}</span>
                </div>
                <div class="detail-item">
                    <span>Type</span>
                    <span style="color: #fff; text-transform: capitalize;">{{ $booking->type }} Session</span>
                </div>
                <div class="total-amount">
                    <span>Total Amount</span>
                    <span style="color: #d4af37;">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                </div>
            </div>

            <button id="pay-button" class="btn-pay-now">
                COMPLETE PAYMENT
            </button>

            <div class="secure-badge">
                <i class="fa fa-lock"></i>
                <span>Encrypted & Secured by Midtrans</span>
            </div>
        </div>
    </div>
</div>

<script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.client_key') }}"></script>

<script>
    document.getElementById('pay-button').onclick = function (e) {
        e.preventDefault();
        
        // Efek loading simpel pas diklik
        this.innerHTML = "OPENING GATEWAY...";
        this.style.opacity = "0.7";

        snap.pay('{{ $snapToken }}', {
            onSuccess: function(result){
                window.location.href = "/booking/success/{{ $booking->id }}";
            },
            onPending: function(result){
                alert("Waiting for the stars to align. Payment Pending.");
            },
            onError: function(result){
                alert("Energy disrupted. Payment Failed.");
                location.reload();
            },
            onClose: function(){
                document.getElementById('pay-button').innerHTML = "COMPLETE PAYMENT";
                document.getElementById('pay-button').style.opacity = "1";
            }
        });
    };
</script>

@endsection