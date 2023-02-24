<?php

namespace App\Providers;

use App\Service\BusinessLogic\WidgetBusinessLogicService;
use App\Service\BusinessLogic\WidgetBusinessLogicServiceInterface;
use App\Service\Catalog\CatalogApiService;
use App\Service\Catalog\CatalogApiServiceInterface;
use App\Service\Lead\LeadApiService;
use App\Service\Lead\LeadApiServiceInterface;
use App\Service\Product\ProductApiServiceInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // TODO если не будет работать то зарегистрировать в composer.json
        $this->app->bind(CatalogApiServiceInterface::class, CatalogApiService::class);
        $this->app->bind(LeadApiServiceInterface::class, LeadApiService::class);
        $this->app->bind(ProductApiServiceInterface::class, ProductApiServiceInterface::class);
        $this->app->bind(WidgetBusinessLogicServiceInterface::class, WidgetBusinessLogicService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
