<?php

namespace App\Http\Controllers;
use App\Models\Destination;
use Illuminate\Http\Request;

use App\Models\Flight;
use App\Http\Requests\FlightStoreRequest;
use App\Http\Requests\FlightUpdateRequest;

class FlightController extends Controller
{
    public function index()
    {
        return Flight::with(['airline','departure','arrival'])
            ->latest()->paginate(20);
    }

    public function store(FlightStoreRequest $request)
    {
        $flight = Flight::create($request->validated());
        return response()->json($flight->load(['airline','departure','arrival']), 201);
    }

    public function show(Flight $flight)
    {
        return $flight->load(['airline','departure','arrival']);
    }

    public function update(FlightUpdateRequest $request, Flight $flight)
    {
        $flight->update($request->validated());
        return $flight->load(['airline','departure','arrival']);
    }

    public function destroy(Flight $flight)
    {
        $flight->delete();
        return response()->noContent();
    }
      public function results(Request $request)
    {
        $validated = $request->validate([
            'from_id' => ['nullable','integer','exists:destinations,id'],
            'to_id'   => ['nullable','integer','exists:destinations,id'],
            // 'depart'  => ['nullable','date'],
            // 'cabin'   => ['nullable','in:economy,business,first'],
        ]);

        $fromId = $validated['from_id'] ?? null;
        $toId   = $validated['to_id']   ?? null;

        $flights = Flight::with(['airline','departure','arrival'])
            ->when($fromId, fn($q) => $q->where('departure_id', $fromId))
            ->when($toId,   fn($q) => $q->where('arrival_id',   $toId))
            ->orderBy('departure_time')
            ->paginate(10)
            ->appends($request->query()); // يحافظ على الـ querystring مع الصفحات

        $origin      = $fromId ? Destination::find($fromId) : null;
        $destination = $toId   ? Destination::find($toId)   : null;

        return view('userside.flights.results', compact('flights','origin','destination'));
    }
       public function indexdes()
    {
        $destinations = Destination::paginate(12); // كل الوجهات مع pagination
        return view('userside.destinations.index', compact('destinations'));
    }
    public function showDetails(Flight $flight)
{
    // حمّل العلاقات المرتبطة بالرحلة
    $flight->load(['airline', 'departure', 'arrival']);

    // ابعت البيانات للـ view
    return view('userside.flights.show', compact('flight'));
}

}
