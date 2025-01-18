<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Stadium;
use App\Helpers\Constants;

class BookingService
{

    public function booking($data)
    {
        $data['user_id'] = auth("sanctum")->user()->id;

        $start_time = $data["start_time"];
        $end_time = $data["end_time"];

        $booked_hours = $this->generateBookedHours($data['stadium_id'], $start_time, $end_time);
        if($booked_hours){
            $data['booked_hours'] = $booked_hours;
        }else{
            return [
                'success' => false,
                "message" => "Stadium does not work in this time"
            ];
        }

        // oldin band qilingan vaqtda booking qilinmasligi uchun databasedan tekshirilmoqda
        if ($this->checkTime($data['stadium_id'], $data['date'], $start_time, $end_time)) {
            return [
                'success' => false,
                'message' => 'This time slot is already booked.'
            ];
        }

        Booking::create($data);

        return [
            "success" => true,
            "message" => "Stadium booked successfully"
        ];
    }

    public function update($updated_start_time, $updated_end_time, $booking)
    {
        $date = $booking->date;
        $stadium_id = $booking->stadium_id;

        if ($this->checkTime($stadium_id, $date, $updated_start_time, $updated_end_time)) {
            return [
                'success' => false,
                'message' => 'This time slot is already booked.'
            ];
        }

        $booked_hours = $this->generateBookedHours($stadium_id, $updated_start_time, $updated_end_time);
        if(!$booked_hours){
            return [
                'success' => false,
                "message" => "Stadium does not work in this time"
            ];
        }
        
        $booking->update([
            "booked_hours" => $booked_hours,
            "start_time" => $updated_start_time,
            "end_time" => $updated_end_time
        ]);
        
        return $booking;
    }

    public function getAvailabilities($date, $stadium_id)
    {
        // Berilgan date (kun) va stadium_id orqali stadionni booking malumotlarini olamiz.
        $bookings = Booking::where("date", $date)->where("stadium_id", $stadium_id)->pluck("booked_hours");
        $times = $this->getStadiumTimes($stadium_id)['stadium_times'];

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

    protected function getStadiumTimes($stadium_id)
    {
        $stadium_times = Stadium::where("id", $stadium_id)->get()->map->only([
            'open_time',
            'close_time'
        ])[0];

        $std_open_time = $stadium_times['open_time'];
        $std_close_time = $stadium_times['close_time'];

        // Bazida stadion butun kun davomida ochiq bo'lishi mumkin shunday vaziyatda open_time va close_time null bo'ladi.
        if ($std_open_time && $std_close_time) {
            // open_time va close_time orqali stadion ochiq bo'lgan har bir vaqt olinmoqda.
            $stadium_times = array_filter(Constants::get_times(), function ($time) use ($std_open_time, $std_close_time) {
                return $time >= $std_open_time && $time <= $std_close_time;
            });
        } else {
            // agar stadion kun bo'yi ochiq bo'lsa
            $stadium_times = Constants::get_times();
        }

        return [
            'open_time' => $std_open_time,
            'close_time' => $std_close_time,
            'stadium_times' => $stadium_times
        ];
    }

    protected function checkTime($stadium_id, $date, $start_time, $end_time)
    {
        return Booking::where('stadium_id', $stadium_id)
            ->where('date', $date)
            ->where(function ($query) use ($start_time, $end_time) {
                $query->where('start_time', '<', $end_time)
                    ->where('end_time', '>', $start_time);
            })
            ->exists();
    }

    protected function generateBookedHours($stadium_id, $start_time, $end_time)
    {
        
        $stadium_data = $this->getStadiumTimes($stadium_id);
        $stadium_times = $stadium_data['stadium_times'];
        $std_open_time = $stadium_data['open_time'];
        $std_close_time = $stadium_data['close_time'];

        if ($std_close_time && $std_close_time) {
            // Booking qilinayotgan vaqtda stadion ochiq bo'lmasligi mumkin. 
            // Shuni tekshirish uchun start_time va end_time open_time va close_time ni orasidaligi tekshirilmoqda.
            if (!($std_open_time <= $start_time && $std_close_time >= $end_time)) {
                return false;
            }
        }

        $booked_hours = array_filter($stadium_times, function ($time) use ($start_time, $end_time) {
            return $time >= $start_time && $time <= $end_time;
        });
        return json_encode($booked_hours);
    }
}
