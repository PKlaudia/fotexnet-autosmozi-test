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
        // Films tábla létrehozása
        Schema::create('films', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique();
            $table->text('description');
            $table->string('age_rating');
            $table->string('language');
            $table->string('cover_image');
            $table->timestamps();
        });

        // Vetitesek tábla létrehozása
        Schema::create('vetitesek', function (Blueprint $table) {
            $table->id();
            $table->dateTime('time');
            $table->integer('available_seats');
            $table->integer('film_id')->nullable();  // Nullable, mert törléskor null lesz
            $table->foreign('film_id')->references('id')->on('films')->onDelete('set null'); // Külső kulcs
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Az összes tábla törlése
        Schema::dropIfExists('vetitesek');
        Schema::dropIfExists('films');
    }
};
