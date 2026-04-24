<?php

namespace Database\Seeders;

use App\Models\Filiere;
use App\Models\Niveau;
use App\Models\Ec;
use App\Models\Ue;
use App\Models\Salle;
use App\Models\Enseigne;
use App\Models\Personnel;
use App\Models\Programme;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //Filiere::factory(2000)->create();
        //Niveau::factory(500)->create();
        //Ec::factory(10)->create();
        Ue::factory(300)->create();
        //Salle::factory(650)->create();
        //Enseigne::factory(1500)->create();
        //Personnel::factory(100)->create();
       // Programme::factory(500)->create();
    }
}
