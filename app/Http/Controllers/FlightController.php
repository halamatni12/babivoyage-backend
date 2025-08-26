<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class FlightController extends Controller
{
    public function index(Request $request)
    {
        $q = Flight::with(['airline','departure','arrival']);

        if ($request->filled('departure_id')) $q->where('departure_id', $request->departure_id);
        if ($request->filled('arrival_id'))   $q->where('arrival_id', $request->arrival_id);
        if ($request->filled('date'))         $q->whereDate('departure_time', $request->date);

        return $q->latest('departure_time')->paginate(20);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'flight_number' => ['required','string','max:50','unique:flights,flight_number'],
            'airline_id'    => ['required','exists:airlines,id'],
            'departure_id'  => ['required','different:arrival_id','exists:destinations,id'],
            'arrival_id'    => ['required','exists:destinations,id'],
            'departure_time'=> ['required','date'],
            'arrival_time'  => ['required','date','after:departure_time'],
            'base_price'    => ['required','numeric','min:0'],
            'class'         => ['required', Rule::in(['economy','business','first'])],
        ]);

        return response()->json(
            Flight::create($data)->load(['airline','departure','arrival']),
            201
        );
    }

    public function show(Flight $flight){ return $flight->load(['airline','departure','arrival']); }

    public function update(Request $request, Flight $flight)
    {
        $data = $request->validate([
            'flight_number' => ['sometimes','string','max:50','unique:flights,flight_number,'.$flight->id],
            'airline_id'    => ['sometimes','exists:airlines,id'],
            'departure_id'  => ['sometimes','exists:destinations,id'],
            'arrival_id'    => ['sometimes','exists:destinations,id'],
            'departure_time'=> ['sometimes','date'],
            'arrival_time'  => ['sometimes','date','after:departure_time'],
            'base_price'    => ['sometimes','numeric','min:0'],
            'class'         => ['sometimes', Rule::in(['economy','business','first'])],
        ]);

        $flight->update($data);
        return $flight->load(['airline','departure','arrival']);
    }

    public function destroy(Flight $flight)
    {
        $flight->delete();
        return response()->noContent();
    }
}
