<?php

namespace App\Http\Controllers;

use App\Services\SearchService;
use Illuminate\Http\Request;

class SearchController extends Controller
{

    public function __construct(public SearchService $search)
    {
        
    }

    public function search(Request $request)
    {   
        $data = $request->validate([
            "date" => "required|date_format:Y-m-d|after:today",
            "start_time" => "required",
            "end_time" => "required|after:start_time",
        ]);
        
        $result = $this->search->searchAvailableStadium($data);


        return $result;
    }
}
