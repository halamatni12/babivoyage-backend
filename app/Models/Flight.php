<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
     use HasFactory;

    protected $fillable = [
        'flight_number',
        'departure_city',
        'arrival_city',
        'departure_time',
        'arrival_time',
        'duration',
        'price',
        'seats_available',
        'status',
    ];
    public function bookings(){
        return $this->hasMany(Booking::class);
    }
}
