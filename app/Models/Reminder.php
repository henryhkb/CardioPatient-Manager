<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reminder extends Model
{
    //
    protected $fillable = [
        'booking_id','reminder_at','channel','message','status','sent_at','failure_reason'
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
