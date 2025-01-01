<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stadium extends Model
{
    use HasFactory;

    protected $table = 'stadium';
    protected $fillable = ["name", "description", "location", "price", "images","open_time", "close_time", "owner_id"];
    
    protected function images(): Attribute
    {
        return Attribute::make(
            get: fn($value) => json_decode($value)
        );
    }

    protected $hidden = [
        "created_at",
        "updated_at"
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, "owner_id");
    }

}
