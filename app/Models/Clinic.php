<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Clinic extends Model
{
    //
    protected $fillable = ['name', 'location', 'education', 'is_active'];
    public function procedures()
    {
        return $this->hasMany(Procedure::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
