<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Package;
use App\Models\testimonials;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AdminApiController extends Controller
{
    // GET /api/admin/stats  (dashboard admin)
    public function stats()
    {
        return response()->json([
            'revenue'        => (int) Booking::where('status', 'done')->sum('total_price'),
            'customer_count' => User::where('role', 'customer')->count(),
            'reader_count'   => User::where('role', 'reader')->count(),
        ]);
    }

    // GET /api/admin/report  (laporan admin)
    public function report()
    {
        $top = Booking::where('status', 'done')
            ->select('package_id', DB::raw('count(*) as total'))
            ->groupBy('package_id')
            ->orderByDesc('total')
            ->first();

        $topName = $top ? (Package::find($top->package_id)->name ?? '-') : '-';

        return response()->json([
            'total_revenue' => (int) Booking::where('status', 'done')->sum('total_price'),
            'total_booking' => Booking::count(),
            'done_count'    => Booking::where('status', 'done')->count(),
            'pending_count' => Booking::whereIn('status', ['pending', 'paid'])->count(),
            'top_package'   => $topName,
        ]);
    }

    // GET /api/admin/testimonials  (kelola testimoni)
    public function testimonials()
    {
        $data = testimonials::with('user')
            ->orderByDesc('id')
            ->get()
            ->map(function ($t) {
                return [
                    'id'           => $t->id,
                    'name'         => $t->user->name ?? 'Anonim',
                    'package_name' => $t->package_name ?: '-',
                    'message'      => $t->message ?: '-',
                    'rating'       => $t->rating ?? 0,
                    'created_at'   => optional($t->created_at)->format('Y-m-d H:i') ?? '-',
                ];
            });

        return response()->json($data);
    }
}
