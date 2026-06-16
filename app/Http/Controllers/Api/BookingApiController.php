<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\testimonials;
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
                $testi = testimonials::where('booking_id', $b->id)->first();
                return [
                    'id'             => $b->id,
                    'package_name'   => $b->package->name ?? 'Paket',
                    'booking_date'   => $b->booking_date,
                    'booking_time'   => $b->booking_time,
                    'status'         => $b->status,
                    'notes'          => $b->notes,
                    'reader_name'    => $b->reader->name ?? '-',
                    'answer'         => $b->reading_result,
                    'total_price'    => $b->total_price,
                    'type'           => $b->type,
                    'has_testimoni'  => $testi ? true : false,
                    'rating'         => $testi->rating ?? 0,
                    'review_message' => $testi->message ?? '',
                ];
            });

        return response()->json($bookings);
    }

    // GET /api/bookings/{id}  (detail untuk verifikasi QR reader)
    public function show($id)
    {
        $b = Booking::with('package')->find($id);

        if (!$b) {
            return response()->json(['message' => 'Booking tidak ditemukan'], 404);
        }

        return response()->json([
            'id'           => $b->id,
            'package_name' => $b->package->name ?? 'Paket',
            'booking_date' => $b->booking_date,
            'booking_time' => $b->booking_time,
            'status'       => $b->status,
            'total_price'  => $b->total_price,
            'name'         => $b->name,
            'email'        => $b->email,
        ]);
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

        $readerId = (!empty($data['reader_id']) && $data['reader_id'] != 0)
            ? $data['reader_id']
            : null;

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

    // PUT /api/bookings/{id}  (update status dan/atau hasil bacaan)
    // Dipakai oleh reader (start/processing, simpan jawaban, selesai) & admin (ubah status)
    public function update(Request $request, $id)
    {
        $booking = Booking::find($id);

        if (!$booking) {
            return response()->json(['message' => 'Booking tidak ditemukan'], 404);
        }

        $request->validate([
            'status'         => 'nullable|in:pending,paid,scheduled,processing,done,cancelled',
            'reading_result' => 'nullable|string',
        ]);

        if ($request->filled('status')) {
            $booking->status = $request->status;
        }
        if ($request->has('reading_result')) {
            $booking->reading_result = $request->reading_result;
        }

        $booking->save();

        return response()->json(['message' => 'Booking diperbarui']);
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

    // GET /api/reader/bookings?reader_id=...  (daftar booking + ringkasan untuk reader)
    public function readerBookings(Request $request)
    {
        $readerId = $request->query('reader_id');

        // Booking milik reader ini ATAU yang belum ditugaskan ke reader (null)
        $query = Booking::with(['package', 'user'])
            ->where(function ($q) use ($readerId) {
                $q->where('reader_id', $readerId)->orWhereNull('reader_id');
            });

        $all = (clone $query)->orderByDesc('id')->get();

        $done = $all->where('status', 'done');
        $today = now()->toDateString();
        $weekStart = now()->startOfWeek()->toDateString();

        $summary = [
            'total'         => (int) $done->sum('total_price'),
            'today'         => (int) $done->where('booking_date', $today)->sum('total_price'),
            'week'          => (int) $done->filter(fn ($b) => $b->booking_date >= $weekStart)->sum('total_price'),
            'done_count'    => $done->count(),
            'pending_count' => $all->whereIn('status', ['pending', 'paid'])->count(),
        ];

        $bookings = $all->where('status', '!=', 'cancelled')->values()->map(function ($b) {
            return [
                'id'            => $b->id,
                'customer_name' => $b->user->name ?? $b->name,
                'email'         => $b->email,
                'package_name'  => $b->package->name ?? 'Paket',
                'booking_date'  => $b->booking_date,
                'booking_time'  => $b->booking_time,
                'status'        => $b->status,
                'notes'         => $b->notes,
                'answer'        => $b->reading_result,
                'total_price'   => $b->total_price,
            ];
        });

        return response()->json([
            'summary'  => $summary,
            'bookings' => $bookings,
        ]);
    }

    // GET /api/readers  (daftar reader untuk dipilih customer)
    public function readers()
    {
        return response()->json(
            User::where('role', 'reader')->get(['id', 'name', 'is_online', 'lat', 'lng'])
        );
    }

    // PUT /api/reader/online  (set status online/offline reader)
    public function setOnline(Request $request)
    {
        $data = $request->validate([
            'email'     => 'required|email|exists:users,email',
            'is_online' => 'required|boolean',
        ]);

        User::where('email', $data['email'])->update(['is_online' => $data['is_online']]);

        return response()->json(['message' => 'Status diperbarui']);
    }

    // GET /api/admin/bookings  (semua booking untuk admin)
    public function adminBookings()
    {
        $bookings = Booking::with(['package', 'reader', 'user'])
            ->orderByDesc('id')
            ->get()
            ->map(function ($b) {
                return [
                    'id'             => $b->id,
                    'customer_name'  => $b->user->name ?? $b->name,
                    'email'          => $b->email,
                    'package_name'   => $b->package->name ?? '-',
                    'reader_name'    => $b->reader->name ?? '-',
                    'booking_date'   => $b->booking_date,
                    'booking_time'   => $b->booking_time,
                    'status'         => $b->status,
                    'total_price'    => $b->total_price,
                    'payment_status' => $b->payment_status,
                ];
            });

        return response()->json($bookings);
    }
}
