<?php
namespace App\Services\Sale;

use App\Contracts\Repositories\SalesRepositoryInterface;

class SalesChartService
{
    protected $repo;

    public function __construct(SalesRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function generarChartData(int $year): array
    {
        $rawData = $this->repo->obtenerTotalesPorMesYArea($year);

        $labels = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
        $datasets = [];

        $areas = $rawData->pluck('area')->unique();

        foreach ($areas as $area) {
            $ventas = $rawData->where('area', $area)->pluck('total_ventas')->toArray();
            $color = $this->colorAleatorio();

            $datasets[] = [
                'label' => $area,
                'backgroundColor' => $color,
                'borderColor' => $color,
                'pointBackgroundColor' => $color,
                'pointBorderColor' => '#fff',
                'data' => $ventas
            ];
        }

        return [
            'labels' => $labels,
            'datasets' => $datasets
        ];
    }

    protected function colorAleatorio(): string
    {
        $colors = ['#1ab394', '#f8ac59', '#23c6c8', '#ed5565', '#1c84c6', '#f0ad4e'];
        return $colors[array_rand($colors)];
    }
}
