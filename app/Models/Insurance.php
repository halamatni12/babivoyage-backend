<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Insurance extends Model
{
        use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'coverage_details',
        'price',
     
    ];
        public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
