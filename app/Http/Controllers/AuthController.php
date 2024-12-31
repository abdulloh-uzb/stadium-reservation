<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validated = $request->validate([
            "name" => ["required", "string"],
            "email" => ["required", "email"],
            "phone_number" => ["required", "regex:/^\+998(33|88|90|91|93|94|95|97|98|99|50)\d{7}$/"],
            "password" => ["required", "confirmed"]
        ]);

        $user = User::create($validated);
        $user->assignRole("customer");
        $result = ["success"=> true, "message"=> "User registered successfully", "data" => $user];

        return response()->json($result);
    }

    public function login(Request $request)
    {

        $validated = $request->validate([
            'email' => ["required"],["email"],
            "password" => ["required"] 
        ]);

        $user = User::where('email', $request->email)->first();

        if(!$user || !Hash::check($validated["password"], $user->password)){
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $token = $user->createToken('test')->plainTextToken;

        return response()->json($token);
    }
}
