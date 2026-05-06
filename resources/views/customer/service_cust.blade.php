@extends('layouts.master_cust')
@section('title','Service')
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

<div class="container" style="padding:100px 0;">

    <!-- TAROT -->
    <h2 class="section-title text-center">TAROT</h2>
    <div class="row justify-content-center mb-5">
        @foreach($tarot as $p)
        <div class="col-md-3 mb-4">
            <div class="card package-card text-center p-3">
                <h5 class="package-title">{{ $p->name }}</h5>
                <p>{{ $p->description }}</p>

                <a href="/tarot/online/{{ $p->id }}" class="btn btn-pink">Online</a>
                <a href="/tarot/offline/{{ $p->id }}" class="btn btn-pink">Offline</a>
            </div>
        </div>
        @endforeach
    </div>

    <!-- PALM -->
    <h2 class="section-title text-center">PALM</h2>
    <div class="row justify-content-center mb-5">
        @foreach($palm as $p)
        <div class="col-md-3 mb-4">
            <div class="card package-card text-center p-3">
                <h5>{{ $p->name }}</h5>
                <p>{{ $p->description }}</p>

                <a href="/palm/online/{{ $p->id }}" class="btn btn-pink">Online</a>
                <a href="/palm/offline/{{ $p->id }}" class="btn btn-pink">Offline</a>
            </div>
        </div>
        @endforeach
    </div>

    <!-- CHAT -->
    <h2 class="section-title text-center">CHAT</h2>
    <div class="row justify-content-center mb-5">
        @foreach($chat as $p)
        <div class="col-md-3 mb-4">
            <div class="card package-card text-center p-3">
                <h5>{{ $p->name }}</h5>
                <p>{{ $p->description }}</p>

                <a href="/chat/{{ $p->id }}" class="btn btn-pink">Pilih</a>
            </div>
        </div>
        @endforeach
    </div>

    <!-- CALL -->
    <h2 class="section-title text-center">CALL</h2>
    <div class="row justify-content-center">
        @foreach($call as $p)
        <div class="col-md-3 mb-4">
            <div class="card package-card text-center p-3">
                <h5>{{ $p->name }}</h5>
                <p>{{ $p->description }}</p>

                <a href="/call/{{ $p->id }}" class="btn btn-pink">Pilih</a>
            </div>
        </div>
        @endforeach
    </div>

</div>


@endsection