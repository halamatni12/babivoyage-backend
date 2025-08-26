<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Http\Requests\DestinationStoreRequest;
use App\Http\Requests\DestinationUpdateRequest;

class DestinationController extends Controller
{
    public function index()
    {
        return Destination::latest()->paginate(20);
    }

    public function store(DestinationStoreRequest $request)
    {
        return response()->json(Destination::create($request->validated()), 201);
    }

    public function show(Destination $destination)
    {
        return $destination;
    }

    public function update(DestinationUpdateRequest $request, Destination $destination)
    {
        $destination->update($request->validated());
        return $destination;
    }

    public function destroy(Destination $destination)
    {
        $destination->delete();
        return response()->noContent();
    }
}
