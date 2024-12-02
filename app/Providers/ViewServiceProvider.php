<?php

namespace App\Providers;

use App\Models\CustomerStatus;
use App\Models\NotificationOnUpdateModel;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;

class ViewServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Compartir statusCustomers en vistas específicas
        View::composer('cliente.modal.modalCrearComentario', function ($view) {
            $statusCustomers = Cache::remember('status_customers', 3600, function () {
                return CustomerStatus::all();
            });
            $view->with('statusCustomers', $statusCustomers);
        });

        View::composer('partials.sidebar', function ($view) {
            $view->with('menuItems', $this->getMenuItems());
        });
    }

    private function getMenuItems()
    {
        return [
            [
                'label' => 'Tablero',
                'icon' => 'fa fa-home',
                'url' => route('dashboard'),
                'route' => 'dashboard',
                'can' => true,
                'notification' => 0,
            ],
            [
                'label' => 'Agentes',
                'icon' => 'fa fa-user-o',
                'url' => route('agents'),
                'route' => 'agents',
                'can' => auth()->user()->can('Ver Agentes'),
                'notification' => NotificationOnUpdateModel::where('user_id', auth()->id())->where('module', 'agents')->where('is_seen', false)->count()
            ],
            [
                'label' => 'Clientes',
                'icon' => 'fa fa-user-o',
                'url' => route('clients'),
                'route' => 'clients',
                'can' => auth()->user()->can('Ver Cliente'),
                'notification' => NotificationOnUpdateModel::where('user_id', auth()->id())->where('module', 'clients')->where('is_seen', false)->count()
            ],
            [
                'label' => 'Áreas',
                'icon' => 'fa fa-user-o',
                'url' => route('areas'),
                'route' => 'areas',
                'can' => auth()->user()->can('Ver Area'),
                'notification' => NotificationOnUpdateModel::where('user_id', auth()->id())->where('module', 'areas')->where('is_seen', false)->count()
            ],
            [
                'label' => 'Ventas',
                'icon' => 'fa fa-file-text-o',
                'url' => route('sales'),
                'route' => 'sales',
                'can' => auth()->user()->can('Ver Ventas'),
                'notification' => NotificationOnUpdateModel::where('user_id', auth()->id())->where('module', 'sales')->where('is_seen', false)->count()
            ],
            [
                'label' => 'Bonus agente',
                'icon' => 'fa fa-dot-circle-o',
                'url' => route('agentBonus'),
                'route' => 'agentbonus',
                'can' => auth()->user()->can('Ver Bonus'),
                'notification' => NotificationOnUpdateModel::where('user_id', auth()->id())->where('module', 'agentbonus')->where('is_seen', false)->count()
            ],
            [
                'label' => 'Today Statistic',
                'icon' => 'fa fa-bar-chart',
                'url' => route('statisticsToday'),
                'route' => 'statisticstoday',
                'can' => auth()->user()->can('Ver Today'),
                'notification' => NotificationOnUpdateModel::where('user_id', auth()->id())->where('module', 'statisticstoday')->where('is_seen', false)->count()
            ],
            [
                'label' => 'Gestión de Ruleta',
                'icon' => 'fa fa-bar-chart',
                'url' => route('gestionRuleta'),
                'route' => 'gestionRuleta',
                'can' => auth()->user()->can('Ver Gestión Ruleta'),
                'notification' => NotificationOnUpdateModel::where('user_id', auth()->id())->where('module', 'gestionRuleta')->where('is_seen', false)->count()
            ],
            [
                'label' => 'Part Time',
                'icon' => 'fa fa-file-text-o',
                'url' => route('partTime'),
                'route' => 'parttime',
                'can' => auth()->user()->can('Ver Part Time'),
                'notification' => NotificationOnUpdateModel::where('user_id', auth()->id())->where('module', 'parttime')->where('is_seen', false)->count()
            ],
            [
                'label' => 'Seguridad',
                'icon' => 'fa fa-lock',
                'url' => route('security'),
                'route' => 'security',
                'can' => auth()->user()->can('Ver Seguridad'),
                'notification' => NotificationOnUpdateModel::where('user_id', auth()->id())->where('module', 'security')->where('is_seen', false)->count()
            ],
            [
                'label' => 'Auditoria',
                'icon' => 'fa fa-warning',
                'url' => route('audit'),
                'route' => 'audit',
                'can' => auth()->user()->can('Ver Auditoria'),
                'notification' => NotificationOnUpdateModel::where('user_id', auth()->id())->where('module', 'audit')->where('is_seen', false)->count()
            ],
            [
                'label' => 'Task',
                'icon' => 'fa fa-calendar',
                'url' => route('task'),
                'route' => 'task',
                'can' => auth()->user()->can('Ver Task'),
                'notification' => NotificationOnUpdateModel::where('user_id', auth()->id())->where('module', 'task')->where('is_seen', false)->count()
            ],
            [
                'label' => 'Whatsapp',
                'icon' => 'fa fa-comments-o',
                'url' => route('whatsapp'),
                'route' => 'whatsapp',
                'can' => auth()->user()->can('Ver Whatsapp'),
                'notification' => NotificationOnUpdateModel::where('user_id', auth()->id())->where('module', 'whatsapp')->where('is_seen', false)->count()
            ],
            [
                'label' => 'Mail',
                'icon' => 'fa fa-comments-o',
                'url' => route('mail'),
                'route' => 'mail',
                'can' => auth()->user()->can('Ver Mail'),
                'notification' => NotificationOnUpdateModel::where('user_id', auth()->id())->where('module', 'mail')->where('is_seen', false)->count()
            ],
            [
                'label' => 'Shooter',
                'icon' => 'fa fa-superpowers',
                'url' => route('shooter'),
                'route' => 'shooter',
                'can' => auth()->user()->can('Ver Shooter'),
                'notification' => NotificationOnUpdateModel::where('user_id', auth()->id())->where('module', 'shooter')->where('is_seen', false)->count()
            ],
            [
                'label' => 'Deposit',
                'icon' => 'fa fa-credit-card',
                'url' => route('deposit'),
                'route' => 'deposit',
                'can' => auth()->user()->can('Ver Deposit'),
                'notification' => NotificationOnUpdateModel::where('user_id', auth()->id())->where('module', 'deposit')->where('is_seen', false)->count()
            ],
            [
                'label' => 'Mantenimiento',
                'icon' => 'fa fa-cogs',
                'url' => route('maintenance'),
                'route' => 'maintenance',
                'can' => auth()->user()->can('Ver Mantenimiento'),
                'notification' => NotificationOnUpdateModel::where('user_id', auth()->id())->where('module', 'maintenance')->where('is_seen', false)->count()
            ]
        ];
    }
}
