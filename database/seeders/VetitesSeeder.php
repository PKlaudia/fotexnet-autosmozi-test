<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Vetitesek;

class VetitesSeeder extends Seeder
{

    public function run()
    {
        Vetitesek::factory(150)->create();
    }
}
