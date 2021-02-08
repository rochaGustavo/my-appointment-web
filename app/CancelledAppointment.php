<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CancelledAppointment extends Model
{
    protected $fillable = [
        'appointment_id',
        'justification',
        'cancelled_by_id'
    ];

    public function cancelled_by() // cancelled_by_id
    {   // Cancellation N - 1 User
        return $this->belongsTo(User::class);
    }
}
