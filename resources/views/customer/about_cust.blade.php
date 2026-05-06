@extends('layouts.master_cust')
@section('title','About Us')
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

<section class="about-page" style="padding:50px 0;">
  <div class="container">
    <div class="row">

      <!-- IMAGE -->
      <div class="col-md-5">
        <img class="img-responsive img-rounded"
             src="{{ asset('assets/img/about-img-1.jpg') }}"
             alt="About">
      </div>

      <!-- TEXT -->
      <div class="col-md-7">
        <h2>Who Are We?</h2>

        <p class="lead">
          We help people to build incredible brands and superior products.
        </p>

        <p>
          We are a fast-growing company, but we have never lost sight of our core values.
        </p>

        <div class="row" style="margin-top:30px;">

          <!-- ITEM 1 -->
          <div class="col-md-6">
            <div class="media">
              <div class="media-left">
                <i class="fa fa-cog fa-2x text-primary"></i>
              </div>
              <div class="media-body">
                <h4>Versatile Brand</h4>
                <p>We craft digital experiences across all mediums.</p>
              </div>
            </div>
          </div>

          <!-- ITEM 2 -->
          <div class="col-md-6">
            <div class="media">
              <div class="media-left">
                <i class="fa fa-fire fa-2x text-primary"></i>
              </div>
              <div class="media-body">
                <h4>Digital Agency</h4>
                <p>We believe in innovation and creativity.</p>
              </div>
            </div>
          </div>

        </div>

      </div>
    </div>
  </div>
</section>

@endsection