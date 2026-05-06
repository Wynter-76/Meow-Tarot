<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Package;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\User;
use App\Models\testimonials;
use Illuminate\Support\Facades\Hash;


class AdminController extends Controller
{
    public function packages()
    {
        $paket = Package::all();
        return view('admin.kelolapaket', compact('paket'));
    }

    public function storePackage(Request $request)
    {
        Package::create($request->all());
        return back()->with('success', 'Package dibuat');
    
    }

    public function updatePackage(Request $request, $id)
    {
        $paket = Package::findOrFail($id);
        $paket->update($request->all());
        return back()->with('success', 'Package diupdate');
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
}