<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetAvailabilitiesRequest;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Requests\UpdateBookingRequest;
use App\Models\Booking;
use App\Services\BookingService;
use Illuminate\Support\Facades\Gate;

class BookingController extends Controller
{

    protected BookingService $bookingService;

    public function __construct(BookingService $bookingService = null)
    {
        $this->bookingService = $bookingService;
    }

    public function bookingStadium(StoreBookingRequest $request)
    {
        Gate::authorize("create", Booking::class);
        $data = $request->validated();
        $result = $this->bookingService->booking($data);
        return response()->json($result);
    }

    public function getAvailabilities(GetAvailabilitiesRequest $request)
    {

        $date = $request->all()["date"];
        $stadium_id = $request->all()["stadium_id"];

        $result = $this->bookingService->getAvailabilities($date, $stadium_id);

        return $result;
    }

    public function cancelBooking(Booking $booking)
    {
        Gate::authorize("delete", $booking);
        $booking->delete();
        return response()->noContent();
    }

    public function updateBooking(UpdateBookingRequest $request, Booking $booking)
    {

        // TODO - update qilganda o'zi bron qilgan vaqt oraligida update qilmoqchi bo'lsa xato ishlayapti
        // Misol uchun, 20:00 - 22:00 ni 21:00 - 22:00 ga update qilish xato ishlaydi. 

        Gate::authorize("update", $booking);

        $data = $request->validated();

        $updated_start_time = $data['start_time'];
        $updated_end_time = $data['end_time'];
        
        $result = $this->bookingService->update($updated_start_time, $updated_end_time, $booking);

        return response()->json($result);
    }

    public function getReservations()
    {
        $user_id = auth("sanctum")->user()->id;
        $bookings = Booking::where("user_id", $user_id)->get();
        return response()->json($bookings);
    }
}
