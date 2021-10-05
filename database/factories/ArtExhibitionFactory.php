<?php

namespace Database\Factories;

use App\Models\ArtExhibition;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ArtExhibitionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ArtExhibition::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => Str::random(10),
            'text' =>$this->faker->text(),
            'principal_page' => false,
            'date_start' => $this->faker->dateTime(),
            'date_finish' => $this->faker->dateTime(),
            'location_id' => 1,
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s'),
        ];
    }
}
