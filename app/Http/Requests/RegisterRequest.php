<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "name" => ["required", "string"],
            "email" => ["required", "email"],
            "phone_number" => ["required", "regex:/^\+998(33|88|90|91|93|94|95|97|98|99|50)\d{7}$/"],
            "password" => ["required", "confirmed"]
        ];
    }
}
