<?php

namespace App\Exports;

use App\Models\Assistance;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;

class AsistenciasExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Assistance::select(
                'agents.name',
                'agents.lastname',
                'assistance.date',
                DB::raw("MAX(CASE WHEN assistance.type = 'IN' THEN assistance.hour END) AS ´IN´"),
                DB::raw("MAX(CASE WHEN assistance.type = 'IN-BREAK' THEN assistance.hour END) AS ´INBREAK´"),
                DB::raw("MAX(CASE WHEN assistance.type = 'OUT-BREAK' THEN assistance.hour END) AS ´OUTBREAK´"),
                DB::raw("MAX(CASE WHEN assistance.type = 'OUT' THEN assistance.hour END) AS ´OUT´")
            )
            ->join('agents', 'assistance.agent_id', '=', 'agents.id')
            ->groupBy('agents.name', 'agents.lastname', 'assistance.date')
            ->get();
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
