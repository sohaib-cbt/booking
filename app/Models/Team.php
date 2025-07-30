<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = [
        'type',
        'name',
        'email',
        'phone_no',
        'role',
        'address',
    ];
}
