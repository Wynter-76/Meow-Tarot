<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Addon extends Model
{
    use HasFactory;

    protected $table = 'addons';

    protected $fillable = [
        'name',
        'price',
        'description'
    ];

    public function bookings()
    {
        return $this->belongsToMany(Booking::class, 'booking_addons', 'addon_id', 'booking_id')
                    ->withPivot('price')
                    ->withTimestamps();
    }
}