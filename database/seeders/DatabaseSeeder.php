<?php

namespace Database\Seeders;

use App\Models\ArtExhibition;
use App\Models\ArtPainting;
use App\Models\Image;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        for ($i=0; $i < 20; $i++) { 
            $painting = ArtPainting::factory()->create();
            for ($j=0; $j < 5; $j++) {
                $location = $faker->image('public/img/paint/');
                $location = explode('/', $location);
                $location = $location[1].'/'.$location[2].'/'.$location[4];
                $image = [
                    'title' => $faker->word(),
                    'location' => $location,
                ]; 
                $painting->images()->create($image);
            }
       }
    }
}
