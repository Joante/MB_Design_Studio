<?php

namespace Database\Factories;

use App\Models\ArtPainting;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArtPaintingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ArtPainting::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->words(3,true),
            'description' => $this->faker->words(10,true),
            'width' => $this->faker->randomFloat(2,0.1,5),
            'height'=> $this->faker->randomFloat(2,0.1,5),
            'tecnique' => $this->faker->words(10,true),
            'art_colection_id' => $this->faker->numberBetween(1,4),
        ];
    }
}
