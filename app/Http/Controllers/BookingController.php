<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookingRequest;
use App\Models\Booking;
use App\Models\Stadium;
use App\Services\BookingService;
use Constants;
use Illuminate\Http\Request;

class BookingController extends Controller
{

    protected BookingService $bookingService;

    public function __construct(BookingService $bookingService = null) {
        $this->bookingService = $bookingService;
    }

    public function bookingStadium(StoreBookingRequest $request)
    {
        $data = $request->validated();
        $result = $this->bookingService->booking($data);
        return response()->json($result);
    }

    public function getAvailabilities(Request $request)
    {

        $date = $request->all()["date"];
        $stadium_id = $request->all()["stadium_id"];

        $result = $this->bookingService->getAvailabilities($date, $stadium_id);
       
        return $result;
    }
}
