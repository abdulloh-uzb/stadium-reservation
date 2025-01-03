<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStadiumRequest;
use App\Models\Stadium;
use App\Services\StadiumService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class StadiumController extends Controller
{

    public StadiumService $stadium;

    public function __construct(StadiumService $stadium)
    {
        $this->stadium = $stadium;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Stadium::all();
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
