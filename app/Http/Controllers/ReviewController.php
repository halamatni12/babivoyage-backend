<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Flight;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    // public listing per flight
    public function indexByFlight(Flight $flight)
    {
        return Review::with('user')->where('flight_id', $flight->id)->latest()->paginate(20);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'flight_id' => ['required','exists:flights,id'],
            'rating'    => ['required','integer','min:1','max:5'],
            'comment'   => ['nullable','string'],
        ]);

        $review = Review::create([
            'user_id'   => $request->user()->id,
            'flight_id' => $data['flight_id'],
            'rating'    => $data['rating'],
            'comment'   => $data['comment'] ?? null,
        ]);

        return response()->json($review->load('user'), 201);
    }

    public function update(Request $request, Review $review)
    {
        abort_if(auth()->id() !== $review->user_id, 403, 'Forbidden');

        $data = $request->validate([
            'rating'  => ['sometimes','integer','min:1','max:5'],
            'comment' => ['sometimes','nullable','string'],
        ]);

        $review->update($data);
        return $review->load('user');
    }

    public function destroy(Review $review)
    {
        abort_if(auth()->id() !== $review->user_id, 403, 'Forbidden');
        $review->delete();
        return response()->noContent();
    }
}
