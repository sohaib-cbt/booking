<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description'];


    public function bookings()
    {
        return $this->belongsToMany(Booking::class, 'booking_group_booking', 'group_id', 'booking_id');
    }

}
