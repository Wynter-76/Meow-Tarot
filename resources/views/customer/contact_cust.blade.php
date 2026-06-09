@extends('layouts.master_cust')
@section('title','Contact Us - Meow Tarot')
@section('content')

<style>
    /* 1. Background Utama (Konsisten) */
    .contact-page-wrapper {
        background-color: #050505;
        position: relative;
        overflow: hidden;
        padding-bottom: 100px;
        min-height: 100vh;
        color: #ccc;
        background-image: 
            radial-gradient(circle at 0% 0%, rgba(233, 30, 99, 0.08) 0%, transparent 50%),
            radial-gradient(circle at 100% 100%, rgba(212, 175, 55, 0.08) 0%, transparent 50%),
            url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='200' viewBox='0 0 200 200'%3E%3Ccircle cx='20' cy='30' r='0.6' fill='%23d4af37' opacity='0.4'/%3E%3Ccircle cx='150' cy='10' r='0.4' fill='%23fff' opacity='0.2'/%3E%3Ccircle cx='80' cy='160' r='0.7' fill='%23fff' opacity='0.3'/%3E%3Ccircle cx='180' cy='130' r='0.5' fill='%23d4af37' opacity='0.4'/%3E%3C/svg%3E");
    }

    /* Efek Metatron Cube di BG */
    .contact-page-wrapper::before {
        content: "";
        position: absolute;
        top: 15%; left: 50%; width: 100%; max-width: 1000px; height: 1000px; transform: translateX(-50%);
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Cpath d='M50 5 L90 25 L90 75 L50 95 L10 75 L10 25 Z' fill='none' stroke='%23d4af37' stroke-width='0.1' opacity='0.1'/%3E%3Ccircle cx='50' cy='50' r='45' fill='none' stroke='%23d4af37' stroke-width='0.05' opacity='0.1'/%3E%3C/svg%3E");
        background-repeat: no-repeat; background-size: contain; z-index: 0; pointer-events: none;
    }

    /* 2. Banner Section dengan Bingkai Emas */
    .contact-banner {
        padding: 60px 0;
        text-align: center;
        position: relative;
        z-index: 2;
    }

    .contact-banner img {
        width: 100%;
        max-width: 900px;
        border-radius: 20px;
        border: 2px solid #3d3020;
        padding: 10px;
        background: rgba(13, 13, 13, 0.5);
        outline: 1px solid rgba(212, 175, 55, 0.4);
        outline-offset: -18px;
        box-shadow: 0 20px 50px rgba(0,0,0,0.8);
        transition: 0.5s;
    }

    .contact-banner img:hover {
        outline-color: #e91e63;
        transform: scale(1.01);
    }

    /* 3. Form & Info Box (Glassmorphism) */
    .glass-card {
        background: rgba(10, 10, 10, 0.85);
        backdrop-filter: blur(15px);
        border: 1px solid #3d3020;
        outline: 1px solid rgba(212, 175, 55, 0.3);
        outline-offset: -10px;
        border-radius: 30px;
        padding: 45px;
        box-shadow: 0 25px 60px rgba(0,0,0,1);
        margin-bottom: 30px;
        position: relative;
        z-index: 10;
    }

    .section-title {
        color: #d4af37;
        font-family: 'Playfair Display', serif;
        letter-spacing: 4px;
        text-transform: uppercase;
        margin-bottom: 30px;
    }

    /* 4. Input Styling */
    .form-group label {
        color: #d4af37;
        letter-spacing: 1px;
        margin-bottom: 8px;
        font-weight: 600;
    }

    .form-control-mystic {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(212, 175, 55, 0.2);
        color: #fff;
        border-radius: 12px;
        padding: 12px 20px;
        width: 100%;
        margin-bottom: 20px;
        transition: 0.3s;
    }

    .form-control-mystic:focus {
        background: rgba(255, 255, 255, 0.08);
        border-color: #e91e63;
        outline: none;
        box-shadow: 0 0 10px rgba(233, 30, 99, 0.2);
    }

    .btn-mystic {
        background: linear-gradient(45deg, #e91e63, #c2185b);
        color: white;
        border: none;
        padding: 15px 40px;
        border-radius: 50px;
        font-weight: bold;
        letter-spacing: 2px;
        width: 100%;
        transition: 0.3s;
    }

    .btn-mystic:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(233, 30, 99, 0.4);
    }

    address a {
        color: #e91e63;
        text-decoration: none;
        transition: 0.3s;
    }

    address a:hover {
        color: #d4af37;
    }
</style>

<div class="contact-page-wrapper">
    
    {{-- Banner Section --}}
    <div class="contact-banner">
        <div class="container">
            <div class="wow fadeInDown">
                <h2 class="section-title mt-5">GET IN TOUCH</h2>
                <p style="color: #888; letter-spacing: 2px;">Ask the universe, or just ask us. We're here to guide you.</p>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            
            {{-- Contact Form --}}
            <div class="col-md-7 wow fadeInLeft">
                <div class="glass-card">
                    <h3 class="section-title" style="font-size: 1.5rem;">Send a Message</h3>
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul style="margin: 0; padding-left: 20px;">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ url('/contact/send') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Full Name</label>
                            <input type="text" name="name" class="form-control-mystic" placeholder="Your Name" required>
                        </div>
                        <div class="form-group">
                            <label>Email Address</label>
                            <input type="email" name="email" class="form-control-mystic" placeholder="your@email.com" required>
                        </div>
                        <div class="form-group">
                            <label>Phone (Optional)</label>
                            <input type="tel" name="phone" class="form-control-mystic" placeholder="0812...">
                        </div>
                        <div class="form-group">
                            <label>Your Question</label>
                            <textarea name="message" class="form-control-mystic" rows="4" placeholder="How can we help your journey?" required></textarea>
                        </div>
                        <button type="submit" class="btn-mystic">SEND</button>
                    </form>
                </div>
            </div>

            {{-- Contact Info --}}
            <div class="col-md-5 wow fadeInRight">
                <div class="glass-card">
                    <h3 class="section-title" style="font-size: 1.5rem;">Information</h3>
                    <div style="margin-bottom: 25px;">
                        <h5 style="color: #d4af37;"><i class="fa fa-phone mr-2"></i> Call the Oracle</h5>
                        <p><a href="tel:1234567890" style="color: #e91e63;">+62 812-3456-7890</a></p>
                    </div>
                    <div>
                        <h5 style="color: #d4af37;"><i class="fa fa-envelope mr-2"></i> Astral Mail</h5>
                        <p><a href="mailto:info@meowtarot.com" style="color: #e91e63;">hello@meowtarot.com</a></p>
                    </div>

                    <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid rgba(212,175,55,0.1);">
                        <p style="font-style: italic; font-size: 0.9rem; color: #666;">
                            "The cards never lie, and neither do we. Reach out anytime."
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection