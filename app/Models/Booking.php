<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [

        'booking_form_type',
        'entry_type',
        'school_id',
        'private_room_area',
        'specific_time',
        'other_app_scheduling_info',
        'days_off_week',

        'child_attend',
        'internal_team',
        'external_team',
        'length_of_metting',
        'follow_up_meeting',

        'client_name',
        'language',
        'priority',
        'reminder_call',
        'alayacare_type',
        'alayacare_service_code',
        'room_setup',
        'units_from',
        'units_to',
        'schedule_by',
        'trvel_time',
        'area_of_town',
        'location',
        'therapist_id',
        'report_time',
        'reoccur_app_info',
        'rooms',
        'inform_to',
        'comments',
        'status',
    ];

    protected $casts = [
        'inform_to' => 'array',
        'days_off_week' => 'array',
        'internal_team' => 'array',
        'external_team' => 'array',
        'follow_up_meeting' => 'array',
        'other_app_scheduling_info' => 'array',
    ];


    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class, 'booking_group_booking', 'booking_id', 'group_id');
    }

}
