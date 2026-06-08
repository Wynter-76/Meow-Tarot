<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\Package;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Question;
use App\Models\File;
use App\Models\Addon;
use App\Models\testimonials;
use App\Mail\ContactMail;
use App\Models\daily_card;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;
use Midtrans\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CustomerController extends Controller
{
    public function home()
    {
        $today = (int) date('j');
        $dailyCard = daily_card::where('day', $today)->first();

        return view('customer.index_cust', compact('dailyCard'));
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

    public function checkBookedTime(Request $request)
    {
        // 1. Tangkap tanggal yang dikirim sama JavaScript di browser
        $date = $request->date; 

        if (!$date) {
            return response()->json([]);
        }

        // 2. Cek ke database tabel bookings
        $bookedTimes = Booking::where('booking_date', $date)
            ->whereIn('status', ['scheduled', 'done']) // Hanya comot yang statusnya Terjadwal atau Selesai
            ->where('payment_status', 'paid')         // Dan yang pembayarannya sudah Lunas (Approved)
            ->selectRaw("DATE_FORMAT(booking_time, '%H:%i') as jam_bersih") // Potong '16:00:00' jadi '16:00'
            ->pluck('jam_bersih')
            ->toArray(); // Di-convert jadi array biar hasilnya: ["16:00"]

        // 3. Kirim balik list jam yang hangus tadi ke JavaScript dalam bentuk JSON
        return response()->json($bookedTimes);
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
            $path = $request->file('file')->store('palm', 'public');

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

        $orderId = 'BOOK-'.$booking->id.'-'.time();

        $params = [

        'transaction_details' => [
            'order_id' => $orderId,
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

        'enabled_payments' => [
            'credit_card',
            'gopay',
            'bank_transfer',
            'qris'
        ],

        'callbacks' => [
            'finish' => url('/service'),      // Jika sukses bayar, redirect ke Home
            'unfinish' => url('/service'),    // Jika user nutup pop-up sebelum bayar, balikin ke Home
            'error' => url('/service')        // Jika pembayaran error, balikin ke Home
        ]
    ];
        $snapToken = Snap::getSnapToken($params);

        Payment::updateOrCreate(
            ['order_id' => $orderId],
            [
                'booking_id'         => $booking->id,
                'transaction_status' => 'pending',
                'gross_amount'       => $amount,
            ]
        );

        return view('customer.payment', compact('booking','snapToken'));
    }

    public function callback(Request $request)
    {

        Log::info('[MIDTRANS CALLBACK] Hit diterima', [
            'ip'      => $request->ip(),
            'payload' => $request->all(),
        ]);

        $serverKey = config('midtrans.server_key');

        if (empty($serverKey)) {
            Log::error('[MIDTRANS CALLBACK] MIDTRANS_SERVER_KEY kosong di .env');
            return response()->json(['message' => 'Server key not configured'], 500);
        }

        // Ambil data dari request Midtrans
        $orderId      = $request->input('order_id');
        $statusCode   = $request->input('status_code');
        $grossAmount  = $request->input('gross_amount');
        $signatureKey = $request->input('signature_key');

        if (!$orderId || !$statusCode || !$grossAmount || !$signatureKey) {
            Log::warning('[MIDTRANS CALLBACK] Field penting kosong', $request->all());
            return response()->json(['message' => 'Bad payload'], 400);
        }

        // Coba beberapa format gross_amount karena Midtrans kadang
        // pakai "150000" dan kadang "150000.00" untuk hashing signature
        $expectedAsIs    = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);
        $expectedBulat   = hash('sha512', $orderId . $statusCode . number_format((float)$grossAmount, 0, '.', '') . $serverKey);
        $expectedDecimal = hash('sha512', $orderId . $statusCode . number_format((float)$grossAmount, 2, '.', '') . $serverKey);

        $valid = in_array($signatureKey, [$expectedAsIs, $expectedBulat, $expectedDecimal], true);

        if (!$valid) {
            Log::warning('[MIDTRANS CALLBACK] Signature INVALID', [
                'order_id'        => $orderId,
                'gross_amount'    => $grossAmount,
                'signature_in'    => $signatureKey,
                'expected_as_is'  => $expectedAsIs,
                'expected_bulat'  => $expectedBulat,
                'expected_decim'  => $expectedDecimal,
            ]);
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        // Ambil booking ID dari order_id (format: BOOK-{id}-timestamp)
        $parts = explode('-', $orderId);
        $bookingId = $parts[1] ?? null;

        if (!$bookingId) {
            Log::warning('[MIDTRANS CALLBACK] order_id tidak valid', ['order_id' => $orderId]);
            return response()->json(['message' => 'Invalid order id'], 400);
        }

        $booking = Booking::find($bookingId);

        if (!$booking) {
            Log::warning('[MIDTRANS CALLBACK] Booking tidak ketemu', ['booking_id' => $bookingId]);
            return response()->json(['message' => 'Booking not found'], 404);
        }

        $transactionStatus = $request->input('transaction_status');
        $fraudStatus       = $request->input('fraud_status');
        $paymentType       = $request->input('payment_type');

        // Pembayaran sukses → cuma tandai payment_status=paid.
        // Booking status tetap 'pending' menunggu approve admin di /admin/databooking
        if ($transactionStatus == 'settlement' || ($transactionStatus == 'capture' && $fraudStatus == 'accept')) {
            $booking->update([
                'payment_status' => 'paid',
            ]);
        } elseif (in_array($transactionStatus, ['cancel', 'deny', 'expire'])) {
            $booking->update([
                'payment_status' => 'failed',
                'status'         => 'cancelled'
            ]);
        } elseif ($transactionStatus == 'pending') {
            $booking->update([
                'payment_status' => 'pending'
            ]);
        }

        // Simpan / update record pembayaran di tabel payments
        Payment::updateOrCreate(
            ['order_id' => $orderId],
            [
                'booking_id'         => $booking->id,
                'payment_type'       => $paymentType,
                'transaction_status' => $transactionStatus,
                'gross_amount'       => (int) $grossAmount,
                'payment_time'       => now(),
            ]
        );

        Log::info('[MIDTRANS CALLBACK] Status booking ter-update', [
            'booking_id'         => $bookingId,
            'transaction_status' => $transactionStatus,
            'payment_status'     => $booking->fresh()->payment_status,
        ]);

        return response()->json(['message' => 'OK'], 200);
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

    public function bookingSuccess($id)
    {
        $booking = Booking::with('package')->where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Fallback: kalau webhook belum jalan, sync langsung ke Midtrans
        if ($booking->payment_status !== 'paid') {
            $this->syncMidtransStatus($booking);
            $booking->refresh();
        }

        return view('customer.booking_success', compact('booking'));
    }

    /**
     * Tanya status transaksi langsung ke Midtrans (bypass webhook).
     * Dipakai sebagai pengaman kalau Notification URL belum di-set / ngrok mati.
     */
    protected function syncMidtransStatus(Booking $booking): void
    {
        try {
            Config::$serverKey   = config('midtrans.server_key');
            Config::$isProduction = config('midtrans.is_production');

            // Cari order_id terbaru milik booking ini
            $payment = Payment::where('booking_id', $booking->id)->latest()->first();
            $orderId = $payment->order_id ?? null;

            if (!$orderId) {
                // Belum ada record payment sama sekali → tidak bisa cek
                Log::info('[MIDTRANS SYNC] Tidak ada order_id untuk booking', ['booking_id' => $booking->id]);
                return;
            }

            $status = Transaction::status($orderId);
            $status = is_object($status) ? (array) $status : $status;

            $transactionStatus = $status['transaction_status'] ?? null;
            $fraudStatus       = $status['fraud_status'] ?? null;
            $paymentType       = $status['payment_type'] ?? null;
            $grossAmount       = $status['gross_amount'] ?? null;

            if ($transactionStatus == 'settlement' || ($transactionStatus == 'capture' && $fraudStatus == 'accept')) {
                // Hanya tandai pembayaran. Booking tetap 'pending' menunggu approve admin.
                $booking->update(['payment_status' => 'paid']);
            } elseif (in_array($transactionStatus, ['cancel', 'deny', 'expire'])) {
                $booking->update(['payment_status' => 'failed', 'status' => 'cancelled']);
            }

            Payment::updateOrCreate(
                ['order_id' => $orderId],
                [
                    'booking_id'         => $booking->id,
                    'payment_type'       => $paymentType,
                    'transaction_status' => $transactionStatus,
                    'gross_amount'       => (int) $grossAmount,
                    'payment_time'       => now(),
                ]
            );

            Log::info('[MIDTRANS SYNC] Status disinkronkan', [
                'booking_id'         => $booking->id,
                'order_id'           => $orderId,
                'transaction_status' => $transactionStatus,
            ]);
        } catch (\Throwable $e) {
            Log::warning('[MIDTRANS SYNC] Gagal cek status: '.$e->getMessage(), [
                'booking_id' => $booking->id,
            ]);
        }
    }
}