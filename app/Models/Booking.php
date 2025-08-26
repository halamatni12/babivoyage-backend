<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Booking extends Model
{    use HasFactory;

    protected $fillable = [
        'user_id',
        'flight_id',
        'booking_date',
        'seat_number',
        'status',
        'total_amount',
    ];
       protected $casts = [
        'booking_date' => 'datetime',
    ];
        public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function flight()
    {
        return $this->belongsTo(Flight::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
