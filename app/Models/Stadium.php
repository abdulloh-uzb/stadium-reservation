<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stadium extends Model
{

    use HasFactory;

    protected $table = 'stadium';
    protected $fillable = ["name", "description", "location", "price", "open_time", "close_time"];
}
