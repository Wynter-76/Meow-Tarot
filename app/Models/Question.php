<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Question extends Model
{
    use HasFactory;

    protected $table = 'questions';

    protected $fillable = [
        'booking_id',
        'question',
        'answer'
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }
}