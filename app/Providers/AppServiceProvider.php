<?php

namespace App\Providers;

use App\Interfaces\AgentInterface;
use App\Interfaces\AssignamentInterface;
use App\Interfaces\AwardsInterface;
use App\Interfaces\CampaingInterface;
use App\Interfaces\ClientInterface;
use App\Interfaces\ComunicationInterface;
use App\Interfaces\ProviderInterface;
use App\Interfaces\RolesInterface;
use App\Interfaces\UserInterface;
use App\Services\AgentService;
use App\Services\AssignamentService;
use App\Services\AwardsService;
use App\Services\CampaingService;
use App\Services\ClientService;
use App\Services\ComunicationService;
use App\Services\ProviderService;
use App\Services\RolesService;
use App\Services\UserService;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(AgentInterface::class, AgentService::class);
        $this->app->bind(ClientInterface::class, ClientService::class);
        $this->app->bind(UserInterface::class, UserService::class);
        $this->app->bind(RolesInterface::class, RolesService::class);
        $this->app->bind(AwardsInterface::class, AwardsService::class);
        $this->app->bind(ComunicationInterface::class, ComunicationService::class);
        $this->app->bind(AssignamentInterface::class, AssignamentService::class);
        $this->app->bind(CampaingInterface::class, CampaingService::class);
        $this->app->bind(ProviderInterface::class, ProviderService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrapFour();
    }
}
