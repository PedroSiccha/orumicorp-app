<?php

namespace App\Exports;

use App\Models\Assistance;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AsistenciasExport implements FromCollection, WithHeadings
{
    protected $dateStart, $dateEnd, $areaId, $code;

    public function __construct($dateStart = null, $dateEnd = null, $areaId = null, $code = null)
    {
        $this->dateStart = $dateStart;
        $this->dateEnd = $dateEnd;
        $this->areaId = $areaId;
        $this->code = $code;
    }

    public function collection(): Collection
    {
        $query = Assistance::with('agent')
            ->select('agent_id', 'date', 'hour', 'type', 'observation')
            ->join('agents', 'assistance.agent_id', '=', 'agents.id');

        // Filtros
        if ($this->dateStart && $this->dateEnd) {
            $start = Carbon::createFromFormat('d/m/Y', $this->dateStart)->format('Y-m-d');
            $end = Carbon::createFromFormat('d/m/Y', $this->dateEnd)->format('Y-m-d');
            $query->whereBetween('assistance.date', [$start, $end]);
        }

        if ($this->areaId) {
            $query->where('agents.area_id', $this->areaId);
        }

        if ($this->code) {
            $query->where(function ($q) {
                $q->where('agents.name', 'like', '%' . $this->code . '%')
                    ->orWhere('agents.lastname', 'like', '%' . $this->code . '%')
                    ->orWhere('agents.code_voiso', 'like', '%' . $this->code . '%');
            });
        }

        $assistances = $query->orderBy('date')->orderBy('hour')->get();

        $grouped = $assistances->groupBy(function ($item) {
            return $item->date . '_' . $item->agent_id;
        });

        $rows = collect();

        foreach ($grouped as $group) {
            $first = $group->first();
            $agent = $first->agent;

            $row = [
                $agent->name,
                $agent->lastname,
                $first->date,
                '',
                '',
                '',
                '',
            ];

            foreach ($group as $entry) {
                $observation = trim(strip_tags($entry->observation));
                $value = $entry->hour;

                if (!empty($observation)) {
                    // Usamos un separador seguro para Excel
                    $value .= ' — ' . $observation;
                }

                switch ($entry->type) {
                    case 'IN': $row[3] = $value; break;
                    case 'IN-BREAK': $row[4] = $value; break;
                    case 'OUT-BREAK': $row[5] = $value; break;
                    case 'OUT': $row[6] = $value; break;
                }
            }

            $rows->push($row);
        }

        return $rows;
    }

    public function headings(): array
    {
        return [
            'Nombre del Agente',
            'Apellido del Agente',
            'Fecha de Asistencia',
            'Hora de Ingreso',
            'Hora de Break',
            'Vuelta de Break',
            'Hora de Salida',
        ];
    }
}
