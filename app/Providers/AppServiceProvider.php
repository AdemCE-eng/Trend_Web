<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     * 
     * This method is called during the application's bootstrapping process
     * and is used to bind services into the service container.
     */
    public function register(): void
    {
        // Register custom services, repositories, or third-party packages here
        // Example: $this->app->singleton(SomeService::class);
    }

    /**
     * Bootstrap any application services.
     * 
     * This method is called after all services have been registered
     * and is used to perform any final configuration or setup.
     */
    public function boot(): void
    {
        // Perform application bootstrapping here
        // Example: View composers, route model bindings, validation rules
    }
}
