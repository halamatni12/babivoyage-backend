<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'method',
        'amount_paid',
        'transaction_reference',
        'paid_at',
    ];

    protected $casts = [
        'amount_paid' => 'decimal:2',
        'paid_at' => 'datetime',
    ];
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
        protected static function booted()
    {
        static::created(function ($payment) {
            $booking = $payment->booking;
            if ($booking) {
                $totalPaid = $booking->payments()->sum('amount_paid');
                if ($totalPaid >= $booking->total_amount && $booking->status === 'pending') {
                    $booking->update(['status' => 'confirmed']);
                }
            }
        });
    }

}
