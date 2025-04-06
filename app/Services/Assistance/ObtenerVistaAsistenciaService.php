<?php
namespace App\Services\Assistance;

use App\Contracts\Repositories\AssistanceRepositoryInterface;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Carbon;

class ObtenerVistaAsistenciaService
{
    protected $repo;

    public function __construct(AssistanceRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function ejecutar($agentId): array
    {
        $dateIn = $this->repo->getTodayByAgent($agentId)->where('type', 'IN')->first();
        $dateBreakIn = $this->repo->getTodayByAgent($agentId)->where('type', 'IN-BREAK')->first();
        $dateBreakOut = $this->repo->getTodayByAgent($agentId)->where('type', 'OUT-BREAK')->first();
        $dateOut = $this->repo->getTodayByAgent($agentId)->where('type', 'OUT')->first();

        $assistances = $this->repo->getTodayGrouped();

        $formattedData = [];
        $types = ['IN', 'IN-BREAK', 'OUT-BREAK', 'OUT'];

        foreach ($assistances as $record) {
            $date = Carbon::parse($record->date)->format('d/m/Y');
            $agentName = $record->agent_name . ' ' . $record->last_name;
            $area = $record->area_name;

            $formattedData[$date][$agentName]['area'] = $area;
            $formattedData[$date][$agentName][$record->type][] = [
                'hour' => $record->hour,
                'observation' => $record->observation
            ];
        }

        return [
            'view' => View::make('partTime.components.panelButton', compact('dateIn', 'dateBreakIn', 'dateBreakOut', 'dateOut'))->render(),
            'viewTable' => View::make('partTime.components.tabAssistance', compact('assistances', 'formattedData', 'types'))->render()
        ];
    }
}
