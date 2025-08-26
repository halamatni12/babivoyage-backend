<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Flight extends Model
{
      use HasFactory;

    protected $fillable = [
        'flight_number','airline_id','departure_id','arrival_id',
        'departure_time','arrival_time','base_price','class',
    ];

    protected $casts = [
        'departure_time' => 'datetime',
        'arrival_time'   => 'datetime',
        'base_price'     => 'decimal:2',
    ];
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function airline()
    {
        return $this->belongsTo(Airline::class);
    }

    public function departure()
    {
        return $this->belongsTo(Destination::class, 'departure_id');
    }

    public function arrival()
    {
        return $this->belongsTo(Destination::class, 'arrival_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
        public function from()     { return $this->belongsTo(Destination::class, 'departure_id'); }
    public function to()       { return $this->belongsTo(Destination::class, 'arrival_id'); }

}
