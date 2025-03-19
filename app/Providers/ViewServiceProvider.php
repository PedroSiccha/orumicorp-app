<?php

namespace App\Providers;

use App\Models\CustomerStatus;
use App\Services\MenuService;
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
            $menuService = new MenuService();
            $menuItems = $menuService->getMenuItems();
    
            // Filtrar rutas accesibles
            $accessibleRoutes = array_filter($menuItems, fn($item) => $item['can']);
    
            // Definir la primera ruta accesible en la sesión
            if (!session()->has('default_route') && !empty($accessibleRoutes)) {
                session(['default_route' => reset($accessibleRoutes)['url']]);
            }
    
            $view->with('menuItems', $menuItems);
        });
    }
}
