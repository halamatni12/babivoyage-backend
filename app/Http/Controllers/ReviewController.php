<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Http\Requests\ReviewStoreRequest;
use App\Http\Requests\ReviewUpdateRequest;

class ReviewController extends Controller
{
    // public list by flight
    public function indexByFlight($flightId)
    {
        return Review::with('user')
            ->where('flight_id', $flightId)
            ->latest()
            ->paginate(20);
    }

    // create review (auth)
    public function store(ReviewStoreRequest $request)
    {
        $review = Review::create([
            'user_id' => $request->user()->id,
            ...$request->validated(),
        ]);

        return response()->json($review->load('user'), 201);
    }

    // update own review
    public function update(ReviewUpdateRequest $request, Review $review)
    {
        abort_if(auth()->id() !== $review->user_id, 403, 'Forbidden');
        $review->update($request->validated());
        return $review->load('user');
    }

    // delete own review
    public function destroy(Review $review)
    {
        abort_if(auth()->id() !== $review->user_id, 403, 'Forbidden');
        $review->delete();
        return response()->noContent();
    }
}
