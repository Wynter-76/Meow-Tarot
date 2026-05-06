<h2>Halo {{ $booking->name }}</h2>

<p>Terima kasih sudah menggunakan layanan kami ✨</p>

<p><b>Paket:</b> {{ $booking->package->name ?? '-' }}</p>

@if($booking->type == 'online')
    <h4>Pertanyaan:</h4>
    <ul>
        @foreach($booking->questions as $q)
            <li>{{ $q->question }}</li>
        @endforeach
    </ul>
@endif

<h4>Hasil Reading:</h4>
<p>{{ $booking->reading_result }}</p>

<p>Semoga membantu 🙏</p>