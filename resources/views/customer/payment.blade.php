@extends('layouts.master_cust')

@section('content')

<div class="container mt-5 text-center">
    <h2>Pembayaran</h2>
    <h4>Total: Rp {{ $booking->total_price }}</h4>

    <button id="pay-button" class="btn btn-primary">
        Bayar Sekarang
    </button>
</div>

<!-- MIDTRANS -->
<script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.client_key') }}"></script>

<script>
document.getElementById('pay-button').onclick = function () {
    snap.pay('{{ $snapToken }}', {
        onSuccess: function(result){
            alert("Pembayaran berhasil!");
            window.location.href = "/home";
        },
        onPending: function(result){
            alert("Menunggu pembayaran");
        },
        onError: function(result){
            alert("Pembayaran gagal");
        }
    });
};
</script>

@endsection