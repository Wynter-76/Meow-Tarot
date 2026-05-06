@extends('layouts.master_cust')
@section('title','Meow Tarot')
@section('content')


<div class="cover-section" id="top-button">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 wow fadeInDown animated">
                        <div class="slider-item">
                            <img src="{{asset("cust/image/logotarot.png") }}" width="177" height="144" > 
                            <h2>GET YOUR INSIGHT</h2>
                            <p>Begin your your Tarot reading journey with us.</p>
                        </div>
                    </div>
                </div>
            </div>
</div>

<!-- banner section  -->
    <section class="banner">
        <img src=
"https://media.geeksforgeeks.org/wp-content/uploads/20230822131732/images.png"
            alt="Welcome to our Contact Us page">
        <h1>Get in Touch With Us</h1>
        <p>
          We're here to answer any questions you may have.
          </p>
    </section>

    <!-- Contact form -->
    <section class="contact-form">
        <div class="form-container">
            <h2>Your Details</h2>
            <form action="{{ url('/contact/send') }}" method="POST">
            @csrf

                <label for="name">Name: </label>
                <input type="text" id="name" name="name" required>

                <label for="email">Email: </label>
                <input type="email" id="email" name="email" required>

                <label for="phone">Phone: </label>
                <input type="tel" id="phone" name="phone">

                <label for="message">Message: </label>
                <textarea id="message" name="message" rows="4" required></textarea>

                <button type="submit" class="submit-button">Submit</button>
            </form>
        </div>
    </section>

    <!-- Company contact info -->
    <section class="contact-info">
        <h2>Contact Information</h2>
        <address>
            Your Company Name<br>
            123 Main Street<br>
            City, State Zip Code<br>
            Phone: <a href="tel:1234567890">123-456-7890</a><br>
            Email: <a href="mailto:info@example.com">info@example.com</a>
        </address>
    </section>
@endsection