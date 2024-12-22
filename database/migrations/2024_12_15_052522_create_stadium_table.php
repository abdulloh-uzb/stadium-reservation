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
        Schema::create('stadium', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("description");
            $table->string("location");
            $table->integer("price");
            $table->string("phone_number")->nullable();
            $table->time("open_time")->nullable();
            $table->time("close_time")->nullable();
            $table->boolean("is_always_open")->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stadium');
    }
};
