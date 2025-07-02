<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Interfaces\PostRepositoryInterface;
use App\Repositories\PostRepository;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
public function register()
{
    $this->app->bind(PostRepositoryInterface::class, PostRepository::class);
}

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
