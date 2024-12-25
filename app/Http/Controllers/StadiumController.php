<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStadiumRequest;
use App\Models\Stadium;
use App\Services\StadiumService;
use Illuminate\Http\Request;

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
        dd($request->all());
        $this->stadium->store($request);
        return response()->json(["success" => true]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
