<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ChatRoom extends Model
{
    use HasFactory;

    protected $table = 'chat_rooms';

    protected $fillable = [
        'booking_id',
        'customer_id',
        'reader_id',
        'has_addon',
        'status',
    ];

    protected $casts = [
        'has_addon' => 'boolean',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function reader()
    {
        return $this->belongsTo(User::class, 'reader_id');
    }

    public function messages()
    {
        return $this->hasMany(ChatMessage::class, 'room_id');
    }

    public function lastMessage()
    {
        return $this->hasOne(ChatMessage::class, 'room_id')->latestOfMany();
    }
}
