<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\Booking;
use App\Mail\HasilReadingMail;

class ReaderController extends Controller
{
    public function dashboard()
    {
        $bookingMasuk = Booking::where('status','pending')->count();
        $diproses     = Booking::where('status','process')->count();
        $selesai      = Booking::where('status','done')->count();

        $latest = Booking::with('package')
                    ->latest()
                    ->take(5)
                    ->get();

        return view('reader.reader_dashboard', compact(
            'bookingMasuk',
            'diproses',
            'selesai',
            'latest'
        ));
    }

    public function bookingmasuk()
    {
        $booking = Booking::whereIn('status', ['scheduled','processing'])->get();

        return view('reader.booking', compact('booking'));
    }

    public function start($id)
    {
        $booking = Booking::findOrFail($id);

        $booking->update([
            'status' => 'processing'
        ]);

        return back()->with('success','Booking diproses');
    }

    public function selesai($id)
    {
        Booking::findOrFail($id)->update([
            'status' => 'done'
        ]);

        return back()->with('success','Booking selesai');
    }

    public function kirimhasil($id)
    {
        $booking = Booking::with('package')->findOrFail($id);
        return view('reader.kirimhasil', compact('booking'));
    }

    public function simpanhasil(Request $request, $id)
    {
        $booking = Booking::with(['package','questions'])->findOrFail($id);

        $booking->update([
            'reading_result' => $request->hasil,
            'status' => 'done'
        ]);

        Mail::to($booking->email)->send(new HasilReadingMail($booking));

        return redirect('/reader/riwayat');
    }

    public function riwayat()
    {
        $riwayat = Booking::with('package')
                    ->whereIn('status',['process','done'])
                    ->latest()
                    ->get();

        return view('reader.riwayat', compact('riwayat'));
    }

    public function detail($id)
    {
        $booking = Booking::with([
            'package',
            'user',
            'addons',
            'questions',
            'file'
        ])->findOrFail($id);

        return view('reader.detail', compact('booking'));
    }

}