<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\ChatMessage;
use App\Models\ChatRoom;
use App\Models\User;
use Illuminate\Http\Request;

class ChatApiController extends Controller
{
    // POST /api/bookings/{id}/room  (buat atau ambil room untuk sebuah booking)
    // body: { email }  -> dipakai untuk memastikan pemanggil ikut di booking ini
    public function ensureRoom(Request $request, $bookingId)
    {
        $booking = Booking::with('addons')->find($bookingId);

        if (!$booking) {
            return response()->json(['message' => 'Booking tidak ditemukan'], 404);
        }

        $hasAddon = $booking->addons->isNotEmpty();

        $room = ChatRoom::firstOrCreate(
            ['booking_id' => $booking->id],
            [
                'customer_id' => $booking->user_id,
                'reader_id'   => $booking->reader_id,
                'has_addon'   => $hasAddon,
                'status'      => 'open',
            ]
        );

        // Selaraskan reader & flag add-on bila booking berubah setelah room dibuat
        $room->fill([
            'reader_id' => $booking->reader_id,
            'has_addon' => $hasAddon,
        ])->save();

        return response()->json($this->roomPayload($room->fresh(['booking.addons', 'customer', 'reader'])));
    }

    // GET /api/rooms?email=...  (daftar room milik customer ATAU reader)
    public function index(Request $request)
    {
        $email = $request->query('email');
        $user = User::where('email', $email)->first();

        if (!$user) {
            return response()->json(['message' => 'User tidak ditemukan'], 404);
        }

        $rooms = ChatRoom::with(['booking.addons', 'customer', 'reader', 'lastMessage'])
            ->where('customer_id', $user->id)
            ->orWhere('reader_id', $user->id)
            ->orderByDesc('updated_at')
            ->get()
            ->map(function ($room) use ($user) {
                $payload = $this->roomPayload($room);
                $payload['unread_count'] = $room->messages()
                    ->whereNull('read_at')
                    ->where('sender_id', '!=', $user->id)
                    ->count();
                $last = $room->lastMessage;
                $payload['last_message'] = $last->body ?? null;
                $payload['last_message_at'] = $last->created_at ?? null;
                return $payload;
            });

        return response()->json($rooms);
    }

    // GET /api/rooms/{id}/messages?email=...&after_id=...
    // Semua pesan tercatat; after_id dipakai untuk polling (ambil yang baru saja)
    public function messages(Request $request, $roomId)
    {
        $room = ChatRoom::with(['booking.addons', 'customer', 'reader'])->find($roomId);

        if (!$room) {
            return response()->json(['message' => 'Room tidak ditemukan'], 404);
        }

        $email = $request->query('email');
        $user = User::where('email', $email)->first();

        $query = $room->messages()->orderBy('id');

        if ($request->filled('after_id')) {
            $query->where('id', '>', (int) $request->query('after_id'));
        }

        $messages = $query->get();

        // Tandai pesan lawan bicara sebagai sudah dibaca
        if ($user) {
            $room->messages()
                ->whereNull('read_at')
                ->where('sender_id', '!=', $user->id)
                ->update(['read_at' => now()]);
        }

        return response()->json([
            'room'     => $this->roomPayload($room),
            'messages' => $messages->map(fn ($m) => $this->messagePayload($m, $room)),
        ]);
    }

    // POST /api/rooms/{id}/messages  body: { email, body }
    public function send(Request $request, $roomId)
    {
        $room = ChatRoom::with('booking')->find($roomId);

        if (!$room) {
            return response()->json(['message' => 'Room tidak ditemukan'], 404);
        }

        if ($room->status === 'closed') {
            return response()->json(['message' => 'Room sudah ditutup'], 422);
        }

        $data = $request->validate([
            'email' => 'required|email|exists:users,email',
            'body'  => 'required|string|max:2000',
        ]);

        $user = User::where('email', $data['email'])->first();

        // Tentukan peran pengirim berdasarkan posisinya di room
        if ($user->id === $room->customer_id) {
            $role = 'customer';
        } elseif ($user->id === $room->reader_id) {
            $role = 'reader';
        } elseif (($user->role ?? null) === 'admin') {
            $role = 'admin';
        } else {
            return response()->json(['message' => 'Anda bukan peserta room ini'], 403);
        }

        $message = ChatMessage::create([
            'room_id'     => $room->id,
            'sender_id'   => $user->id,
            'sender_role' => $role,
            'body'        => $data['body'],
        ]);

        // Sentuh room agar urutan daftar terupdate
        $room->touch();

        return response()->json($this->messagePayload($message, $room), 201);
    }

    // PUT /api/rooms/{id}/close  (reader/admin menutup room)
    public function close($roomId)
    {
        $room = ChatRoom::find($roomId);

        if (!$room) {
            return response()->json(['message' => 'Room tidak ditemukan'], 404);
        }

        $room->update(['status' => 'closed']);

        return response()->json(['message' => 'Room ditutup']);
    }

    // ---- helpers ----

    private function roomPayload(ChatRoom $room): array
    {
        $hasAddon = $room->booking
            ? $room->booking->addons->isNotEmpty()
            : $room->has_addon;

        return [
            'id'            => $room->id,
            'booking_id'    => $room->booking_id,
            'status'        => $room->status,
            'customer_id'   => $room->customer_id,
            'customer_name' => $room->customer->name ?? '-',
            'reader_id'     => $room->reader_id,
            'reader_name'   => $room->reader->name ?? '-',
            // Penanda add-on untuk badge di UI
            'has_addon'     => (bool) $hasAddon,
            'addons'        => $room->booking
                ? $room->booking->addons->pluck('name')->values()
                : [],
        ];
    }

    private function messagePayload(ChatMessage $m, ChatRoom $room): array
    {
        return [
            'id'          => $m->id,
            'room_id'     => $m->room_id,
            'sender_id'   => $m->sender_id,
            'sender_role' => $m->sender_role,
            'body'        => $m->body,
            'is_read'     => $m->read_at !== null,
            'created_at'  => $m->created_at,
            // Penanda add-on ikut menempel di tiap pesan, memudahkan UI
            'has_addon'   => (bool) ($room->has_addon),
        ];
    }
}
