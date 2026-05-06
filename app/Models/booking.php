<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Booking extends Model
{
    use HasFactory;

    protected $table = 'bookings';

    protected $fillable = [
        'user_id',
        'package_id',
        'reader_id',
        'type',
        'booking_date',
        'booking_time',
        'name',
        'email',
        'phone',
        'status',
        'payment_status',
        'total_price',
        'reading_result'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id');
    }

    public function reader()
    {
        return $this->belongsTo(User::class, 'reader_id');
    }

    public function questions()
    {
        return $this->hasMany(Question::class, 'booking_id');
    }

    public function files()
    {
        return $this->hasMany(File::class, 'booking_id');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class, 'booking_id');
    }

    public function addons()
    {
        return $this->belongsToMany(Addon::class, 'booking_addons', 'booking_id', 'addon_id')
                    ->withPivot('price')
                    ->withTimestamps();
    }

    public function file()
    {
        return $this->hasOne(File::class, 'booking_id');
    }
}