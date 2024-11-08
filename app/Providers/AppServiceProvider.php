<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $repositories = config('repositories');
        foreach ($repositories as $abstract => $concrete) {
            if (is_array($concrete)) {
                foreach ($concrete as $repository) {
                    $this->app->bind($abstract, $repository);
                }
            } else {
                $this->app->bind($abstract, $concrete);
            }
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
