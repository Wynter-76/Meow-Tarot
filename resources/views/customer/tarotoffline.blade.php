@extends('layouts.master_cust')
@section('title','Tarot Form')
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
  <h2 class="mb-4 text-center">Tarot Offline</h2>

  <form action="/booking/store" method="POST">
  @csrf

  <input type="hidden" name="type" value="offline">
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
    <label class="form-label">Tanggal</label>
    <input type="date" name="booking_date" class="form-control" required>
  </div>

  <div class="mb-3">
    <label class="form-label">Jam</label>
    <select name="booking_time" class="form-select">
      <option>15:00</option>
      <option>16:00</option>
      <option>17:00</option>
      <option>18:00</option>
      <option>19:00</option>
      <option>20:00</option>
      <option>21:00</option>
      <option>22:00</option>
      <option>23:00</option>
    </select>
  </div>
  <div id="question-wrapper"></div>
    <h4>Total: Rp <span id="total-price">{{ $package->price }}</span></h4>
      <button type="submit" class="btn-pink">Submit</button>
  </form>
</div>
@endsection