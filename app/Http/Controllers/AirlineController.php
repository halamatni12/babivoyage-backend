<?php

namespace App\Http\Controllers;

use App\Models\Airline;
use App\Http\Requests\AirlineStoreRequest;
use App\Http\Requests\AirlineUpdateRequest;

class AirlineController extends Controller
{
    public function index()
    {
        return Airline::latest()->paginate(20);
    }

    public function store(AirlineStoreRequest $request)
    {
        return response()->json(Airline::create($request->validated()), 201);
    }

    public function show(Airline $airline)
    {
        return $airline->loadCount('flights');
    }

    public function update(AirlineUpdateRequest $request, Airline $airline)
    {
        $airline->update($request->validated());
        return $airline;
    }

    public function destroy(Airline $airline)
    {
        $airline->delete();
        return response()->noContent();
    }
}
