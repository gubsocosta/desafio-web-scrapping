<?php

namespace App\Providers;

use App\Adapters\Caching\RedisCacheClient;
use App\Adapters\CurrencyInfo\GetCurrenciesInfoByIsoCodesAdapter;
use App\Adapters\CurrencyInfo\Services\CacheService;
use App\Adapters\CurrencyInfo\Services\CrawlerService;
use App\Adapters\Http\GuzzleHttpClient;
use App\Adapters\Log\MonologLogger;
use App\Http\Controllers\GetCurrenciesInfoByIsoCodesController;
use Core\Domain\UseCases\GetCurrenciesInfoByIsoCodes\Gateways\GetCurrenciesInfoByIsoCodesGateway;
use Core\Domain\UseCases\GetCurrenciesInfoByIsoCodes\GetCurrenciesInfoByIsoCodesUseCase;
use Core\Infra\Caching\CacheClient;
use Core\Infra\Http\HttpClient;
use Core\Infra\Log\Logger;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class GetCurrenciesInfoByIsoCodesProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(Logger::class, MonologLogger::class);
        $this->app->bind(GetCurrenciesInfoByIsoCodesGateway::class, GetCurrenciesInfoByIsoCodesAdapter::class);
        $this->app->bind(HttpClient::class, GuzzleHttpClient::class);
        $this->app->bind(CacheClient::class, RedisCacheClient::class);
        $this->app->bind(CacheService::class, function (Application $app) {
            return new CacheService($app->make(CacheClient::class));
        });
        $this->app->bind(CrawlerService::class, function (Application $app) {
            return new CrawlerService($app->make(HttpClient::class));
        });
        $this->app->bind(GetCurrenciesInfoByIsoCodesAdapter::class, function (Application $app) {
            return new GetCurrenciesInfoByIsoCodesAdapter(
                $app->make(CacheService::class),
                $app->make(CrawlerService::class),
            );
        });
        $this->app->bind(GetCurrenciesInfoByIsoCodesUseCase::class, function (Application $app) {
            return new GetCurrenciesInfoByIsoCodesUseCase(
                $app->make(Logger::class),
                $app->make(GetCurrenciesInfoByIsoCodesGateway::class)
            );
        });
        $this->app->bind(GetCurrenciesInfoByIsoCodesController::class, function (Application $app) {
            return new GetCurrenciesInfoByIsoCodesController($app->make(GetCurrenciesInfoByIsoCodesUseCase::class));
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
