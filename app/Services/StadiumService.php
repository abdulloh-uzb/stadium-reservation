<?php

namespace App\Services;

use App\Models\Stadium;
use Illuminate\Support\Facades\Storage;

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


    public function storeImage($request)
    {
        $file = $request->file('file');
        $fileName = time() . "." . $file->getClientOriginalExtension();
        $path = "uploads/" . $fileName;
        Storage::put($path, $file);

        return $path;
    }

}