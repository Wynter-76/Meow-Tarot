<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class testimonials extends Model
{
    protected $fillable = ['user_id','booking_id','rating','package_name','message','is_approved'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
