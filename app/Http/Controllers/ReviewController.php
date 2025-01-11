<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Http\Requests\StoreReviewRequest;
use App\Http\Requests\UpdateReviewRequest;
use App\Models\Booking;
use App\Models\Stadium;
use Illuminate\Support\Facades\Gate;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reviews = Review::paginate(10);

        return response()->json($reviews);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReviewRequest $request)
    {        
        
        $data = $request->validated();

        $booking = Booking::findOrFail($data['booking_id']);
        Gate::authorize('create', [Review::class, $booking]);

        $data["user_id"] = auth("sanctum")->user()->id;
        $data = Review::create($data);

        return response()->json($data);

    }


}
