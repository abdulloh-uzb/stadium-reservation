<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "stadium_id" => "required|exists:stadium,id",
            "start_time" => "required|date_format:H:i:s",
            "end_time" => "required|date_format:H:i:s|after:start_time",
            "date" => "required|after_or_equal:today|date_format:m-d-Y"
        ];
    }
}
