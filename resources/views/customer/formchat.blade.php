@extends('layouts.master_cust')
@section('title','Chat Form')
@section('content')


<div class="cover-section" id="top-button">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 wow fadeInDown animated">
                        <div class="slider-item">
                            <img src="{{asset("cust/image/logotarot.png") }}" width="177" height="144" > 
                            <h2>GET YOUR INSIGHT</h2>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.<br> Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,</p>
                        </div>
                    </div>
                </div>
            </div>
</div>
<div class="booking-card p-4">
  <h2 class="mb-4 text-center">Chat / Call Session</h2>

  <form action="/booking/store" method="POST">
  @csrf

  <input type="hidden" name="type" value="online">
  <input type="hidden" name="package_id" value="{{ $package->id }}">
   <input type="hidden" id="base-price" value="{{ $package->price }}">

  <div class="mb-3">
    <label class="form-label">Nama</label>
    <input type="text" name="name" class="form-control" required>
  </div>

  <div class="mb-3">
    <label class="form-label">Email</label>
    <input type="email" name="email" class="form-control" required>
  </div>

  <div class="mb-3">
    <label class="form-label">No WhatsApp</label>
    <input type="text" name="phone" class="form-control" required>
  </div>
  <div class="mb-3">
      <label class="form-label">Add On</label>

      @foreach($addons as $addon)
          <div class="form-check">
              <input 
                  type="checkbox"
                  name="addons[]"
                  value="{{ $addon->id }}"
                  class="form-check-input addon"
                  data-price="{{ $addon->price }}"
                  id="addon-{{ $addon->id }}"
              >

              <label class="form-check-label" for="addon-{{ $addon->id }}">
                  {{ $addon->name }} (+{{ number_format($addon->price,0,',','.') }})
              </label>
          </div>
      @endforeach
  </div>
       <h5>Total: Rp 
      <span id="total-price">{{ number_format($package->price,0,',','.') }}</span>
      </h5>
          <button type="submit" class="btn-pink">Submit</button>
    </div>

  </form>
</div>
@endsection