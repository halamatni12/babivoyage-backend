<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'flight_id',
        'booking_date',
        'seat_number',
        'status',
        'total_price',
        'insurance_id',
    ];

      public function user()
    {
        return $this->belongsTo(User::class);
    }
       public function fligh()
    {
        return $this->belongsTo(Flight::class);
    }
         public function insurance()
    {
        return $this->belongsTo(Insurance::class);
    }
           public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
