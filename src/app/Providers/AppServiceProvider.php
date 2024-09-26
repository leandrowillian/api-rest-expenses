<?php

namespace App\Providers;

use App\Repositories\Contracts\ExpenseRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\EloquentORM\ExpenseEloquentORM;
use App\Repositories\EloquentORM\UserEloquentORM;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Registering repositories abstraction interfaces to concrete implementations
        $this->app->bind(
            UserRepositoryInterface::class,
            UserEloquentORM::class
        );
        $this->app->bind(
            ExpenseRepositoryInterface::class,
            ExpenseEloquentORM::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
