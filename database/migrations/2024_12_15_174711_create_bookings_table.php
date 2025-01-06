<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId("stadium_id")->constrained('stadium');
            $table->foreignId("user_id")->constrained();
            $table->time("start_time")->default("00:00:00");
            $table->time("end_time")->default("00:00:00");
            $table->dateTime("date");
            $table->json("booked_hours");
            $table->enum("status", [1,2,3,4])->default(1);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
