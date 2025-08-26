<?php

namespace App\Http\Controllers;
use App\Models\Booking;
use App\Models\Flight;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{// Show all bookings for the logged-in user
public function index()
{
    if (!Auth::check()) {
        return redirect()->route('login')->with('error', 'Please login first.');
    }

    $bookings = Booking::with(['flight.airline','flight.from','flight.to'])
        ->where('user_id', Auth::id())
        ->orderBy('created_at','desc')
        ->get();

    return view('userside.bookings_index', compact('bookings'));
}

    private function userId()
    {
        return Auth::guard('web')->id();
    }

    // Show booking form
    public function create(Request $request, Flight $flight)
    {
        if (!Auth::guard('web')->check()) {
            return redirect()->route('login')->with('error', 'Please login first to book a flight.');
        }

        $pax   = (int) $request->input('pax', 1);
        $cabin = $request->input('cabin', $flight->class ?? 'economy');

        if ($flight->class && $cabin !== $flight->class) {
            $cabin = $flight->class;
        }

        $hasInsurance = $request->boolean('insurance', false);

        $estimatedTotal = $this->estimateTotal(
            basePrice: (float) $flight->base_price,
            pax: $pax,
            cabin: $cabin,
            insurance: $hasInsurance
        );

        return view('userside.book', compact('flight', 'pax', 'cabin', 'estimatedTotal'));
    }

    // Save booking
 public function store(Request $request, Flight $flight)
    {
        $validated = $request->validate([
            'pax'   => 'required|integer|min:1|max:9',
            'cabin' => 'required|in:economy,business,first',
        ]);

        $booking = Booking::create([
            'user_id'   => Auth::id(),
            'flight_id' => $flight->id,
            'pax'       => $validated['pax'],
            'cabin'     => $validated['cabin'],
            'status'    => 'pending',
            'total_amount' => $flight->base_price * $validated['pax'],
                'booking_date' => now(), // simple calc
        ]);

        // redirect to payment page
        return redirect()->route('payments.create', $booking->id);
    }


    // Show confirmation page
    public function show(Booking $booking)
    {
        if (!Auth::guard('web')->check() || $booking->user_id !== $this->userId()) {
            return redirect()->route('login')->with('error', 'Please login to view your booking.');
        }

        $booking->load(['flight.airline','flight.from','flight.to']);
        $meta = session('booking_meta_'.$booking->id, []);

        return view('userside.booking_show', compact('booking','meta'));
    }

    // Mark as confirmed
    public function confirm(Booking $booking)
    {
        if (!Auth::guard('web')->check() || $booking->user_id !== $this->userId()) {
            return redirect()->route('login')->with('error', 'Please login first.');
        }

        $booking->update(['status' => 'confirmed']);
        return back()->with('success', 'Booking confirmed. Your e-ticket will be emailed shortly.');
    }

    // Pricing logic
    private function estimateTotal(float $basePrice, int $pax, string $cabin, bool $insurance): float
    {
        $multipliers = ['economy'=>1.00, 'business'=>1.80, 'first'=>2.50];
        $insurancePerPax = 12.00;

        $subtotal  = $basePrice * ($multipliers[$cabin] ?? 1.00) * $pax;
        $ins       = $insurance ? $insurancePerPax * $pax : 0.0;

        return round($subtotal + $ins, 2);
    }

       public function indexapi(Request $request)
    {
        return Booking::with('flight')
            ->where('user_id', $request->user()->id)
            ->latest()->paginate(20);
    }

    public function storeapi(Request $request)
    {
        $data = $request->validate([
            'flight_id'   => ['required','exists:flights,id'],
            'seat_number' => ['nullable','string','max:10'],
        ]);

        $flight = Flight::findOrFail($data['flight_id']);

        $booking = Booking::create([
            'user_id'      => $request->user()->id,
            'flight_id'    => $flight->id,
            'booking_date' => now(),
            'seat_number'  => $data['seat_number'] ?? null,
            'status'       => 'pending',
            'total_amount' => $flight->base_price, // one seat price
        ]);

        return response()->json($booking->load('flight'), 201);
    }

    public function showapi(Booking $booking)
    {
        $this->authorizeOwner($booking);
        return $booking->load(['flight','payment']);
    }

    public function update(Request $request, Booking $booking)
    {
        $this->authorizeOwner($booking);
        $data = $request->validate([
            'status' => ['sometimes','in:pending,confirmed,cancelled'],
            'seat_number' => ['sometimes','nullable','string','max:10'],
        ]);
        $booking->update($data);
        return $booking->load(['flight','payment']);
    }

    public function destroy(Booking $booking)
    {
        $this->authorizeOwner($booking);
        $booking->delete();
        return response()->noContent();
    }

    private function authorizeOwner(Booking $booking)
    {
        abort_if(auth()->id() !== $booking->user_id, 403, 'Forbidden');
    }
}
