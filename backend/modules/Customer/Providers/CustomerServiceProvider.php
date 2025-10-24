<?php
namespace Modules\Customer\Providers;

use Illuminate\Support\ServiceProvider;

class CustomerServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Bind repository interfaces, services, etc.
    }

    public function boot()
    {
        // Example resource loading (in a real Laravel install these helpers exist)
         $this->loadRoutesFrom(__DIR__ . '/../Routes/web.php');
         $this->loadMigrationsFrom(__DIR__ . '/../Migrations');
         $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'customer');
    }
}
