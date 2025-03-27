<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Film;

class FilmSeeder extends Seeder
{

    public function run()
    {
        Film::factory(50)->create();
    }
}
