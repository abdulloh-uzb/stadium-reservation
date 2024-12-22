<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = ["stadium_id", "user_id", "start_time", "end_time", "status", "date", "booked_hours"];
}
