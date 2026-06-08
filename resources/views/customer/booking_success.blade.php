@extends('layouts.master_cust')
@section('title','Payment Success - Your Journey Begins')
@section('content')

<style>
    .success-page-wrapper {
        background-color: #050505;
        position: relative;
        overflow: hidden;
        padding: 100px 0;
        min-height: 100vh;
        color: #ccc;
        background-image:
            radial-gradient(circle at 0% 0%, rgba(212, 175, 55, 0.12) 0%, transparent 50%),
            radial-gradient(circle at 100% 100%, rgba(233, 30, 99, 0.08) 0%, transparent 50%);
    }

    .success-card {
        max-width: 640px;
        margin: 0 auto;
        background: rgba(10, 10, 10, 0.85);
        backdrop-filter: blur(20px);
        border: 1px solid #3d3020;
        outline: 1px solid rgba(212, 175, 55, 0.3);
        outline-offset: -12px;
        border-radius: 40px;
        padding: 70px 40px;
        box-shadow: 0 40px 100px rgba(0,0,0,1);
        text-align: center;
        position: relative;
        z-index: 10;
    }

    .success-icon {
        width: 110px;
        height: 110px;
        margin: 0 auto 25px;
        border-radius: 50%;
        background: linear-gradient(45deg, #d4af37, #aa8e2d);
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 0 35px rgba(212, 175, 55, 0.5);
    }

    .success-icon i {
        color: #000;
        font-size: 3rem;
    }

    .success-card h2 {
        color: #d4af37;
        font-family: 'Playfair Display', serif;
        letter-spacing: 5px;
        text-transform: uppercase;
        margin-bottom: 10px;
    }

    .success-card .order-id {
        font-size: 0.8rem;
        color: #666;
        letter-spacing: 2px;
        margin-bottom: 25px;
        display: block;
    }

    .success-card .lead-text {
        color: #bbb;
        margin-bottom: 35px;
        font-size: 1rem;
        line-height: 1.7;
    }

    .booking-summary {
        background: rgba(255, 255, 255, 0.02);
        border-radius: 20px;
        padding: 25px;
        margin-bottom: 40px;
        border: 1px dashed rgba(212, 175, 55, 0.2);
        text-align: left;
    }

    .booking-summary .summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
        font-size: 0.95rem;
    }

    .booking-summary .summary-row span:first-child {
        color: #888;
    }

    .booking-summary .summary-row span:last-child {
        color: #fff;
    }

    .summary-total {
        border-top: 1px solid rgba(212, 175, 55, 0.3);
        padding-top: 15px;
        margin-top: 15px;
        font-size: 1.25rem;
        font-family: 'Playfair Display', serif;
    }

    .summary-total span:last-child {
        color: #d4af37 !important;
    }

    .btn-action {
        background: linear-gradient(45deg, #d4af37, #aa8e2d);
        color: #000;
        border: none;
        padding: 16px 40px;
        border-radius: 50px;
        font-weight: 900;
        letter-spacing: 3px;
        transition: 0.4s;
        box-shadow: 0 0 20px rgba(212, 175, 55, 0.3);
        text-transform: uppercase;
        text-decoration: none;
        display: inline-block;
        margin: 5px;
    }

    .btn-action:hover {
        background: linear-gradient(45deg, #fff, #d4af37);
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(212, 175, 55, 0.5);
        color: #000;
    }

    .btn-action.secondary {
        background: transparent;
        color: #d4af37;
        border: 1px solid #d4af37;
        box-shadow: none;
    }

    .btn-action.secondary:hover {
        background: rgba(212, 175, 55, 0.1);
        color: #fff;
        border-color: #fff;
    }
</style>

<div class="success-page-wrapper">
    <div class="container">
        <div class="success-card wow zoomIn">
            <div class="success-icon">
                <i class="fa fa-check"></i>
            </div>

            <h2>Payment Confirmed</h2>
            <span class="order-id">TRANSACTION ID: #{{ $booking->id }}</span>

            <p class="lead-text">
                The stars have aligned. Your booking has been received and is now being prepared by our reader.
                You will be notified when your session is ready.
            </p>

            <div class="booking-summary">
                <div class="summary-row">
                    <span>Package</span>
                    <span>{{ $booking->package->name }}</span>
                </div>
                <div class="summary-row">
                    <span>Type</span>
                    <span style="text-transform: capitalize;">{{ $booking->type }} Session</span>
                </div>
                <div class="summary-row">
                    <span>Booking Date</span>
                    <span>{{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }} — {{ \Carbon\Carbon::parse($booking->booking_time)->format('H:i') }}</span>
                </div>
                <div class="summary-row summary-total">
                    <span>Total Paid</span>
                    <span>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                </div>
            </div>

            <a href="{{ url('/history') }}" class="btn-action">View My Journey</a>
            <a href="{{ url('/service') }}" class="btn-action secondary">Back to Services</a>
        </div>
    </div>
</div>

@endsection
