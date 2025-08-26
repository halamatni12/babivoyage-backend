<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use Illuminate\Http\Request;

class DestinationController extends Controller
{
    public function index() { return Destination::latest()->paginate(20); }

    public function store(Request $request)
    {
        $data = $request->validate([
            'city'    => ['required','string','max:100'],
            'country' => ['required','string','max:100'],
        ]);
        return response()->json(Destination::create($data), 201);
    }

    public function show(Destination $destination)
    {
        return $destination->loadCount(['departures','arrivals']);
    }

    public function update(Request $request, Destination $destination)
    {
        $data = $request->validate([
            'city'    => ['sometimes','string','max:100'],
            'country' => ['sometimes','string','max:100'],
        ]);
        $destination->update($data);
        return $destination;
    }

    public function destroy(Destination $destination)
    {
        $destination->delete();
        return response()->noContent();
    }
}
