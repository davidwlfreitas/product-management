<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * This file is part of ProductManagement,
 * a service provider management solution for Laravel.
 *
 * @license MIT
 * @package davidwlfreitas\ProductManagement
 */
class RepositoriesServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerFileRepository();

        $this->registerExcelRepository();
    }

    /**
     * Register the application services of FileRepository.
     *
     * @return void
     */
    protected function registerFileRepository()
    {
        $this->app->bind('App\Repositories\FileRepositoryInterface',
                          'App\Repositories\FileRepository');
    }

    /**
     * Register the application services of ExcelRepository.
     *
     * @return void
     */
    protected function registerExcelRepository()
    {
        $this->app->bind('App\Repositories\ExcelRepositoryInterface',
                          'App\Repositories\ExcelRepository');
    }
}
