<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Stadium;
use Constants;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function bookingStadium(Request $request)
    {
        $data = $request->all();
        $data['user_id'] = auth("sanctum")->user()->id;

        $start_time = $data["start_time"];
        $end_time = $data["end_time"];

        $stadium_times = Stadium::where("id", $data['stadium_id'])->get()->map->only([
            'open_time',
            'close_time'
        ])[0];

        $std_open_time = $stadium_times['open_time'];
        $std_close_time = $stadium_times['close_time'];



        if ($std_open_time && $std_close_time) {
            if (!($std_open_time <= $start_time && $std_close_time >= $end_time)) {
                return response()->json([
                    'status' => "error",
                    "message" => "Bu vaqtda stadion ishlamaydi"
                ]);
            }
            $stadium_times = array_filter(Constants::get_times(), function ($time) use ($std_open_time, $std_close_time) {
                return $time >= $std_open_time && $time <= $std_close_time;
            });
        } else {
            $stadium_times = Constants::get_times();
        }

        $conflict = Booking::where('stadium_id', $data['stadium_id'])
            ->where('date', $data['date'])
            ->where(function ($query) use ($start_time, $end_time) {
                $query->whereBetween('start_time', [$start_time, $end_time])
                    ->orWhereBetween('end_time', [$start_time, $end_time]);
            })
            ->exists();

        if ($conflict) {
            return response()->json([
                'success' => false,
                'message' => 'This time slot is already booked.'
            ], 409);
        }

        $booked_hours = array_filter($stadium_times, function ($time) use ($start_time, $end_time) {
            return $time >= $start_time && $time <= $end_time;
        });

        $data["booked_hours"] = json_encode($booked_hours);
        Booking::create($data);

        return response()->json([
            "success" => true,
            "message" => "Stadium booked successfully"
        ]);
    }

    public function getAvailabilities(Request $request)
    {
        $date = $request->all()["date"];
        $stadium_id = $request->all()["stadium_id"];


        $bookings = Booking::where("date", $date)->where("stadium_id", $stadium_id)->pluck("booked_hours");
        $times = Constants::get_times();
        $reservedTimes = [];
        foreach ($bookings as $time) {
            $reservedTimes = array_merge($reservedTimes, json_decode($time, true));
        }

        $freeTimes = array_diff($times, $reservedTimes);


        $result = [
            "date" => $date,
            "free times" => array_values($freeTimes)
        ];
        return $result;
    }
}
