<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use App\Contracts\Repositories\AgentBonusRepositoryInterface;
use App\Contracts\Repositories\AgentRepositoryInterface;
use App\Contracts\Repositories\AreaRepositoryInterface;
use App\Contracts\Repositories\AssignmentRepositoryInterface;
use App\Contracts\Repositories\AssistanceRepositoryInterface;
use App\Contracts\Repositories\AwardRepositoryInterface;
use App\Contracts\Repositories\CampaingRepositoryInterface;
use App\Contracts\Repositories\CategoryFolderRepositoryInterface;
use App\Contracts\Repositories\ClientRepositoryInterface;
use App\Contracts\Repositories\ClientStatusRepositoryInterface;
use App\Contracts\Repositories\ComissionRepositoryInterface;
use App\Contracts\Repositories\ComunicationRepositoryInterface;
use App\Contracts\Repositories\ConfigurationRepositoryInterface;
use App\Contracts\Repositories\DepositRepositoryInterface;
use App\Contracts\Repositories\EventRepositoryInterface;
use App\Contracts\Repositories\ExchangeRepositoryInrterface;
use App\Contracts\Repositories\FolderRepositoryInterface;
use App\Contracts\Repositories\PercentRepositoryInterface;
use App\Contracts\Repositories\PlatformRepositoryInterface;
use App\Contracts\Repositories\PriorityRepositoryInterface;
use App\Contracts\Repositories\ProviderRepositoryInterface;
use App\Contracts\Repositories\RolRepositoryInterface;
use App\Contracts\Repositories\SalesRepositoryInterface;
use App\Contracts\Repositories\SecurityRepositoryInterface;
use App\Contracts\Repositories\ShooterRepositoryInterface;
use App\Contracts\Repositories\TargetRepositoryInterface;
use App\Contracts\Repositories\TaskRepositoryInterface;
use App\Contracts\Repositories\TraidingRepositoryInterface;
use App\Contracts\Repositories\TransactionTypeRepositoryInterface;
use App\Contracts\Repositories\UserRepositoryInterface;
use App\Contracts\Repositories\ViewsRepositoryInterface;
use App\Interfaces\AssignamentInterface;
use App\Interfaces\AwardsInterface;
use App\Interfaces\CampaingInterface;
use App\Interfaces\ComunicationInterface;
use App\Interfaces\ExchangeRateRepository;
use App\Interfaces\ProviderInterface;
use App\Interfaces\RolesInterface;
use App\Interfaces\UserInterface;
use App\Repositories\AgentBonusRepository;
use App\Repositories\AgentRepository;
use App\Repositories\AreaRepository;
use App\Repositories\AssignmentRepository;
use App\Repositories\AssistanceRepository;
use App\Repositories\AwardRepository;
use App\Repositories\CampaingRepository;
use App\Repositories\CategoryFolderRepository;
use App\Repositories\ClientRepository;
use App\Repositories\ClientStatusRepository;
use App\Repositories\ComissionRepository;
use App\Repositories\ComunicationRepository;
use App\Repositories\ConfigurationRepository;
use App\Repositories\DepositRepository;
use App\Repositories\EventRepository;
use App\Repositories\ExchangeRepository;
use App\Repositories\FolderRepository;
use App\Repositories\PercentRepository;
use App\Repositories\PlatformRepository;
use App\Repositories\PriorityRepository;
use App\Repositories\ProviderRepository;
use App\Repositories\RolRepository;
use App\Repositories\SalesRepository;
use App\Repositories\SecurityRepository;
use App\Repositories\ShooterRepository;
use App\Repositories\TargetRepository;
use App\Repositories\TaskRepository;
use App\Repositories\TraidingRepository;
use App\Repositories\TransactionTypeRepository;
use App\Repositories\UserRepository;
use App\Repositories\ViewsRepository;
use App\Services\AgentBonusService;
use App\Services\AgentService;
use App\Services\AreaService;
use App\Services\AssignamentService;
use App\Services\AwardsService;
use App\Services\CampaingService;
use App\Services\CategoryFolderService;
use App\Services\ClientService;
use App\Services\ComunicationService;
use App\Services\DepositService;
use App\Services\FolderService;
use App\Services\PlatformService;
use App\Services\ProviderService;
use App\Services\RolesService;
use App\Services\SalesService;
use App\Services\SecurityService;
use App\Services\ShooterService;
use App\Services\TargetService;
use App\Services\TaskService;
use App\Services\TransactionTypeService;
use App\Services\UserService;
use App\Services\Utils;
use App\Services\ViewsService;
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
        $this->app->bind(UserInterface::class, UserService::class);
        $this->app->bind(RolesInterface::class, RolesService::class);
        $this->app->bind(AwardsInterface::class, AwardsService::class);
        $this->app->bind(ComunicationInterface::class, ComunicationService::class);
        $this->app->bind(AssignamentInterface::class, AssignamentService::class);
        $this->app->bind(CampaingInterface::class, CampaingService::class);
        $this->app->bind(ProviderInterface::class, ProviderService::class);

        $this->app->bind(AgentBonusRepositoryInterface::class, AgentBonusRepository::class);
        $this->app->bind(AgentBonusService::class, function ($app) {
            return new AgentBonusService(
                $app->make(UserRepositoryInterface::class),
                $app->make(AgentRepositoryInterface::class),
                $app->make(PercentRepositoryInterface::class),
                $app->make(ComissionRepositoryInterface::class),
                $app->make(ExchangeRepositoryInrterface::class),
                $app->make(SalesRepositoryInterface::class),
                $app->make(TargetRepositoryInterface::class),
                $app->make(AreaRepositoryInterface::class),
                $app->make(ClientRepositoryInterface::class),
                $app->make(AgentBonusRepositoryInterface::class),
            );
        });

        $this->app->bind(AgentRepositoryInterface::class, AgentRepository::class);
        $this->app->bind(AgentService::class, function ($app) {
            return new AgentService(
                $app->make(Utils::class),
                $app->make(RolesInterface::class),
                $app->make(AgentRepositoryInterface::class),
                $app->make(AreaRepositoryInterface::class),
                $app->make(RolRepositoryInterface::class),
                $app->make(UserRepositoryInterface::class),
            );
        });

        $this->app->bind(AreaRepositoryInterface::class, AreaRepository::class);
        $this->app->bind(AreaService::class, function ($app) {
            return new AreaService(
                $app->make(AreaRepositoryInterface::class),
                $app->make(UserRepositoryInterface::class),
                $app->make(AgentRepositoryInterface::class),
            );
        });

        $this->app->bind(AssignmentRepositoryInterface::class, AssignmentRepository::class);
        $this->app->bind(AssignamentService::class, function ($app) {
            return new AssignamentService(
                $app->make(AssignmentRepositoryInterface::class),
            );
        });

        $this->app->bind(AssistanceRepositoryInterface::class, AssistanceRepository::class);

        $this->app->bind(AwardRepositoryInterface::class, AwardRepository::class);

        $this->app->bind(CampaingRepositoryInterface::class, CampaingRepository::class);
        $this->app->bind(CampaingService::class, function ($app) {
            return new CampaingService(
                $app->make(CampaingRepositoryInterface::class),
            );
        });

        $this->app->bind(CategoryFolderRepositoryInterface::class, CategoryFolderRepository::class);
        $this->app->bind(CategoryFolderService::class, function ($app) {
            return new CategoryFolderService(
                $app->make(CategoryFolderRepositoryInterface::class),
            );
        });

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
                $app->make(ViewsRepositoryInterface::class),
                $app->make(PriorityRepositoryInterface::class),
                $app->make(EventRepositoryInterface::class), 
                $app->make(ClientRepositoryInterface::class),
                $app->make(UserRepositoryInterface::class)
            );
        });

        $this->app->bind(ClientStatusRepositoryInterface::class, ClientStatusRepository::class);

        $this->app->bind(ComissionRepositoryInterface::class, ComissionRepository::class);

        $this->app->bind(ComunicationRepositoryInterface::class, ComunicationRepository::class);
        $this->app->bind(ComunicationService::class, function ($app) {
            return new ComunicationService(
                $app->make(UserRepositoryInterface::class),
                $app->make(AgentRepositoryInterface::class),
                $app->make(ComunicationRepositoryInterface::class),
                $app->make(ClientStatusRepositoryInterface::class),
            );
        });

        $this->app->bind(ConfigurationRepositoryInterface::class, ConfigurationRepository::class);

        $this->app->bind(DepositRepositoryInterface::class, DepositRepository::class);
        $this->app->bind(DepositService::class, function ($app) {
            return new DepositService(
                $app->make(AgentRepositoryInterface::class),
                $app->make(TransactionTypeRepositoryInterface::class),
                $app->make(DepositRepositoryInterface::class),
                $app->make(SalesRepositoryInterface::class),
                $app->make(ClientRepositoryInterface::class),
                $app->make(UserRepositoryInterface::class),
            );
        });

        $this->app->bind(EventRepositoryInterface::class, EventRepository::class);

        $this->app->bind(ExchangeRepositoryInrterface::class, ExchangeRepository::class);

        $this->app->bind(FolderRepositoryInterface::class, FolderRepository::class);
        $this->app->bind(FolderService::class, function ($app) {
            return new FolderService(
                $app->make(FolderRepositoryInterface::class),
                $app->make(RolesService::class),
                $app->make(UserRepositoryInterface::class),
                $app->make(ClientRepositoryInterface::class),
                $app->make(AgentRepositoryInterface::class),
                $app->make(CampaingRepositoryInterface::class),
                $app->make(ProviderRepositoryInterface::class),
                $app->make(ClientStatusRepositoryInterface::class)
            );
        });

        $this->app->bind(PercentRepositoryInterface::class, PercentRepository::class);

        $this->app->bind(PlatformRepositoryInterface::class, PlatformRepository::class);
        $this->app->bind(PlatformService::class, function ($app) {
            return new PlatformService(
                $app->make(PlatformRepositoryInterface::class),
            );
        });

        $this->app->bind(PriorityRepositoryInterface::class, PriorityRepository::class);

        $this->app->bind(ProviderRepositoryInterface::class, ProviderRepository::class);
        $this->app->bind(ProviderService::class, function ($app) {
            return new ProviderService(
                $app->make(ProviderRepositoryInterface::class),
                $app->make(RolRepositoryInterface::class),
                $app->make(UserRepositoryInterface::class),
            );
        });

        $this->app->bind(RolRepositoryInterface::class, RolRepository::class);

        $this->app->bind(SalesRepositoryInterface::class, SalesRepository::class);
        $this->app->bind(SalesService::class, function ($app) {
            return new SalesService(
                $app->make(SalesRepositoryInterface::class),
                $app->make(UserRepositoryInterface::class),
                $app->make(AgentRepositoryInterface::class),
                $app->make(AwardRepositoryInterface::class),
                $app->make(ClientRepositoryInterface::class),
                $app->make(PercentRepositoryInterface::class),
                $app->make(ComissionRepositoryInterface::class),
                $app->make(ExchangeRateRepository::class),
                $app->make(AreaRepositoryInterface::class),
            );
        });

        $this->app->bind(SecurityRepositoryInterface::class, SecurityRepository::class);
        $this->app->bind(SecurityService::class, function ($app) {
            return new SecurityService(
                $app->make(SecurityRepositoryInterface::class),
                $app->make(UserRepositoryInterface::class),
                $app->make(ClientRepositoryInterface::class),
                $app->make(AgentRepositoryInterface::class),
            );
        });

        $this->app->bind(ShooterRepositoryInterface::class, ShooterRepository::class);
        $this->app->bind(ShooterService::class, function ($app) {
            return new ShooterService(
                $app->make(ShooterRepositoryInterface::class),
                $app->make(UserRepositoryInterface::class),
                $app->make(AgentRepositoryInterface::class),
                $app->make(ClientRepositoryInterface::class),
                $app->make(ClientStatusRepositoryInterface::class),
                $app->make(FolderRepositoryInterface::class),
                $app->make(CategoryFolderRepositoryInterface::class),
                $app->make(ComunicationRepositoryInterface::class),
            );
        });

        $this->app->bind(TargetRepositoryInterface::class, TargetRepository::class);
        $this->app->bind(TargetService::class, function ($app) {
            return new TargetService(
                $app->make(TargetRepositoryInterface::class),
                $app->make(AgentRepositoryInterface::class),
            );
        });

        $this->app->bind(TaskRepositoryInterface::class, TaskRepository::class);
        $this->app->bind(TaskService::class, function ($app) {
            return new TaskService(
                $app->make(TaskRepositoryInterface::class),
                $app->make(UserRepositoryInterface::class),
                $app->make(AgentRepositoryInterface::class),
                $app->make(AreaRepositoryInterface::class),
                $app->make(PriorityRepositoryInterface::class),
                $app->make(ClientRepositoryInterface::class),
            );
        });

        $this->app->bind(TraidingRepositoryInterface::class, TraidingRepository::class);

        $this->app->bind(TransactionTypeRepositoryInterface::class, TransactionTypeRepository::class);
        $this->app->bind(TransactionTypeService::class, function ($app) {
            return new TransactionTypeService(
                $app->make(TransactionTypeRepositoryInterface::class),
            );
        });

        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(UserService::class, function ($app) {
            return new UserService(
                $app->make(UserRepositoryInterface::class),
            );
        });

        $this->app->bind(ViewsRepositoryInterface::class, ViewsRepository::class);
        $this->app->bind(ViewsService::class, function ($app) {
            return new ViewsService(
                $app->make(ViewsRepositoryInterface::class),
                $app->make(UserRepositoryInterface::class),
                $app->make(AgentRepositoryInterface::class),
            );
        });
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
