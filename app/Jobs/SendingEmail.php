<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;

class SendingEmail implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public $email)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $status = Password::sendResetLink($this->email);

        if($status != Password::PASSWORD_RESET){
            Log::warning("Failed to send password reset email", [
                'email' => $this->email, 
                'status' => $status,
                'time' => now()
            ]);
        }

    }
}
