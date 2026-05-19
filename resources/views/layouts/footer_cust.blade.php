<style>
    .footer-section {
        background-color: #050505;
        padding: 60px 0 30px;
        border-top: 1px solid #3d3020;
        color: #888;
        position: relative;
    }

    /* Styling Social Media */
    .social-media {
        padding: 0;
        list-style: none;
        display: flex;
        gap: 15px;
        justify-content: center;
    }

    .social-media li a {
        width: 45px;
        height: 45px;
        background: rgba(212, 175, 55, 0.05);
        border: 1px solid rgba(212, 175, 55, 0.3);
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        color: #d4af37;
        font-size: 1.2rem;
        transition: 0.4s;
        text-decoration: none;
    }

    .social-media li a:hover {
        background: #e91e63;
        color: #fff;
        border-color: #e91e63;
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(233, 30, 99, 0.4);
    }

    /* Footer Text & Links */
    .footer-brand h3 {
        font-family: 'Playfair Display', serif;
        color: #fff;
        letter-spacing: 3px;
        font-size: 1.5rem;
    }

    .footer-links {
        list-style: none;
        padding: 0;
    }

    .footer-links li {
        margin-bottom: 10px;
    }

    .footer-links a {
        color: #666;
        text-decoration: none;
        transition: 0.3s;
        font-size: 0.9rem;
    }

    .footer-links a:hover {
        color: #d4af37;
        padding-left: 5px;
    }

    /* Scroll to Top Button */
    .top-button-wrap {
        position: absolute;
        top: -25px;
        left: 50%;
        transform: translateX(-50%);
    }

    .top-button-wrap a {
        width: 50px;
        height: 50px;
        background: #d4af37;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        color: #000;
        box-shadow: 0 0 20px rgba(212, 175, 55, 0.5);
        transition: 0.3s;
    }

    .top-button-wrap a:hover {
        background: #fff;
        transform: translateY(-3px);
    }

    .footer-bottom {
        border-top: 1px solid rgba(255, 255, 255, 0.05);
        margin-top: 40px;
        padding-top: 20px;
        font-size: 0.8rem;
        text-align: center;
        letter-spacing: 1px;
    }
</style>

<div class="footer-section">
    <div class="top-button-wrap">
        <a href="#top-button" class="scroll"><i class="fa fa-chevron-up"></i></a>
    </div>

    <div class="container">
        <div class="row text-center text-md-start">
            {{-- Brand Section --}}
            <div class="col-md-4 mb-4 mb-md-0">
                <div class="footer-brand">
                    <h3>MYSTIC TAROT</h3>
                    <p class="mt-3">Membantu Anda menemukan jawaban dari semesta melalui media kartu Tarot dan garis tangan.</p>
                </div>
            </div>

            {{-- Quick Links --}}
            <div class="col-md-4 mb-4 mb-md-0 text-center">
                <h5 style="color: #d4af37; margin-bottom: 20px; font-weight: bold;">EXPLORE</h5>
                <ul class="footer-links">
                    <li><a href="/home">Home</a></li>
                    <li><a href="/about">About Us</a></li>
                    <li><a href="/services">Services</a></li>
                    <li><a href="/contact">Contact</a></li>
                </ul>
            </div>

            {{-- Social Media --}}
            <div class="col-md-4 text-center text-md-end">
                <h5 style="color: #d4af37; margin-bottom: 20px; font-weight: bold;">CONNECT</h5>
                <ul class="social-media justify-content-center justify-content-md-end">
                    <li><a href="https://wa.me/085707950850" target="_blank" class="fa fa-whatsapp">
                    <li><a href="" target="_blank" aria-label="Tiktok"></a></li>
                