<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class HomeController extends Controller
{
    public function index()
    {
        // You can fetch featured destinations / airlines here later if needed.
        return view('userside.home');
    }

    public function search(Request $request)
    {
        $tripTypes = ['oneway', 'round'];
        $cabins    = ['economy', 'premium_economy', 'business', 'first'];

        $validated = $request->validate([
            'trip_type' => ['required', Rule::in($tripTypes)],
            'from'      => ['required','string','size:3'],
            'to'        => ['required','string','size:3','different:from'],
            'depart'    => ['required','date','after_or_equal:today'],
            'return'    => ['nullable','date','after:depart'],
            'pax'       => ['required','integer','min:1','max:9'],
            'cabin'     => ['required', Rule::in($cabins)],
        ], [
            'to.different' => 'Origin and destination cannot be the same.',
            'return.after' => 'Return date must be after the departure date.',
        ]);

        // If one-way, null out return
        if ($validated['trip_type'] === 'oneway') {
            $validated['return'] = null;
        }

        // Redirect to results with query string (for your FlightsController later)
        return redirect()->route('flights.results', array_filter($validated));
    }

    public function results(Request $request)
    {
        // For now, just show what was searched. Later, call your Flights service/API.
        $query = $request->only(['trip_type','from','to','depart','return','pax','cabin']);

        return view('flights.results', [
            'query' => $query,
            // 'flights' => $flights   // plug your search here later
        ]);
    }
}
