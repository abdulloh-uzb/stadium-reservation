<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use SoftDeletes;

    protected $fillable = ["stadium_id", "user_id", "start_time", "end_time", "status", "date", "booked_hours"];

    public function stadium()
    {
        return $this->belongsTo(Stadium::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
