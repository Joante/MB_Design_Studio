<?php

namespace App\Providers;

use App\Models\Acounts;
use App\Models\BlogCategory;
use App\Models\Service;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

use function Psy\debug;

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
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $services = Service::all();
        View::share('services', $services);
        $blog_categories = BlogCategory::all();
        View::share('blog_categories', $blog_categories);
        $mbAcounts = Acounts::where('type', '=', 'mb')->first();
        if($mbAcounts->phone != null) {
            $phone_array = str_split($mbAcounts->whats_app,2);
            $phone_formatted = $phone_array[0].'-'.$phone_array[1].$phone_array[2].'-'.$phone_array[3].$phone_array[4];
            $mbAcounts['phone_formatted'] = $phone_formatted;
        }
        View::share('mbAcounts', $mbAcounts);
        Paginator::defaultView('vendor/pagination/bauen');
        \Carbon\Carbon::setLocale(config('app.locale'));

    }
}
