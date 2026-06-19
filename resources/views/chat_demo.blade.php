<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demo Chat Room — Customer & Reader</title>
    <style>
        * { box-sizing: border-box; font-family: Segoe UI, Arial, sans-serif; }
        body { margin: 0; background: #1e1b2e; color: #eee; }
        .wrap { max-width: 720px; margin: 0 auto; padding: 16px; }
        h2 { margin: 8px 0; }
        .card { background: #2a2540; border-radius: 12px; padding: 16px; margin-bottom: 16px; }
        label { display: block; font-size: 13px; margin: 8px 0 4px; color: #bbb; }
        input, button { padding: 10px; border-radius: 8px; border: 1px solid #463e63; background: #1e1b2e; color: #eee; font-size: 14px; }
        input { width: 100%; }
        button { background: #7c5cff; border: none; cursor: pointer; font-weight: 600; }
        button:hover { background: #6a4ae6; }
        .row { display: flex; gap: 8px; }
        .row > * { flex: 1; }
        .badge { display: inline-block; background: #ffb020; color: #1e1b2e; font-size: 11px; font-weight: 700; padding: 2px 8px; border-radius: 20px; margin-left: 6px; }
        #chatbox { height: 360px; overflow-y: auto; background: #1a1726; border-radius: 8px; padding: 12px; margin: 12px 0; }
        .msg { max-width: 75%; margin: 6px 0; padding: 8px 12px; border-radius: 12px; clear: both; }
        .me { background: #7c5cff; float: right; }
        .them { background: #3a3458; float: left; }
        .meta { font-size: 10px; color: #cfcaea; margin-top: 4px; opacity: .8; }
        .sendrow { display: flex; gap: 8px; }
        .sendrow input { flex: 1; }
        .sendrow button { flex: 0 0 90px; }
        small { color: #888; }
    </style>
</head>
<body>
<div class="wrap">
    <h2>💬 Demo Chat Room (tidak real-time / polling)</h2>
    <small>Halaman uji backend. Buka 2 tab: satu login sebagai customer, satu sebagai reader, lalu chat di room yang sama.</small>

    <div class="card">
        <label>Email kamu (login sebagai)</label>
        <input id="email" placeholder="cth: user@gmail.com">

        <div class="row" style="margin-top:10px;">
            <div>
                <label>Buat/buka room dari Booking ID</label>
                <div class="row">
                    <input id="bookingId" placeholder="cth: 45">
                    <button onclick="openRoomFromBooking()">Buka Room</button>
                </div>
            </div>
        </div>

        <label style="margin-top:10px;">Atau langsung pakai Room ID</label>
        <div class="row">
            <input id="roomId" placeholder="cth: 1">
            <button onclick="loadRoom()">Masuk Room</button>
        </div>
    </div>

    <div class="card" id="roomCard" style="display:none;">
        <div>
            <strong id="roomTitle">Room</strong>
            <span id="addonBadge"></span>
        </div>
        <div id="roomSub" style="font-size:12px;color:#aaa;margin-top:4px;"></div>

        <div id="chatbox"></div>

        <div class="sendrow">
            <input id="msg" placeholder="Tulis pesan..." onkeydown="if(event.key==='Enter')sendMsg()">
            <button onclick="sendMsg()">Kirim</button>
        </div>
    </div>
</div>

<script>
const API = "{{ url('/api') }}";
let currentRoom = null;
let lastId = 0;
let pollTimer = null;
let myEmail = "";

function el(id){ return document.getElementById(id); }

async function openRoomFromBooking(){
    const bId = el('bookingId').value.trim();
    if(!bId){ alert('Isi Booking ID'); return; }
    const res = await fetch(`${API}/bookings/${bId}/room`, { method:'POST', headers:{'Accept':'application/json'} });
    const data = await res.json();
    if(!res.ok){ alert(data.message || 'Gagal'); return; }
    el('roomId').value = data.id;
    loadRoom();
}

async function loadRoom(){
    myEmail = el('email').value.trim();
    if(!myEmail){ alert('Isi email kamu dulu'); return; }
    const rId = el('roomId').value.trim();
    if(!rId){ alert('Isi Room ID'); return; }
    currentRoom = rId;
    lastId = 0;
    el('chatbox').innerHTML = '';
    el('roomCard').style.display = 'block';

    const res = await fetch(`${API}/rooms/${rId}/messages?email=${encodeURIComponent(myEmail)}`);
    const data = await res.json();
    if(!res.ok){ alert(data.message || 'Gagal'); return; }

    const r = data.room;
    el('roomTitle').textContent = `Room #${r.id} — ${r.customer_name} ↔ ${r.reader_name}`;
    el('addonBadge').innerHTML = r.has_addon ? `<span class="badge">⭐ Add-on: ${r.addons.join(', ')}</span>` : '';
    el('roomSub').textContent = `Booking #${r.booking_id} · status: ${r.status}`;

    renderMessages(data.messages);
    startPolling();
}

function renderMessages(msgs){
    const box = el('chatbox');
    msgs.forEach(m => {
        const mine = m.sender_role !== 'reader' ? (myEmailRole()==='customer') : (myEmailRole()==='reader');
        const isMine = isMessageMine(m);
        const div = document.createElement('div');
        div.className = 'msg ' + (isMine ? 'me' : 'them');
        div.innerHTML = `${escapeHtml(m.body)}<div class="meta">${m.sender_role} · ${fmt(m.created_at)} ${m.is_read?'· dibaca':''}</div>`;
        box.appendChild(div);
        if(m.id > lastId) lastId = m.id;
    });
    box.scrollTop = box.scrollHeight;
}

// Tentukan apakah pesan ini dari saya (berdasarkan role yang cocok dengan posisi saya di room dibiarkan sederhana)
let myRole = null;
function isMessageMine(m){ return myRole && m.sender_role === myRole; }
function myEmailRole(){ return myRole; }

async function sendMsg(){
    const body = el('msg').value.trim();
    if(!body || !currentRoom) return;
    const res = await fetch(`${API}/rooms/${currentRoom}/messages`, {
        method:'POST',
        headers:{'Content-Type':'application/json','Accept':'application/json'},
        body: JSON.stringify({ email: myEmail, body })
    });
    const data = await res.json();
    if(!res.ok){ alert(data.message || 'Gagal kirim'); return; }
    myRole = data.sender_role; // kita tahu peran kita dari pesan yang baru dikirim
    el('msg').value = '';
    renderMessages([data]);
}

async function poll(){
    if(!currentRoom) return;
    const res = await fetch(`${API}/rooms/${currentRoom}/messages?email=${encodeURIComponent(myEmail)}&after_id=${lastId}`);
    if(!res.ok) return;
    const data = await res.json();
    if(data.messages && data.messages.length) renderMessages(data.messages);
}

function startPolling(){
    if(pollTimer) clearInterval(pollTimer);
    pollTimer = setInterval(poll, 3000); // tidak real-time: cek tiap 3 detik
}

function fmt(s){ try { return new Date(s).toLocaleTimeString('id-ID',{hour:'2-digit',minute:'2-digit'}); } catch(e){ return s; } }
function escapeHtml(t){ const d=document.createElement('div'); d.textContent=t; return d.innerHTML; }
</script>
</body>
</html>
