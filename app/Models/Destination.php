<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Destination extends Model
{
    use HasFactory;

    protected $fillable = [
        'city',
        'country',
    ];

    public function departures()
    {
        return $this->hasMany(Flight::class, 'departure_id');
    }

    public function arrivals()
    {
        return $this->hasMany(Flight::class, 'arrival_id');
    }
}

