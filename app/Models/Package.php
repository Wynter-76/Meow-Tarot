<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Package extends Model
{
    use HasFactory;

    protected $table = 'packages';

    protected $fillable = [
        'name',
        'category',
        'description',
        'price',
        'question_limit',
        'duration',
        'is_online',
        'is_offline'
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'package_id');
    }
}