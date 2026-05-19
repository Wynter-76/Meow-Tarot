<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Package;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\User;
use App\Models\testimonials;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\LaporanExport;
use Maatwebsite\Excel\Facades\Excel;


class AdminController extends Controller
{
    public function packages()
    {
        $paket = Package::all();
        return view('admin.kelolapaket', compact('paket'));
    }

    public function storePackage(Request $request)
    {
        $data = $request->all();
        
        // Logika memisahkan tipe layanan online/offline
        if ($request->layanan_type == 'online') {
            $data['is_online'] = 1;
            $data['is_offline'] = 0;
        } else {
            $data['is_online'] = 0;
            $data['is_offline'] = 1;
        }

        Package::create($data);
        return back()->with('success', 'Package berhasil dibuat');
    }

    public function updatePackage(Request $request, $id)
    {
        $paket = Package::findOrFail($id);
        $data = $request->all();
        
        // Logika memisahkan tipe layanan online/offline saat update
        if ($request->layanan_type == 'online') {
            $data['is_online'] = 1;
            $data['is_offline'] = 0;
        } else {
            $data['is_online'] = 0;
            $data['is_offline'] = 1;
        }

        $paket->update($data);
        return back()->with('success', 'Package berhasil diupdate');
    }

    public function deletePackage($id)
    {
        Package::findOrFail($id)->delete();
        return back()->with('success', 'Package dihapus');
    }

    public function bookings()
    {
        $booking = Booking::with(['user','package','payment'])->get();
        return view('admin.databooking', compact('booking'));
    }

    public function payments()
    {
        $data = Payment::with('booking')->get();
        return view('admin.payments', compact('data'));
    }


    public function users()
    {
        $users = User::all();
        return view('admin.kelolauser', compact('users'));
    }

    public function storeUser(Request $request)
    {
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role
        ]);

        return back()->with('success','User ditambah');
    }

    public function updateUser(Request $request, $id)
    {
        User::findOrFail($id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role
        ]);

        return back()->with('success','User diupdate');
    }

    public function deleteUser($id)
    {
        User::findOrFail($id)->delete();
        return back()->with('Succes','User dihapus');
    }

    public function deleteTestimoni($id)
    {
        testimonials::findOrFail($id)->delete();
        return back()->with('success', 'Testimoni dihapus');
    }

    public function approveTestimonial($id)
    {
        testimonials::findOrFail($id)->update([
            'is_approved' => true
        ]);

        return back();
    }

    public function testimonial()
    {
        $data = testimonials::with('user')->get();
        return view('admin.testimonials', compact('data'));
    }

    public function dashboard()
    {
        $totalUser = User::count();
        $totalBooking = Booking::count();
        $totalPackage = Package::count();
        $pending = Booking::where('status','pending')->count();

        $latest = Booking::latest()->take(5)->get();

        return view('admin.admin_dashboard', compact(
            'totalUser',
            'totalBooking',
            'totalPackage',
            'pending',
            'latest'
        ));
    }
    public function approve($id)
    {
        Booking::findOrFail($id)->update([
            'status' => 'scheduled'
        ]);

        return back();
    }
    public function reject($id)
    {
        Booking::findOrFail($id)->update([
            'status' => 'cancelled'
        ]);

        return back();
    }
    public function databooking()
    {
        $data = Booking::with(['user','package'])
                        ->where('status','pending')
                        ->get();

        return view('admin.databooking', compact('data'));
    }

    public function laporan()
    {
        // Summary cards
        $totalBooking     = Booking::count();
        $totalRevenue     = Booking::where('payment_status', 'paid')->sum('total_price');
        $totalPaid        = Booking::where('payment_status', 'paid')->count();
        $totalPending     = Booking::where('payment_status', 'pending')->count();
        $totalCancelled   = Booking::where('status', 'cancelled')->count();
        $totalScheduled   = Booking::where('status', 'scheduled')->count();

        // Paket terpopuler
        $topPackage = Booking::select('package_id', DB::raw('count(*) as total'))
                        ->groupBy('package_id')
                        ->orderByDesc('total')
                        ->with('package')
                        ->first();

        // Customer terbanyak order
        $topCustomer = Booking::select('user_id', DB::raw('count(*) as total'))
                        ->groupBy('user_id')
                        ->orderByDesc('total')
                        ->with('user')
                        ->first();

        // List semua transaksi
        $bookings = Booking::with(['user', 'package'])
                        ->latest()
                        ->get();

        return view('admin.laporan', compact(
            'totalBooking', 'totalRevenue', 'totalPaid',
            'totalPending', 'totalCancelled', 'totalScheduled',
            'topPackage', 'topCustomer', 'bookings'
        ));
    }
    public function exportPdf()
    {
        $bookings = Booking::with(['user', 'package'])->latest()->get();
        $totalRevenue = Booking::where('payment_status', 'paid')->sum('total_price');

        $pdf = Pdf::loadView('admin.laporan_pdf', compact('bookings', 'totalRevenue'))
                ->setPaper('a4', 'landscape');

        return $pdf->download('laporan-meow-tarot.pdf');
    }

    public function exportExcel()
    {
        return Excel::download(new LaporanExport, 'laporan-meow-tarot.xlsx');
    }
}