<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class daily_card extends Model
{
    protected $fillable = [
        'day', 'card_name', 'card_image', 'keyword', 'meaning'
    ];
}
