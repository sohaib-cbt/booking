<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'booking_id',
        'contact_type',
        'contact_time',
        'comments',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
