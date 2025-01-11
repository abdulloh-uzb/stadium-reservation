<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReviewRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "booking_id" => "required|exists:bookings,id|unique:reviews,booking_id",
            "rating" => "required|integer|min:1|max:5", 
            "comment" => "required|string|max:255"
        ];
    }
}
