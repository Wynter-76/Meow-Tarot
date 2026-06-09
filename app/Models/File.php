<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class File extends Model
{
    use HasFactory;

    protected $table = 'files';

    protected $fillable = [
        'booking_id',
        'file_path',
        'file_type'
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }
}