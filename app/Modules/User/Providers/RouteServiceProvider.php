<?php

namespace App\Modules\User\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->routes(function () {
            Route::prefix('user')
                ->middleware(['web'])
                ->group(__DIR__ . '/../routes/web.php');
            
            Route::prefix('api/user')
                ->middleware(['api'])
                ->group(__DIR__ . '/../routes/api.php');
        });
    }
}
