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

        <div class="purilfy-section">
            <div class="container">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <div class="purifliy-item wow fadeInDown animated">
                            <h3>HAVING QUESTION ABOUT YOUR LIFE?</h3>
                            <p>Clear all the questions in your mind to us.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="benefit-section">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="section-title">OUR SERVICE</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 benefit-item wow fadeInDown animated" data-wow-delay="0.2s">
                        <h3>Service 1</h3>
                        <a><img src="{{asset("cust/image/tarotpaket.jpg")}}" width="207" height="208" class="img-responsive" alt=""></a>
                        <h2>Tarot Reading</h2>
                        <p>Begin your future reading</p>
                    </div>
                    <div class="col-md-3 benefit-item wow fadeInDown animated" data-wow-delay="0.4s">
                        <h3>Service 2</h3>
                        <a><img src="{{asset("cust/image/palmreading.jpg")}}" width="207" height="208"  class="img-responsive" alt=""></a>
                        <h2>Palm Reading</h2>
                        <p>Begin your palm reading</p>
                    </div>
                    <div class="col-md-3 benefit-item wow fadeInDown animated" data-wow-delay="0.6s">
                        <h3>Service 3</h3>
                        <a><img src="{{asset("cust/image/chat.jpg")}}" width="225" height="226" class="img-responsive"  alt=""></a>
                        <h2>Interactive Chat</h2>
                        <p>Have the best experience interactive chat with profesional.</p>
                    </div>
                    <div class="col-md-3 benefit-item wow fadeInDown animated" data-wow-delay="0.8s">
                        <h3>Service 4</h3>
                        <a><img src="{{asset("cust/image/call.jpg")}}" width="207" height="208" class="img-responsive"  alt=""></a>
                        <h2>Interactive Call</h2>
                        <p>Have the best experience interactive call with us.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="message-section">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2 wow fadeInDown animated">
                        <h2 class="section-title">Our Profile</h2>
                        <p>Begin your journey with us, our service is Tarot  reading, palm reading, interactive chat, and interactive call.<br>With a lot of service from us, get start and begin your spiritual journey with uss.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="client-section">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="section-title">Clients about Us</h2>
                        <p class="title-cap">Best Teachers Are Here For You</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="client-item wow fadeInDown animated" data-wow-delay="0.2s">
                            <div class="client-content">
                                <i class="fa fa-quote-left"></i>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                            </div>
                            <h3>Tanny Tan</h3>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="client-item wow fadeInDown animated" data-wow-delay="0.5s">
                            <div class="client-content">
                                <i class="fa fa-quote-left"></i>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                            </div>
                            <h3>Georgie Drake</h3>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="client-item wow fadeInDown animated" data-wow-delay="0.8s">
                            <div class="client-content">
                                <i class="fa fa-quote-left"></i>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                            </div>
                            <h3>Elva McCoy</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="table-section">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="section-title">Pricing Table</h2>
                        <p class="section-cap">Our Pricing list for The Customers</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 table-content wow fadeInDown animated" data-wow-delay="0.2s">
                        <div class="table-item sliver">
                            <h2></h2> 
                            <h3>PACKAGE 1</h3>
                            <ul>
                                <li>1 Tarot for 1 Question</li>
                            </ul>
                            <a href="{{ route('customer.service_cust') }}">Purchase</a>
                        </div>
                    </div>
                    <div class="col-md-4 table-content wow fadeInDown animated" data-wow-delay="0.5s">
                        <div class="table-item gold">
                            <h2></h2>
                            <h3>Package 2</h3>
                            <ul>
                                <li>3 Card for 1 question</li>
                            </ul>
                            <a href="{{ route('customer.service_cust') }}">Purchase</a>
                        </div>
                    </div>
                    <div class="col-md-4 table-content wow fadeInDown animated" data-wow-delay="0.81s">
                        <div class="table-item platinum">
                            <h2></h2>
                            <h3>PACKAGE 3</h3>
                            <ul>
                                <li>6 Card for 2 Questions</li>
                            </ul>
                            <a href="{{ route('customer.service_cust') }}">Purchase</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

@endsection