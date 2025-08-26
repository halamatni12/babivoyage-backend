<?php
namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    // Show payment form
    public function create(Booking $booking)
    {
        return view('userside.payments', compact('booking'));
    }

    // Process payment
    public function store(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'method' => 'required|in:credit_card,paypal,bank_transfer,cash',
        ]);

        // Create payment record
        $payment = Payment::create([
            'booking_id' => $booking->id,
            'method'     => $validated['method'],
    'amount_paid'=> $booking->total_amount,
            'transaction_reference' => 'TXN-' . strtoupper(uniqid()),
            'paid_at'    => now(),
        ]);

        // Update booking status
        $booking->update(['status' => 'confirmed']);

        return redirect()->route('bookings.show', $booking->id)
                         ->with('success', 'Payment successful! Your booking is confirmed.');
    }
      public function index(Request $request)
    {
        return Payment::whereHas('booking', fn($q)=>$q->where('user_id',$request->user()->id))
            ->latest()->paginate(20);
    }

    public function storeapi(Request $request)
    {
        $data = $request->validate([
            'booking_id' => ['required','exists:bookings,id'],
            'method'     => ['required','in:credit_card,paypal,bank_transfer,cash'],
            'amount_paid'=> ['required','numeric','min:0'],
            'transaction_reference' => ['nullable','string','max:120'],
            'paid_at'    => ['nullable','date'],
        ]);

        $booking = Booking::findOrFail($data['booking_id']);
        abort_if($booking->user_id !== $request->user()->id, 403, 'Forbidden');

        $payment = Payment::create([
            ...$data,
            'paid_at' => $data['paid_at'] ?? now(),
        ]);

        if ($payment->amount_paid >= $booking->total_amount && $booking->status !== 'cancelled') {
            $booking->update(['status' => 'confirmed']);
        }

        return response()->json($payment->load('booking'), 201);
    }

    public function show(Payment $payment)
    {
        abort_if(auth()->id() !== $payment->booking->user_id, 403, 'Forbidden');
        return $payment->load('booking');
    }
}
