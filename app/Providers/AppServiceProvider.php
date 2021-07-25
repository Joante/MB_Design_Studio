<?php

namespace App\Providers;

use App\Models\Service;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /*
        Validator::extend('principal_page', function($attribute, $value, $parameters) {
            switch($parameters['modelType']) {
                case 'services':
                    $count = Service::where('page_principal', '=', true)->count();
                    break;
            }
            if($count > $this->max) {
                return false;
            }
            return true;
        });*/
    }
}
