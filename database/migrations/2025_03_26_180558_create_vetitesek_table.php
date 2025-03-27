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
        Schema::create('vetitesek', function (Blueprint $table) {
            $table->id();
            $table->dateTime('time');
            $table->integer('available_seats');
            $table->integer('film_id');
            $table->foreign('film_id')->references('id')->on('films')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vetiteseks');
    }
};
