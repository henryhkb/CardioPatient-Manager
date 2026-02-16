<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    //
    protected $fillable = [
    'booking_type',
    'clinic_id',
    'procedure_id',
    'scheduled_at',
    'booking_code',
    'status',
    'patient_name',
    'patient_age',
    'patient_gender',
    'patient_diagnosis',
    'patient_home_address',
    'patient_next_of_kin',
    'patient_phone',
    'patient_email',
];


    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }

    public function procedure()
    {
        return $this->belongsTo(Procedure::class);
    }

    public function reminders()
    {
        return $this->hasMany(Reminder::class);
    }
}
