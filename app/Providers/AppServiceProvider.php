<?php

namespace App\Providers;

use App\Http\Services\Contracts\ProtectionServiceInterface;
use App\Http\Services\TerrainProtectionService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ProtectionServiceInterface::class, TerrainProtectionService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
