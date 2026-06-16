<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\testimonials;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileApiController extends Controller
{
    // GET /api/profile?email=...
    public function show(Request $request)
    {
        $email = $request->query('email');
        $user = User::where('email', $email)->first();

        if (!$user) {
            return response()->json(['message' => 'User tidak ditemukan'], 404);
        }

        // Statistik dihitung dari data server (sumber kebenaran)
        $readingsDone = Booking::where('user_id', $user->id)
            ->where('status', 'done')->count();

        $testimonialsCount = testimonials::where('user_id', $user->id)->count();

        $readerSessions = Booking::where('reader_id', $user->id)
            ->where('status', 'done')->count();

        $readerEarning = (int) Booking::where('reader_id', $user->id)
            ->where('status', 'done')->sum('total_price');

        return response()->json([
            'id'                 => $user->id,
            'name'               => $user->name,
            'email'              => $user->email,
            'role'               => $user->role,
            'foto'               => $user->foto,
            'lat'                => $user->lat,
            'lng'                => $user->lng,
            'is_online'          => (bool) $user->is_online,
            // statistik customer
            'total_readings'     => $readingsDone,
            'testimonials_count' => $testimonialsCount,
            // statistik reader
            'total_sessions'     => $readerSessions,
            'total_earning'      => $readerEarning,
        ]);
    }

    // POST /api/profile/update
    public function update(Request $request)
    {
        $data = $request->validate([
            'email'    => 'required|email|exists:users,email',
            'name'     => 'required|string|max:255',
            'password' => 'nullable|string|min:6',
            'foto'     => 'nullable|string',
            'lat'      => 'nullable|numeric',
            'lng'      => 'nullable|numeric',
        ]);

        $user = User::where('email', $data['email'])->first();

        $user->name = $data['name'];

        if ($request->filled('password')) {
            $user->password = $data['password']; // di-hash otomatis oleh cast
        }
        if ($request->filled('foto')) {
            $user->foto = $data['foto'];
        }
        if ($request->has('lat')) {
            $user->lat = $data['lat'];
        }
        if ($request->has('lng')) {
            $user->lng = $data['lng'];
        }

        $user->save();

        return response()->json(['message' => 'Profil diperbarui']);
    }
}
