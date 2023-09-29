<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'guest_id',
        'name', 
        'phone',
        'address',
        'comments',
        'rsvp',
        'is_present',
        'status',
        'is_available',
        'invitation_id'
    ];
}
