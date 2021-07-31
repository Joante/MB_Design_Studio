<?php

namespace App\Providers;

use App\Models\BlogCategory;
use App\Models\Service;
use Illuminate\Support\Facades\View;
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
        $services = Service::all();
        View::share('services', $services);
        $blog_categories = BlogCategory::all();
        View::share('blog_categories', $blog_categories);
    }
}
