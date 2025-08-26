<?php

namespace App\Http\Controllers;

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
}
