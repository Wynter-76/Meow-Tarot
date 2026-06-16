<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BookingApiController extends Controller
{
    // GET /api/bookings?email=...  (riwayat customer)
    public function index(Request $request)
    {
        $email = $request->query('email');

        $bookings = Booking::with(['package', 'reader'])
            ->where('email', $email)
            ->orderByDesc('id')
            ->get()
            ->map(function ($b) {
                return [
                    'id'           => $b->id,
                    'package_name' => $b->package->name ?? 'Paket',
                    'booking_date' => $b->booking_date,
                    'booking_time' => $b->booking_time,
                    'status'       => $b->status,
                    'notes'        => $b->notes,
                    'reader_name'  => $b->reader->name ?? '-',
                    'answer'       => $b->reading_result,
                    'total_price'  => $b->total_price,
                    'type'         => $b->type,
                ];
            });

        return response()->json($bookings);
    }

    // POST /api/bookings  (buat pesanan dari mobile)
    public function store(Request $request)
    {
        $data = $request->validate([
            'email'        => 'required|email|exists:users,email',
            'package_id'   => 'required|exists:packages,id',
            'reader_id'    => 'nullable',
            'type'         => 'required|in:online,offline',
            'booking_date' => 'required|string',
            'booking_time' => 'required|string',
            'name'         => 'required|string|max:255',
            'phone'        => 'required|string|max:30',
            'total_price'  => 'required|integer|min:0',
            'notes'        => 'nullable|string',
        ]);

        $user = User::where('email', $data['email'])->first();

        // reader_id: 0/null = tidak memilih reader
        $readerId = (!empty($data['reader_id']) && $data['reader_id'] != 0)
            ? $data['reader_id']
            : null;

        // Mobile mengirim tanggal format d/m/Y -> ubah ke Y-m-d
        try {
            $bookingDate = Carbon::createFromFormat('j/n/Y', $data['booking_date'])->toDateString();
        } catch (\Exception $e) {
            $bookingDate = now()->toDateString();
        }

        $booking = Booking::create([
            'user_id'        => $user->id,
            'package_id'     => $data['package_id'],
            'reader_id'      => $readerId,
            'type'           => $data['type'],
            'booking_date'   => $bookingDate,
            'booking_time'   => $data['booking_time'],
            'name'           => $data['name'],
            'email'          => $data['email'],
            'phone'          => $data['phone'],
            'status'         => 'pending',
            'payment_status' => 'pending',
            'total_price'    => $data['total_price'],
            'notes'          => $data['notes'] ?? null,
        ]);

        return response()->json([
            'id'      => $booking->id,
            'message' => 'Booking berhasil dibuat',
        ], 201);
    }

    // PUT /api/bookings/{id}/cancel  (customer membatalkan)
    public function cancel($id)
    {
        $booking = Booking::find($id);

        if (!$booking) {
            return response()->json(['message' => 'Booking tidak ditemukan'], 404);
        }

        $booking->update(['status' => 'cancelled']);

        return response()->json(['message' => 'Pesanan dibatalkan']);
    }

    // GET /api/readers  (daftar reader untuk dipilih customer)
    public function readers()
    {
        return response()->json(
            User::where('role', 'reader')->get(['id', 'name', 'is_online', 'lat', 'lng'])
        );
    }
}
