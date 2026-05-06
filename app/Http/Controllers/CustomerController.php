<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\Package;
use App\Models\Booking;
use App\Models\Question;
use App\Models\File;
use App\Models\Addon;
use App\Models\testimonials;
use App\Mail\ContactMail;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function home()
    {
        return view('customer.index_cust');
    }

    public function service()
    {
        $tarot = Package::where('category','tarot')->get();
        $palm = Package::where('category','palm')->get();
        $chat = Package::where('category','chat')->get();
        $call = Package::where('category','call')->get();

        return view('customer.service_cust', compact('tarot','palm','chat','call'));
    }

    public function testimonial()
    {
        $testimonials = testimonials::with('user')
                        ->where('is_approved', true)
                        ->latest()
                        ->get();

        return view('customer.testimonial_cust', compact('testimonials'));
    }

    public function about()
    {
        return view('customer.about_cust');
    }

    public function contact()
    {
        return view('customer.contact_cust');
    }


    public function tarotOnline($id)
    {
        $package = Package::findOrFail($id);
        $addons = Addon::all();

        return view('customer.tarotonline', compact('package','addons'));
    }

    public function tarotOffline($id)
    {
        $package = Package::findOrFail($id);
        return view('customer.tarotoffline', compact('package'));
    }

    public function palmOnline($id)
    {
        $package = Package::findOrFail($id);
        $addons = Addon::all();
        return view('customer.palmonline', compact('package','addons'));
    }

    public function palmOffline($id)
    {
        $package = Package::findOrFail($id);
        $addons = Addon::all();
        return view('customer.palmoffline', compact('package'));
    }

    public function chat($id)
    {
        $package = Package::findOrFail($id);
        $addons = Addon::all();
        return view('customer.formchat', compact('package','addons'));
    }

    public function call($id)
    {
        $package = Package::findOrFail($id);
        $addons = Addon::all();
        return view('customer.formcall', compact('package','addons'));
    }

    public function sendContact(Request $request)
    {
        $data = [
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone ?? '-',
                    'message' => $request->message,
                ];
        Mail::to('muafan99@gmail.com')->send(new ContactMail($data));

        return back()->with('success','Pesan berhasil dikirim!');
    }

    public function storeBooking(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
        ]);

        $package = Package::findOrFail($request->package_id);
        if ($request->type == 'online') {
            $booking_date = now()->toDateString();
            $booking_time = now()->format('H:i:s');
        } else {
            $booking_date = $request->booking_date;
            $booking_time = $request->booking_time;
        }

        $booking = Booking::create([
            'user_id' => Auth::id(),
            'package_id' => $package->id,
            'type' => $request->type,
            'booking_date' => $booking_date,
            'booking_time' => $booking_time,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'status' => 'pending',
            'payment_status' => 'pending',
            'total_price' => $package->price
        ]);

        $total = $package->price;

        if ($package->category == 'tarot') {
            foreach ($request->questions ?? [] as $q) {
                Question::create([
                    'booking_id' => $booking->id,
                    'question' => $q
                ]);
            }
        }

        if ($package->category == 'palm' && $request->hasFile('file')) {
            $path = $request->file('file')->store('palm');

            File::create([
                'booking_id' => $booking->id,
                'file_path' => $path
            ]);
        }

        foreach ($request->addons ?? [] as $addon_id) {
            $addon = Addon::find($addon_id);

            if ($addon) {
                $booking->addons()->attach($addon_id, [
                    'price' => $addon->price
                ]);

                $total += $addon->price;
            }
        }

        $booking->update([
            'total_price' => $total
        ]);

        return redirect('/payment/'.$booking->id);
    }

    public function payment($id)
    {
        $booking = Booking::findOrFail($id);

        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
        $amount = (int) $booking->total_price;

        if ($amount < 1) {
            abort(400, 'Total price tidak valid');
        }

        $params = [
            'transaction_details' => [
                'order_id' => 'BOOK-'.$booking->id.'-'.time(),
                'gross_amount' => (int) $booking->total_price,
            ],
            'customer_details' => [
                'first_name' => $booking->name,
                'email' => $booking->email,
            ],
            'item_details' => [
                [
                    'id' => 'PKG-'.$booking->package_id,
                    'price' => (int) $booking->total_price,
                    'quantity' => 1,
                    'name' => 'Booking '.$booking->type
                ]
            ],
            'enabled_payments' => ['gopay','bank_transfer']
        ];
        $snapToken = Snap::getSnapToken($params);
        return view('customer.payment', compact('booking','snapToken'));
    }

    public function callback(Request $request)
    {
        $notif = new Notification();

        $order_id = $notif->order_id;
        $status = $notif->transaction_status;

        // ambil id booking dari order_id
        // format: BOOK-{$id}-time
        $id = explode('-', $order_id)[1];

        $booking = Booking::find($id);

        if (!$booking) return;

        if ($status == 'settlement') {
            $booking->update([
                'payment_status' => 'paid',
                'status' => 'scheduled'
            ]);
        } elseif ($status == 'pending') {
            $booking->update([
                'payment_status' => 'pending'
            ]);
        } elseif ($status == 'expire') {
            $booking->update([
                'payment_status' => 'failed'
            ]);
        }
    }

    public function storeTestimonial(Request $request)
    {
        testimonials::create([
            'user_id' => Auth::id(),
            'message' => $request->message,
            'is_approved' => false
        ]);
        
        return back()->with('success','Testimoni dikirim!');
    }

    public function history()
    {
        $data = Booking::where('user_id', Auth::id())->get();
        return view('customer.history', compact('data'));
    }
}