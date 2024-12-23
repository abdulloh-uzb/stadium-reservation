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

        // Berilgan date (kun) va stadium_id orqali stadionni booking malumotlarini olamiz.
        $bookings = Booking::where("date", $date)->where("stadium_id", $stadium_id)->pluck("booked_hours");
        $times = Constants::get_times();

        // booked qilingan vaqtlarni saqlash uchun
        $reservedTimes = [];
        foreach ($bookings as $time) {
            $reservedTimes = array_merge($reservedTimes, json_decode($time, true));
        }

        // booked qilingan vaqtni times ga solishtiryapmiz. 2ta massivdayam bir xil vaqt bo'lsa demak u booked qilingan.
        $freeTimes = array_diff($times, $reservedTimes);

        $result = [
            "date" => $date,
            "free times" => array_values($freeTimes)
        ];
        return $result;
    }
}
