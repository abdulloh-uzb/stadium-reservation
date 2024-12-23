<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Stadium;
use Constants;

class BookingService{

    public function booking($data)
    {
        $data['user_id'] = auth("sanctum")->user()->id;

        $start_time = $data["start_time"];
        $end_time = $data["end_time"];

        // stadion nechidan nechigacha ochiq bo'lishini bilish uchun open_time va close_time olinmoqda
        $stadium_times = Stadium::where("id", $data['stadium_id'])->get()->map->only([
            'open_time',
            'close_time'
        ])[0];

        $std_open_time = $stadium_times['open_time'];
        $std_close_time = $stadium_times['close_time'];


        // Bazida stadion butun kun davomida ochiq bo'lishi mumkin shunday vaziyatda open_time va close_time null bo'ladi.
        if ($std_open_time && $std_close_time) {
            
            // Booking qilinayotgan vaqtda stadion ochiq bo'lmasligi mumkin. 
            // Shuni tekshirish uchun start_time va end_time open_time va close_time ni orasidaligi tekshirilmoqda.
            if (!($std_open_time <= $start_time && $std_close_time >= $end_time)) {
                return [
                    'success' => false,
                    "message" => "Stadium does not work in this time"
                ];
            }

            // open_time va close_time orqali stadion ochiq bo'lgan har bir vaqt olinmoqda.
            $stadium_times = array_filter(Constants::get_times(), function ($time) use ($std_open_time, $std_close_time) {
                return $time >= $std_open_time && $time <= $std_close_time;
            });
        } else {
            // agar stadion kun bo'yi ochiq bo'lsa
            $stadium_times = Constants::get_times();
        }

        // oldin band qilingan vaqtda booking qilinmasligi uchun databasedan tekshirilmoqda
        $conflict = Booking::where('stadium_id', $data['stadium_id'])
            ->where('date', $data['date'])
            ->where(function ($query) use ($start_time, $end_time) {
                $query->whereBetween('start_time', [$start_time, $end_time])
                    ->orWhereBetween('end_time', [$start_time, $end_time]);
            })
            ->exists();

        if ($conflict) {
            return [
                'success' => false,
                'message' => 'This time slot is already booked.'
            ];
        }

        // start_time va end_time oraligidagi har bir soat booked_hours ga qo'shilmoqda
        $booked_hours = array_filter($stadium_times, function ($time) use ($start_time, $end_time) {
            return $time >= $start_time && $time <= $end_time;
        });
        $data["booked_hours"] = json_encode($booked_hours);

        Booking::create($data);
        
        return [
            "success" => true,
            "message" => "Stadium booked successfully"
        ];

    }

}