<?php

namespace App\Services;

use App\Models\Stadium;

class SearchService 
{

    public function __construct(public BookingService $booking)
    {
        
    }

    public function searchAvailableStadium($data)
    {
        $stadiums = Stadium::all();
        $results = [];
        foreach ($stadiums as $stadium) {
            $available_times = $this->booking->getAvailabilities($data['date'], $stadium->id)['free times'];

            if (in_array($data["start_time"], $available_times) && in_array($data["end_time"], $available_times)) {
                $result = [];
                $result['id'] = $stadium->id;
                $result['available_times'] = $available_times;
                $results[] = $result;
            }
        }
        return $results;
    }

}

