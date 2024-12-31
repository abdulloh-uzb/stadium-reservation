<?php

namespace App\Http\Controllers;

use App\Jobs\SendingEmail;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class PasswordResetController extends Controller
{
        public function requestPasswordReset(Request $request)
        {
            $request->validate([
                "email" => "required|email"
            ]);

            SendingEmail::dispatch($request->only("email"));

            return [
                "status" => true,
                "message" => "success",
            ];
        }

    public function resetPassword(Request $request)
    {
        $request->validate([
            "token" => "required",
            "email" => "required|email",
            "password" => "required|min:6|confirmed"
        ]);

        $status = Password::reset(
            $request->only("email", "password", "token"),
            function (User $user, string $password) {
                $user->forceFill([
                    "password" => Hash::make($password)
                ]);

                $user->save();

                event(new PasswordReset($user));
            }
        );
        return $status === Password::PASSWORD_RESET ? [
            "status" => true,
            "message" => "success"
        ] :
            [
                "status" => false,
                "message" => $status
            ];
    }
}
