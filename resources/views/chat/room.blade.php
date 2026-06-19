<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Chat Room #{{ $room->id }} — Mystic Tarot</title>
    <link href="{{ asset('admin_reader/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <style>
        * { box-sizing: border-box; font-family: 'Segoe UI', Arial, sans-serif; }
        body { margin:0; background:#050505; color:#ccc;
            background-image:
                radial-gradient(circle at 0% 0%, rgba(233,30,99,.08) 0%, transparent 50%),
                radial-gradient(circle at 100% 100%, rgba(212,175,55,.08) 0%, transparent 50%);
            height:100vh; display:flex; flex-direction:column; }
        .wrap { max-width:720px; width:100%; margin:0 auto; flex:1; display:flex; flex-direction:column; padding:14px; min-height:0; }
        .head { display:flex; align-items:center; gap:12px; background:rgba(10,10,10,.9); border:1px solid #3d3020;
            border-radius:14px; padding:12px 16px; }
        .head .avatar { width:42px; height:42px; border-radius:50%; background:#2a2540; display:flex; align-items:center; justify-content:center; color:#d4af37; }
        .head .name { color:#fff; font-weight:600; }
        .head .sub { font-size:12px; color:#888; }
        .head a { color:#ccc; text-decoration:none; margin-left:auto; border:1px solid #3d3020; padding:7px 14px; border-radius:30px; font-size:13px; }
        .badge-addon { background:#ffb020; color:#1e1b2e; font-size:11px; font-weight:700; padding:2px 9px; border-radius:20px; margin-left:6px; }
        #box { flex:1; overflow-y:auto; padding:16px 4px; display:flex; flex-direction:column; gap:8px; min-height:0; }
        .msg { max-width:75%; padding:9px 14px; border-radius:14px; line-height:1.4; word-wrap:break-word; }
        .me { align-self:flex-end; background:#7c5cff; color:#fff; border-bottom-right-radius:4px; }
        .them { align-self:flex-start; background:#241f38; color:#eee; border:1px solid #3d3020; border-bottom-left-radius:4px; }
        .meta { font-size:10px; opacity:.7; margin-top:4px; text-align:right; }
        .role { font-size:10px; text-transform:uppercase; letter-spacing:.5px; opacity:.7; margin-bottom:2px; }
        .sendrow { display:flex; gap:8px; padding-top:10px; }
        .sendrow input { flex:1; padding:12px 16px; border-radius:30px; border:1px solid #3d3020; background:#1a1726; color:#eee; font-size:14px; }
        .sendrow input:focus { outline:none; border-color:#7c5cff; }
        .sendrow button { border:none; background:#7c5cff; color:#fff; width:50px; border-radius:50%; cursor:pointer; font-size:16px; }
        .sendrow button:hover { background:#6a4ae6; }
        .closed { text-align:center; color:#888; font-size:13px; padding:10px; }
        .empty-hint { text-align:center; color:#555; margin:auto; }
    </style>
</head>
<body>
<div class="wrap">
    @php
        $iAmReaderSide = $room->reader_id === Auth::id() || (Auth::user()->role !== 'customer');
        $other = $iAmReaderSide ? ($room->customer->name ?? 'Customer') : ($room->reader->name ?? 'Reader');
    @endphp
    <div class="head">
        <div class="avatar"><i class="fas fa-user"></i></div>
        <div>
            <div class="name">{{ $other }}@if($room->has_addon)<span class="badge-addon">⭐ Add-on</span>@endif</div>
            <div class="sub">Booking #{{ $room->booking_id }} · {{ $room->booking->package->name ?? 'Paket' }}
                @if($room->has_addon && $room->booking) · {{ $room->booking->addons->pluck('name')->join(', ') }}@endif
            </div>
        </div>
        <a href="{{ url('/rooms') }}"><i class="fas fa-arrow-left"></i> Daftar</a>
    </div>

    <div id="box">
        @forelse($messages as $m)
            <div class="msg {{ $m->sender_id === Auth::id() ? 'me' : 'them' }}">
                @if($m->sender_id !== Auth::id())<div class="role">{{ $m->sender_role }}</div>@endif
                {{ $m->body }}
                <div class="meta">{{ optional($m->created_at)->format('H:i') }}</div>
            </div>
        @empty
            <div class="empty-hint" id="emptyHint">Belum ada pesan. Sapa duluan 👋</div>
        @endforelse
    </div>

    @if($room->status === 'closed')
        <div class="closed"><i class="fas fa-lock"></i> Room sudah ditutup.</div>
    @else
        <div class="sendrow">
            <input id="msg" placeholder="Tulis pesan..." autocomplete="off" onkeydown="if(event.key==='Enter')send()">
            <button onclick="send()"><i class="fas fa-paper-plane"></i></button>
        </div>
    @endif
</div>

<script>
    const ROOM = {{ $room->id }};
    const CSRF = document.querySelector('meta[name=csrf-token]').content;
    const box = document.getElementById('box');
    let lastId = {{ $messages->max('id') ?? 0 }};

    box.scrollTop = box.scrollHeight;

    function add(m){
        const hint = document.getElementById('emptyHint');
        if(hint) hint.remove();
        const d = document.createElement('div');
        d.className = 'msg ' + (m.is_mine ? 'me' : 'them');
        const role = m.is_mine ? '' : `<div class="role">${m.sender_role}</div>`;
        d.innerHTML = `${role}${escapeHtml(m.body)}<div class="meta">${m.time||''}</div>`;
        box.appendChild(d);
        box.scrollTop = box.scrollHeight;
        if(m.id > lastId) lastId = m.id;
    }

    async function send(){
        const input = document.getElementById('msg');
        const body = input.value.trim();
        if(!body) return;
        input.value = '';
        const res = await fetch(`/rooms/${ROOM}/send`, {
            method:'POST',
            headers:{'Content-Type':'application/json','X-CSRF-TOKEN':CSRF,'Accept':'application/json'},
            body: JSON.stringify({ body })
        });
        if(res.ok){ add(await res.json()); }
        else { alert('Gagal mengirim pesan'); }
    }

    async function poll(){
        try{
            const res = await fetch(`/rooms/${ROOM}/fetch?after_id=${lastId}`, {headers:{'Accept':'application/json'}});
            if(!res.ok) return;
            const data = await res.json();
            (data.messages||[]).forEach(add);
        }catch(e){}
    }
    setInterval(poll, 3000); // tidak real-time: cek pesan baru tiap 3 detik

    function escapeHtml(t){ const d=document.createElement('div'); d.textContent=t; return d.innerHTML; }
</script>
</body>
</html>
