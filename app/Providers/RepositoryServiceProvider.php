<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\{
    CatalogRepositoryInterface,
    CatalogRepository,
    ProductRepositoryInterface,
    ProductRepository,
    SaleRepositoryInterface,
    SaleRepository
};

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(CatalogRepositoryInterface::class, CatalogRepository::class);
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(SaleRepositoryInterface::class, SaleRepository::class);
    }

    public function boot(): void
    {
        //
    }
}
