<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Airline extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'logo_url',
    ];

    public function flights()
    {
        return $this->hasMany(Flight::class);
    }
}

