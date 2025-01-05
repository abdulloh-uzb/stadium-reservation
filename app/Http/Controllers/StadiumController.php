<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStadiumRequest;
use App\Models\Stadium;
use App\Services\BookingService;
use App\Services\StadiumService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class StadiumController extends Controller
{
    public function __construct(public BookingService $booking, public StadiumService $stadium) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $query = Stadium::query();

        if ($request->has('location')) {
            $query->where('location', 'like', '%' . $request->input('location') . '%');
        }

        $stadiums = $query->paginate(5);
        return response()->json($stadiums);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStadiumRequest $request)
    {
        Gate::authorize("create", Stadium::class);
        $this->stadium->store($request);
        return response()->json(["success" => true]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Stadium $stadium)
    {
        return response($stadium);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Stadium $stadium)
    {
        Gate::authorize("update", $stadium);

        $stadium->update($request->all());

        return response()->json([
            "error" => false,
            "message" => "success"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Stadium $stadium)
    {

        $stadium->delete();
        return response()->noContent();
    }
}
