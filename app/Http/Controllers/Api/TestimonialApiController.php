<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\testimonials;
use App\Models\User;
use Illuminate\Http\Request;

class TestimonialApiController extends Controller
{
    // POST /api/testimonials  (customer menulis ulasan untuk sebuah booking)
    public function store(Request $request)
    {
        $data = $request->validate([
            'email'        => 'required|email|exists:users,email',
            'booking_id'   => 'required|integer',
            'package_name' => 'nullable|string',
            'rating'       => 'required|integer|min:1|max:5',
            'message'      => 'nullable|string',
        ]);

        $user = User::where('email', $data['email'])->first();

        $testi = testimonials::create([
            'user_id'      => $user->id,
            'booking_id'   => $data['booking_id'],
            'package_name' => $data['package_name'] ?? null,
            'rating'       => $data['rating'],
            'message'      => $data['message'] ?? '',
            'is_approved'  => false,
        ]);

        return response()->json(['id' => $testi->id, 'message' => 'Ulasan terkirim'], 201);
    }
}
