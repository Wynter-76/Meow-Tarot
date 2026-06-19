<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room Chat — Mystic Tarot</title>
    <link href="{{ asset('admin_reader/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <style>
        * { box-sizing: border-box; font-family: 'Segoe UI', Arial, sans-serif; }
        body { margin: 0; background: #050505; color: #ccc;
            background-image:
                radial-gradient(circle at 0% 0%, rgba(233,30,99,.08) 0%, transparent 50%),
                radial-gradient(circle at 100% 100%, rgba(212,175,55,.08) 0%, transparent 50%);
            min-height: 100vh; }
        .wrap { max-width: 760px; margin: 0 auto; padding: 40px 16px; }
        .top { display:flex; justify-content:space-between; align-items:center; margin-bottom:24px; }
        h2 { color:#d4af37; font-family:'Playfair Display',serif; letter-spacing:2px; text-transform:uppercase; margin:0; }
        .back { color:#ccc; text-decoration:none; border:1px solid #3d3020; padding:8px 16px; border-radius:30px; font-size:13px; }
        .back:hover { background:rgba(255,255,255,.04); }
        .room { display:flex; align-items:center; gap:14px; background:rgba(10,10,10,.85); border:1px solid #3d3020;
            border-radius:16px; padding:16px 18px; margin-bottom:12px; text-decoration:none; color:#ccc; transition:.2s; }
        .room:hover { outline:1px solid rgba(212,175,55,.4); transform:translateY(-2px); }
        .avatar { width:46px; height:46px; border-radius:50%; background:#2a2540; display:flex; align-items:center; justify-content:center; color:#d4af37; font-size:20px; flex-shrink:0; }
        .room .info { flex:1; min-width:0; }
        .room .name { color:#fff; font-weight:600; }
        .room .last { font-size:13px; color:#888; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
        .badge-addon { background:#ffb020; color:#1e1b2e; font-size:11px; font-weight:700; padding:2px 9px; border-radius:20px; }
        .unread { background:#e91e63; color:#fff; font-size:11px; font-weight:700; min-width:22px; height:22px; border-radius:50%; display:flex; align-items:center; justify-content:center; }
        .empty { text-align:center; padding:60px 0; color:#666; }
        .empty i { font-size:3rem; display:block; margin-bottom:14px; }
    </style>
</head>
<body>
<div class="wrap">
    <div class="top">
        <h2>💬 Room Chat</h2>
        @if(Auth::user()->role === 'reader' || Auth::user()->role === 'admin')
            <a class="back" href="{{ url('/reader/bookingmasuk') }}"><i class="fas fa-arrow-left"></i> Booking</a>
        @else
            <a class="back" href="{{ url('/history') }}"><i class="fas fa-arrow-left"></i> Riwayat</a>
        @endif
    </div>

    @forelse($rooms as $room)
        @php
            $iAmReader = $room->reader_id === Auth::id() || (Auth::user()->role !== 'customer' && Auth::user()->role !== '');
            $other = $iAmReader ? ($room->customer->name ?? 'Customer') : ($room->reader->name ?? 'Reader (belum ditentukan)');
            $unread = $room->messages()->whereNull('read_at')->where('sender_id','!=',Auth::id())->count();
        @endphp
        <a class="room" href="{{ url('/rooms/'.$room->id) }}">
            <div class="avatar"><i class="fas fa-user"></i></div>
            <div class="info">
                <div class="name">
                    {{ $other }}
                    @if($room->has_addon)<span class="badge-addon">⭐ Add-on</span>@endif
                </div>
                <div class="last">
                    Booking #{{ $room->booking_id }} · {{ $room->booking->package->name ?? 'Paket' }}
                    @if($room->lastMessage) — "{{ \Illuminate\Support\Str::limit($room->lastMessage->body, 40) }}"@endif
                </div>
            </div>
            @if($unread > 0)<div class="unread">{{ $unread }}</div>@endif
        </a>
    @empty
        <div class="empty">
            <i class="fas fa-comments"></i>
            <p>Belum ada room. Room muncul otomatis saat kamu buka chat dari sebuah booking.</p>
        </div>
    @endforelse
</div>
</body>
</html>
