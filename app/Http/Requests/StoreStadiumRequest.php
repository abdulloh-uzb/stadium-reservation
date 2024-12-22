<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStadiumRequest extends FormRequest
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
            "name" => "required",
            "location" => "required",
            "price" => "required",
            "description" => "required",
            "phone_number" => "nullable|regex:/(?:\+998|998)(33|88|90|91|93|94|95|97|98|99|50)\d{7}$/",
            "open_time" => "sometimes|required|date_format:H:i:s",
            "close_time" => "required_with:open_time|date_format:H:i:s|after_or_equal:open_time",
            "is_always_open" => "nullable|boolean"  
        ];
    }
}
