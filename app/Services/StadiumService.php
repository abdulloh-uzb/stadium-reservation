<?php

namespace App\Services;

use App\Models\Stadium;

class StadiumService {

    public function store($request)
    {
        $data = $request->validated();

        if(isset($data["is_always_open"]) && (isset($data["open_time"]) || isset($data["close_time"]))){
            dd("error");
        }

        $result = Stadium::create($data);

        return $result;
    }

}