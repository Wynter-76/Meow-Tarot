<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\ChatMessage;
use App\Models\ChatRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    // GET /rooms  — daftar semua room milik user yang login (customer / reader)
    public function index()
    {
        $uid = Auth::id();
        $user = Auth::user();

        $rooms = ChatRoom::with(['booking.package', 'booking.addons', 'customer', 'reader', 'lastMessage'])
            ->where(function ($q) use ($uid, $user) {
                $q->where('customer_id', $uid)
                  ->orWhere('reader_id', $uid);

                // Reader/admin juga melihat room yang belum punya reader (bisa diambil)
                if (in_array($user->role, ['reader', 'admin'])) {
                    $q->orWhereNull('reader_id');
                }
            })
            ->orderByDesc('updated_at')
            ->get();

        return view('chat.index', compact('rooms'));
    }

    // GET /rooms/booking/{id}  — buat/buka room dari sebuah booking, lalu masuk ke room
    public function openByBooking($bookingId)
    {
        $booking = Booking::with('addons')->findOrFail($bookingId);
        $user = Auth::user();

        $this->authorizeBooking($booking, $user);

        // Reader membuka booking yang belum punya reader → reader ini "mengambil" booking
        if ($user->role === 'reader' && empty($booking->reader_id)) {
            $booking->update(['reader_id' => $user->id]);
            $booking->refresh();
        }

        $room = ChatRoom::firstOrCreate(
            ['booking_id' => $booking->id],
            [
                'customer_id' => $booking->user_id,
                'reader_id'   => $booking->reader_id,
                'has_addon'   => $booking->addons->isNotEmpty(),
                'status'      => 'open',
            ]
        );

        // Selaraskan bila reader / add-on berubah setelah room dibuat
        $room->update([
            'reader_id' => $booking->reader_id,
            'has_addon' => $booking->addons->isNotEmpty(),
        ]);

        return redirect('/rooms/' . $room->id);
    }

    // GET /rooms/{id}  — halaman chat
    public function show($roomId)
    {
        $user = Auth::user();
        $room = ChatRoom::with(['booking.package', 'booking.addons', 'customer', 'reader'])->findOrFail($roomId);

        $this->authorizeRoom($room, $user);

        // Tandai pesan lawan bicara sebagai sudah dibaca
        ChatMessage::where('room_id', $room->id)
            ->whereNull('read_at')
            ->where('sender_id', '!=', $user->id)
            ->update(['read_at' => now()]);

        $messages = $room->messages()->orderBy('id')->get();

        return view('chat.room', compact('room', 'messages'));
    }

    // POST /rooms/{id}/send  — kirim pesan (AJAX)
    public function send(Request $request, $roomId)
    {
        $user = Auth::user();
        $room = ChatRoom::findOrFail($roomId);

        $this->authorizeRoom($room, $user);

        if ($room->status === 'closed') {
            return response()->json(['message' => 'Room sudah ditutup'], 422);
        }

        $data = $request->validate([
            'body' => 'required|string|max:2000',
        ]);

        $message = ChatMessage::create([
            'room_id'     => $room->id,
            'sender_id'   => $user->id,
            'sender_role' => $this->roleInRoom($room, $user),
            'body'        => $data['body'],
        ]);

        $room->touch();

        return response()->json($this->messagePayload($message, $user->id));
    }

    // GET /rooms/{id}/fetch?after_id=  — polling pesan baru (JSON)
    public function fetch(Request $request, $roomId)
    {
        $user = Auth::user();
        $room = ChatRoom::findOrFail($roomId);

        $this->authorizeRoom($room, $user);

        $query = $room->messages()->orderBy('id');
        if ($request->filled('after_id')) {
            $query->where('id', '>', (int) $request->query('after_id'));
        }
        $messages = $query->get();

        ChatMessage::where('room_id', $room->id)
            ->whereNull('read_at')
            ->where('sender_id', '!=', $user->id)
            ->update(['read_at' => now()]);

        return response()->json([
            'messages' => $messages->map(fn ($m) => $this->messagePayload($m, $user->id)),
        ]);
    }

    // ---- helpers ----

    private function authorizeBooking(Booking $booking, $user): void
    {
        $allowed = $booking->user_id === $user->id
            || $booking->reader_id === $user->id
            || $user->role === 'admin'
            || ($user->role === 'reader' && empty($booking->reader_id));

        abort_unless($allowed, 403, 'Anda tidak berhak mengakses room ini');
    }

    private function authorizeRoom(ChatRoom $room, $user): void
    {
        $allowed = $room->customer_id === $user->id
            || $room->reader_id === $user->id
            || $user->role === 'admin'
            || ($user->role === 'reader' && empty($room->reader_id));

        abort_unless($allowed, 403, 'Anda tidak berhak mengakses room ini');
    }

    private function roleInRoom(ChatRoom $room, $user): string
    {
        if ($room->customer_id === $user->id) return 'customer';
        if ($room->reader_id === $user->id)   return 'reader';
        if ($user->role === 'admin')          return 'admin';
        return $user->role ?? 'customer';
    }

    private function messagePayload(ChatMessage $m, $viewerId): array
    {
        return [
            'id'          => $m->id,
            'body'        => $m->body,
            'sender_role' => $m->sender_role,
            'is_mine'     => $m->sender_id === $viewerId,
            'is_read'     => $m->read_at !== null,
            'time'        => optional($m->created_at)->format('H:i'),
        ];
    }
}
