<?php

namespace App\Http\Controllers;

use App\Models\Airline;
use Illuminate\Http\Request;

class AirlineController extends Controller
{
    public function index(){ return Airline::latest()->paginate(20); }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => ['required','string','max:150'],
            'code'     => ['required','string','max:10','unique:airlines,code'],
            'logo_url' => ['nullable','url'],
        ]);
        return response()->json(Airline::create($data), 201);
    }

    public function show(Airline $airline){ return $airline->loadCount('flights'); }

    public function update(Request $request, Airline $airline)
    {
        $data = $request->validate([
            'name'     => ['sometimes','string','max:150'],
            'code'     => ['sometimes','string','max:10','unique:airlines,code,'.$airline->id],
            'logo_url' => ['sometimes','nullable','url'],
        ]);
        $airline->update($data);
        return $airline;
    }

    public function destroy(Airline $airline)
    {
        $airline->delete();
        return response()->noContent();
    }
}
