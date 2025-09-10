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
         'total_amount' => 'decimal:2',

        
    ];
        protected static function booted()
    {
        static::creating(function ($booking) {
            if (empty($booking->total_amount) && $booking->flight_id) {
                $booking->total_amount = \App\Models\Flight::whereKey($booking->flight_id)->value('base_price') ?? 0;
            }
        });
    }

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
    public function payments() { return $this->hasMany(\App\Models\Payment::class); }

}
