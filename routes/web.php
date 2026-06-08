<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ReaderController;


Route::get('/', [CustomerController::class, 'home'])->name('customer.index_cust');
Route::get('/service',[CustomerController::class,'service'])->name('customer.service_cust');
Route::get('/about',[CustomerController::class,'about'])->name('customer.about_cust');
Route::get('/testimonial',[CustomerController::class,'testimonial'])->name('customer.testimonial_cust');
Route::get('/contact',[CustomerController::class,'contact'])->name('customer.contact_cust');

Route::get('/login', function () {
    return view('auth.login');
})->name('login')->middleware('guest');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::get('/api/check-booked-time', [CustomerController::class, 'checkBookedTime']);

Route::post('/midtrans/callback', [CustomerController::class, 'callback']);

Route::middleware(['auth'])->group(function () {
    Route::get('/tarot/online/{id}', [CustomerController::class, 'tarotOnline']);
    Route::get('/tarot/offline/{id}', [CustomerController::class, 'tarotOffline']);
    Route::get('/palm/online/{id}', [CustomerController::class, 'palmOnline']);
    Route::get('/palm/offline/{id}', [CustomerController::class, 'palmOffline']);
    Route::get('/chat/{id}', [CustomerController::class, 'chat']);
    Route::get('/call/{id}', [CustomerController::class, 'call']);
    Route::post('/booking/store', [CustomerController::class, 'storeBooking']);
    Route::get('/testimonial', [CustomerController::class, 'testimonial'])->name('customer.testimonial_cust');
    Route::post('/testimonial/store', [CustomerController::class, 'storeTestimonial']);
    Route::get('/payment/{id}', [CustomerController::class, 'payment']);
    Route::get('/booking/success/{id}', [CustomerController::class, 'bookingSuccess']);
    Route::get('/history', [CustomerController::class, 'history']);
    Route::post('/contact/send', [CustomerController::class, 'sendContact']);
});
Route::middleware(['auth','admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class,'dashboard']);
    Route::get('/admin/dashboard', [AdminController::class,'dashboard']);
    Route::get('/admin/users', [AdminController::class, 'users']);
    Route::get('/admin/users/create', [AdminController::class, 'createUser']);
    Route::post('/admin/users/store', [AdminController::class, 'storeUser']);
    Route::get('/admin/users/edit/{id}', [AdminController::class, 'editUser']);
    Route::post('/admin/users/update/{id}', [AdminController::class, 'updateUser']);
    Route::delete('/admin/users/{id}', [AdminController::class, 'deleteUser']);
    Route::get('/admin/kelolapaket', [AdminController::class,'packages']);
    Route::get('/admin/testimonial', [AdminController::class, 'testimonial']);
    Route::get('/admin/testimonial/approve/{id}', [AdminController::class, 'approveTestimonial']);
    Route::delete('/admin/testimonial/{id}', [AdminController::class, 'deleteTestimoni']);
    Route::post('/admin/tambah-paket', [AdminController::class,'storePackage']);
    Route::post('/admin/edit-paket/{id}', [AdminController::class,'updatePackage']);
    Route::delete('/admin/hapus-paket/{id}', [AdminController::class,'deletePackage']);
    Route::get('/admin/databooking', [AdminController::class,'bookings']);
    Route::get('/admin/laporan', [AdminController::class,'laporan']);
    Route::get('/admin/approve/{id}', [AdminController::class,'approve']);
    Route::get('/admin/reject/{id}', [AdminController::class,'reject']);
    Route::get('/admin/laporan/export-pdf',   [AdminController::class, 'exportPdf'])->name('admin.laporan.pdf');
    Route::get('/admin/laporan/export-excel', [AdminController::class, 'exportExcel'])->name('admin.laporan.excel');
});
Route::middleware(['auth','reader'])->group(function () {
    Route::get('/dashboard', [ReaderController::class,'dashboard']);
    Route::get('/reader/dashboard', [ReaderController::class,'dashboard']);
    Route::get('/reader/bookingmasuk', [ReaderController::class,'bookingmasuk']);
    Route::get('/reader/riwayat', [ReaderController::class,'riwayat']);
    Route::get('/reader/start/{id}', [ReaderController::class,'start']);
    Route::get('/reader/kirim-hasil/{id}', [ReaderController::class,'kirimhasil']);
    Route::post('/reader/hasil/{id}', [ReaderController::class,'simpanhasil']);
    Route::get('/reader/detail/{id}', [ReaderController::class, 'detail']);
});