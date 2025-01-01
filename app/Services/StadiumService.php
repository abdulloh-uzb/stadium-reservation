<?php

namespace App\Services;

use App\Http\Requests\StoreStadiumRequest;
use App\Models\Stadium;

class StadiumService
{

    public function store(StoreStadiumRequest $request)
    {
        $data = $request->validated();

        if (isset($data["is_always_open"]) && (isset($data["open_time"]) || isset($data["close_time"]))) {
            dd("error");
        }
        if($request->hasFile("images")){
            $data['images'] = json_encode($this->storeImages($request->file('images')));
        }

        $data['owner_id'] = auth("sanctum")->user()->id;
        $result = Stadium::create($data);
        return $result;
    }


    public function storeImages($images)
    {

        // 1. multiple images keladi
        // 2. hasFile() orqali tekshiriladi fayl bor yoki yo'qligi 
        // 3. true bo'lsa foreach orqali har biridan o'tiladi
        // 4. har birini Storage::put() qilib saqlab olamiz va path ni result degan arrayga qo'shib qo'yamiz
        $result = [];

        foreach ($images as $image) {
            $fileName = $image->store('stadiums');
            array_push($result, $fileName);
        }
        
        return $result;
    }
}
