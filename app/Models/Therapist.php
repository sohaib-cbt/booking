<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Therapist extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone_no',
        'address',
    ];
}
