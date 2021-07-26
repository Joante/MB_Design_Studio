<?php

namespace App\Rules;

use App\Models\Project;
use App\Models\Service;
use Illuminate\Contracts\Validation\Rule;

class PrincipalPage implements Rule
{
    public $modelType;
    public $max;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($modelType, $max)
    {
        $this->modelType = $modelType;
        $this->max = $max;
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
                $count = Service::where('principal_page', '=', true)->count();
                break;
            case 'projects':
                $count = Project::where('principal_page', '=', true)->count();
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
