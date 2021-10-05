<?php

namespace Database\Factories;

use App\Models\Image;
use Illuminate\Database\Eloquent\Factories\Factory;

class ImageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Image::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $location = $this->faker->image('public/img/paint/');
        $location = explode('/', $location);
        $location = $location[1].'/'.$location[2].'/'.$location[4];
        return [
                'title' => $this->faker->word(),
                'location' => $location,
                'model_type' => 'App/Models/ArtPainting',
                'model_id' => $this->faker->numberBetween(2,21)
        ];
    }
}
