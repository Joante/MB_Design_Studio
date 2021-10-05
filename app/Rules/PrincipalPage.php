<?php

namespace App\Rules;

use App\Models\ArtExhibition;
use App\Models\ArtPainting;
use App\Models\Post;
use App\Models\Project;
use App\Models\Service;
use Illuminate\Contracts\Validation\Rule;

class PrincipalPage implements Rule
{
    public $modelType;
    public $max;
    public $id;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($modelType, $max, $id = 0)
    {
        $this->modelType = $modelType;
        $this->max = $max;
        $this->id = $id;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        switch($this->modelType) {
            case 'services':
                $count = Service::where('id', '<>', $this->id)->where('principal_page', '=', true)->count();
                break;
            case 'projects':
                $count = Project::where('id', '<>', $this->id)->where('principal_page', '=', true)->count();
                break;
            case 'blog':
                $count = Post::where('id', '<>', $this->id)->where('principal_page', '=', true)->count();
                break;
            case 'exhibitions':
                $count = ArtExhibition::where('id', '<>', $this->id)->where('principal_page', '=', true)->count();
                break;
            case 'paintings': 
                $count = ArtPainting::where('id', '<>', $this->id)->where('principal_page', '=', true)->count();
                break;
        }
        return $count < $this->max;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'La cantidad de modelos para mostrar ya supero el maximo.';
    }
}
