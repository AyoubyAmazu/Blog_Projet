<?php

namespace Modules\Blog\App\Providers;

use Illuminate\Support\ServiceProvider;


class BlogServiceProvider extends ServiceProvider
{

    public function boot()
    {

        $this->loadRoutesFrom(__DIR__."/../../Routes/web.php");

        $this->loadMigrationsFrom(__DIR__."/../../Database/migrations");

        $this->loadViewsFrom(__DIR__."/../../Resources/views","Blog");

        $this->publishes(
            [
                __DIR__."/../../Resources/views" => resource_path("views/vendor/Blog")
            ],'Blog_views'
        );




    }


    function register()
    {
        
    }
}