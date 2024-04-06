<?php

namespace App\Providers;

use App\Models\Acounts;
use App\Models\BlogCategory;
use App\Models\Service;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

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
        if($this->app->environment('production')) {
            \URL::forceScheme('https');
        }        
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        
        $services = [];
        $blog_categories = [];
        $mbAcounts = [];
        $db = false;
        
       /*  try {
            $dbconnect = DB::connection()->getPDO();
            $db = true;
        } catch(\Exception $e) {
            echo $e->getMessage();
        }
        
        if($db){
            if (Schema::hasTable('services')) {
                $services = Service::all();
            }
            if (Schema::hasTable('blog_categories')) {
                $blog_categories = BlogCategory::all();
            }
            if(Schema::hasTable('acounts')){
                $mbAcounts = Acounts::where('type', '=', 'mb')->first();
                if($mbAcounts != null && $mbAcounts->whats_app != null) {
                    $countryCode = substr($mbAcounts->whats_app, 0,2);
                    $phone = substr_replace($mbAcounts->whats_app,'',0,2);
                    if($countryCode == 54 ){
                        $phone_array = str_split($phone,2);
                        $phone_formatted = '+'. $countryCode.' '.$phone_array[0].'-'.$phone_array[1].$phone_array[2].'-'.$phone_array[3].$phone_array[4];
                    }else if($countryCode == 34){
                        $phone_array = str_split($phone,3);
                        $phone_formatted = '+'. $countryCode.' '.$phone_array[0].' '.$phone_array[1].' '.$phone_array[2];
                        
                    }
                    $mbAcounts['phone_formatted'] = $phone_formatted;
                }
            }
        } */
        
        View::share('services', $services);
        View::share('blog_categories', $blog_categories);
        View::share('mbAcounts', $mbAcounts);
        
        Paginator::defaultView('vendor/pagination/bauen');
        \Carbon\Carbon::setLocale(config('app.locale'));

    }
}
