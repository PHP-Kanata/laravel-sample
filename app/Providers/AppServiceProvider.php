<?php

namespace App\Providers;

use App\Repositories\NotesRepository;
use App\Services\ServiceTwoService;
use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;
use League\CommonMark\CommonMarkConverter;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(NotesRepository::class, function ($app) {
            $serviceTwoService = $app->make(ServiceTwoService::class);
            $mdConverter = new CommonMarkConverter();
            return new NotesRepository($mdConverter, $serviceTwoService);
        });

        $this->app->bind(ServiceTwoService::class, function ($app) {
            $httpClient = new Client();
            return new ServiceTwoService($httpClient);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
