<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Procedure extends Model
{
    //
    protected $fillable = [
    'clinic_id',
    'name',
    'description',
    'education',
    'default_duration_minutes',
    'is_active',
];

    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
