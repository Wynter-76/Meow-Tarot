@extends('layouts.master_cust')
@section('title','Testimonial')
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
@if(session('success'))
    <div style="color:green; margin-bottom:10px;">
        {{ session('success') }}
    </div>
@endif

<form action="{{ url('/testimonial/store') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label>Tulis Testimoni</label>
        <textarea name="message"
                  class="form-control"
                  placeholder="Ceritakan pengalaman kamu..."
                  required></textarea>
    </div>

    <button class="btn btn-primary">
        Kirim Testimoni
    </button>
</form>

<hr>

<h3>Testimoni Customer</h3>

@forelse($testimonials as $item)
    <div class="card mb-3 p-3">
        <h5>{{ $item->user->name ?? 'User' }}</h5>
        <p>{{ $item->message }}</p>
    </div>
@empty
    <p>Belum ada testimoni</p>
@endforelse
@endsection