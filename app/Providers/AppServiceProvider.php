<?php

namespace App\Providers;

use App\Interfaces\AgentInterface;
use App\Interfaces\AssignamentInterface;
use App\Interfaces\AwardRepositoryInterface;
use App\Interfaces\AwardsInterface;
use App\Interfaces\CampaingInterface;
use App\Interfaces\ClientInterface;
use App\Interfaces\ClientRepositoryInterface;
use App\Interfaces\ComunicationInterface;
use App\Interfaces\ConfigurationRepositoryInterface;
use App\Interfaces\ProviderInterface;
use App\Interfaces\RolesInterface;
use App\Interfaces\UserInterface;
use App\Repositories\AgentRepository;
use App\Interfaces\AgentRepositoryInterface;
use App\Repositories\AwardRepository;
use App\Repositories\CampaingRepository;
use App\Interfaces\CampaingRepositoryInterface;
use App\Interfaces\ComunicationRepositoryInterface;
use App\Repositories\ClientRepository;
use App\Repositories\ConfigurationRepository;
use App\Repositories\FolderRepository;
use App\Interfaces\FolderRepositoryInterface;
use App\Repositories\PlatformRepository;
use App\Interfaces\PlatformRepositoryInterface;
use App\Repositories\ProviderRepository;
use App\Interfaces\ProviderRepositoryInterface;
use App\Repositories\RolRepository;
use App\Interfaces\RolRepositoryInterface;
use App\Repositories\TraidingRepository;
use App\Interfaces\TraidingRepositoryInterface;
use App\Repositories\Contracts\AssignmentRepositoryInterface;
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
        // $this->app->bind(AgentInterface::class, AgentService::class);
        // $this->app->bind(ClientInterface::class, ClientService::class);
        $this->app->bind(UserInterface::class, UserService::class);
        $this->app->bind(RolesInterface::class, RolesService::class);
        $this->app->bind(AwardsInterface::class, AwardsService::class);
        $this->app->bind(ComunicationInterface::class, ComunicationService::class);
        $this->app->bind(AssignamentInterface::class, AssignamentService::class);
        $this->app->bind(CampaingInterface::class, CampaingService::class);
        $this->app->bind(ProviderInterface::class, ProviderService::class);

        $this->app->bind(ClientRepositoryInterface::class, ClientRepository::class);
        $this->app->bind(ClientService::class, function ($app) {
            return new ClientService(
                $app->make(RolesInterface::class),
                $app->make(AgentRepositoryInterface::class),
                $app->make(RolRepositoryInterface::class),
                $app->make(ProviderRepositoryInterface::class),
                $app->make(PlatformRepositoryInterface::class),
                $app->make(TraidingRepositoryInterface::class),
                $app->make(FolderRepositoryInterface::class),
                $app->make(CampaingRepositoryInterface::class),
                $app->make(ConfigurationRepositoryInterface::class),
                $app->make(AwardRepositoryInterface::class),
                $app->make(AssignmentRepositoryInterface::class),
                $app->make(ComunicationRepositoryInterface::class),
                $app->make(ClientRepositoryInterface::class),

            );
        });
        $this->app->bind(AgentRepositoryInterface::class, AgentRepository::class);
        $this->app->bind(RolRepositoryInterface::class, RolRepository::class);
        $this->app->bind(ConfigurationRepositoryInterface::class, ConfigurationRepository::class);
        $this->app->bind(ProviderRepositoryInterface::class, ProviderRepository::class);
        $this->app->bind(PlatformRepositoryInterface::class, PlatformRepository::class);
        $this->app->bind(TraidingRepositoryInterface::class, TraidingRepository::class);
        $this->app->bind(FolderRepositoryInterface::class, FolderRepository::class);
        $this->app->bind(CampaingRepositoryInterface::class, CampaingRepository::class);
        $this->app->bind(AwardRepositoryInterface::class, AwardRepository::class);
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
