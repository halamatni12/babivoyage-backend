<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Flight;
use App\Models\Destination;

class FlightSearchController extends Controller
{
    public function results(Request $req)
    {
        $req->validate([
            'from'   => 'required|string',
            'to'     => 'required|string|different:from',
            'depart' => 'required|date',
            'cabin'  => 'nullable|in:economy,business,first',
        ]);

        // جرّب تلاقي الـ IDs حسب الـ city أو country
        $from = Destination::where('city', 'like', "%{$req->from}%")
                            ->orWhere('country', 'like', "%{$req->from}%")
                            ->first();
        $to   = Destination::where('city', 'like', "%{$req->to}%")
                            ->orWhere('country', 'like', "%{$req->to}%")
                            ->first();

        if (!$from || !$to) {
            return back()->withErrors(['from' => 'Invalid origin or destination'])->withInput();
        }

        $flights = Flight::with(['airline','from','to'])
            ->where('departure_id', $from->id)
            ->where('arrival_id', $to->id)
            ->whereDate('departure_time', $req->depart)
            ->when($req->cabin, fn($q) => $q->where('class',$req->cabin))
            ->orderBy('base_price')
            ->get();

        return view('userside.results', [
            'flights' => $flights,
            'query'   => $req->all(),
        ]);
    }
}
