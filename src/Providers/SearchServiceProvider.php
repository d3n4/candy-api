<?php

namespace GetCandy\Api\Providers;

use GetCandy\Api\Core\Search\Factories\SearchResultFactory;
use GetCandy\Api\Core\Search\Interfaces\SearchResultInterface;
use GetCandy\Api\Core\Search\SearchContract;
use Illuminate\Support\ServiceProvider;

class SearchServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(SearchContract::class, function ($app) {
            return $app->make(config('getcandy.search.client'));
        });

        $this->app->bind(SearchResultInterface::class, function ($app) {
            return $app->make(SearchResultFactory::class);
        });
    }
}
