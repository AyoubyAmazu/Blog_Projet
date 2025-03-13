# to creat all folders in one commands

mkdir -p packageName/{Controllers,Models,Database,Routes,App/{Providers,Exports,Imports,Policies,Requests},Database/{migrations,factories,seeders},Resources/{css,js,views},Services}

# change provider
- global
    public function register(): void
    {
        $this->app->register(BlogServiceProvider::class);
    }

- package providers

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


# run 
composer dump-autoload

