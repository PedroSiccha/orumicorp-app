<?php

namespace App\Http\Controllers;

use App\Exports\AsistenciasExport;
use App\Models\Agent;
use App\Models\Area;
use App\Models\Assistance;
use App\Models\Customers;
use App\Models\Premio;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\View;
use Dompdf\Dompdf;
use Dompdf\Options;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Throwable;

class PartTimeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */ 
    public function index()
    {
        $dateIn = '';
        $dateBreakIn = '';
        $dateBreakOut = '';
        $dateOut = '';
        $user_id = Auth::user()->id;

        $agent = Agent::where('user_id', $user_id)->first();
        $client = Customers::where('user_id', $user_id)->first();

        $dataUser = null;

        if ($agent) {
            $dataUser = $agent;
        }

        if ($client) {
            $dataUser = $client;
        }
        $premios1 = Premio::where('status', true)->where('type', 1)->get();
        $premios2 = Premio::where('status', true)->where('type', 2)->get();

        $dateIn = Assistance::where('date', date('Y-m-d'))->where('type', 'IN')->where('agent_id', $agent->id)->first();
        $dateBreakIn = Assistance::where('date', date('Y-m-d'))->where('type', 'IN-BREAK')->where('agent_id', $agent->id)->first();
        $dateBreakOut = Assistance::where('date', date('Y-m-d'))->where('type', 'OUT-BREAK')->where('agent_id', $agent->id)->first();
        $dateOut = Assistance::where('date', date('Y-m-d'))->where('type', 'OUT')->where('agent_id', $agent->id)->first();

        $assistances = Assistance::select(
            'agents.name',
            'agents.lastname',
            'assistance.date',
            DB::raw("MAX(CASE WHEN assistance.type = 'IN' THEN assistance.hour END) AS 'IN'"),
            DB::raw("MAX(CASE WHEN assistance.type = 'IN-BREAK' THEN assistance.hour END) AS 'INBREAK'"),
            DB::raw("MAX(CASE WHEN assistance.type = 'OUT-BREAK' THEN assistance.hour END) AS 'OUTBREAK'"),
            DB::raw("MAX(CASE WHEN assistance.type = 'OUT' THEN assistance.hour END) AS 'OUT'")
        )
        ->join('agents', 'assistance.agent_id', '=', 'agents.id')
        ->where('agents.id', $agent->id)
        ->groupBy('agents.name', 'agents.lastname', 'assistance.date')
        ->get();

        $rouletteSpin = $agent->number_turns ?: 0;
        $areas = Area::where('status', true)->get();

        // Obtener la fecha actual en formato YYYY-MM-DD
        $currentDate = Carbon::now()->toDateString();

        $assistances = DB::table('assistance as a')
                        ->join('agents as ag', 'a.agent_id', '=', 'ag.id') // Unir con la tabla de agentes
                        ->join('areas as ar', 'ag.area_id', '=', 'ar.id')
                        ->select(
                            'a.date',  // Agregamos la fecha para la agrupación
                            'a.agent_id',
                            'ag.name as agent_name',
                            'ag.lastname as last_name',
                            'ar.name as area_name', // Nombre del área del agente
                            'a.hour',
                            'a.type',
                            'a.observation'
                        )
                        ->where('a.date', $currentDate) 
                        ->orderBy('a.date', 'DESC')
                        ->orderBy('a.hour', 'ASC')
                        ->get();

        $formattedData = [];
        $types = ['IN', 'IN-BREAK', 'OUT-BREAK', 'OUT']; // Tipos fijos

        foreach ($assistances as $record) {
            $date = Carbon::parse($record->date)->format('d/m/Y'); // Formateamos la fecha a DD/MM/YYYY
            $agentName = $record->agent_name . " " . $record->last_name;
            $area = $record->area_name; // Se añade el área
            $type = $record->type;
        
            // Guardamos los tipos de asistencia como claves
            $types[$type] = true;
        
            $formattedData[$date][$agentName]['area'] = $area; // Se almacena el área en la estructura
            // Reorganizamos la estructura de datos
            $formattedData[$date][$agentName][$type][] = [
                'hour' => $record->hour,
                'observation' => $record->observation
            ];
        }

        return view('partTime.index', compact('premios1', 'premios2', 'dataUser', 'dateIn', 'dateBreakIn', 'dateBreakOut', 'dateOut', 'assistances', 'rouletteSpin', 'areas', 'formattedData', 'types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function registerAssistance(Request $request)
    {
        $title = "Error";
        $mensaje = "Error desconocido";
        $status = "error";
        $user_id = Auth::user()->id;
        if ($user_id) {
            $title = "Error";
            $mensaje = "Hubo un error con el usuario";
            $status = "error";
        }
        $agent = Agent::where('user_id', $user_id)->first();
        if ($agent) {
            $title = "Error";
            $mensaje = "Hubo un error con el agente";
            $status = "error";
        }

        $assistance = new Assistance();
        $assistance->hour = $request->hour;
        $assistance->date = $request->date;
        $assistance->type = $request->type;
        $assistance->observation = $request->observation;
        $assistance->agent_id = $agent->id;
        if ($assistance->save()) {
            $title = "Correcto";
            $mensaje = "Su asistencia se registró correctamente";
            $status = "success";
        } else {
            $title = "Error";
            $mensaje = "Hubo un error al registrar su asistencia";
            $status = "error";
        }

        $dateIn = Assistance::where('date', date('Y-m-d'))->where('type', 'IN')->where('agent_id', $agent->id)->first();
        $dateBreakIn = Assistance::where('date', date('Y-m-d'))->where('type', 'IN-BREAK')->where('agent_id', $agent->id)->first();
        $dateBreakOut = Assistance::where('date', date('Y-m-d'))->where('type', 'OUT-BREAK')->where('agent_id', $agent->id)->first();
        $dateOut = Assistance::where('date', date('Y-m-d'))->where('type', 'OUT')->where('agent_id', $agent->id)->first();
        $assistances = Assistance::select(
            'agents.name',
            'agents.lastname',
            'assistance.date',
            DB::raw("MAX(CASE WHEN assistance.type = 'IN' THEN assistance.hour END) AS 'IN'"),
            DB::raw("MAX(CASE WHEN assistance.type = 'IN-BREAK' THEN assistance.hour END) AS 'INBREAK'"),
            DB::raw("MAX(CASE WHEN assistance.type = 'OUT-BREAK' THEN assistance.hour END) AS 'OUTBREAK'"),
            DB::raw("MAX(CASE WHEN assistance.type = 'OUT' THEN assistance.hour END) AS 'OUT'")
        )
        ->join('agents', 'assistance.agent_id', '=', 'agents.id')
        ->where('agents.id', $agent->id)
        ->where('assistance.date', date('Y-m-d'))
        ->groupBy('agents.name', 'agents.lastname', 'assistance.date')
        ->get();

        // Obtener la fecha actual en formato YYYY-MM-DD
        $currentDate = Carbon::now()->toDateString();

        $assistances = DB::table('assistance as a')
                        ->join('agents as ag', 'a.agent_id', '=', 'ag.id') // Unir con la tabla de agentes
                        ->join('areas as ar', 'ag.area_id', '=', 'ar.id')
                        ->select(
                            'a.date',  // Agregamos la fecha para la agrupación
                            'a.agent_id',
                            'ag.name as agent_name',
                            'ag.lastname as last_name',
                            'ar.name as area_name', // Nombre del área del agente
                            'a.hour',
                            'a.type',
                            'a.observation'
                        )
                        ->where('a.date', $currentDate) 
                        ->orderBy('a.date', 'DESC')
                        ->orderBy('a.hour', 'ASC')
                        ->get();

        $formattedData = [];
        $types = ['IN', 'IN-BREAK', 'OUT-BREAK', 'OUT']; // Tipos fijos

        foreach ($assistances as $record) {
            $date = Carbon::parse($record->date)->format('d/m/Y'); // Formateamos la fecha a DD/MM/YYYY
            $agentName = $record->agent_name . " " . $record->last_name;
            $area = $record->area_name; // Se añade el área
            $type = $record->type;
        
            // Guardamos los tipos de asistencia como claves
            $types[$type] = true;
        
            $formattedData[$date][$agentName]['area'] = $area; // Se almacena el área en la estructura
            // Reorganizamos la estructura de datos
            $formattedData[$date][$agentName][$type][] = [
                'hour' => $record->hour,
                'observation' => $record->observation
            ];
        }

        return response()->json(["view"=>view('partTime.components.panelButton', compact('dateIn', 'dateBreakIn', 'dateBreakOut', 'dateOut'))->render(), "viewTable"=>view('partTime.components.tabAssistance', compact('assistances', 'formattedData', 'types'))->render(), "title"=>$title, "text"=>$mensaje, "status"=>$status]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function filterAssistance(Request $request)
    {

        $nombre = $request->code;
        $area = $request->area;

        $user_id = Auth::user()->id;
        $agent = Agent::where('user_id', $user_id)->first();

        // Convertir fechas al formato interno (YYYY-MM-DD)
        $startDate = $this->parseDate($request->dateInit) ?? Carbon::now()->toDateString();
        $endDate = $this->parseDate($request->dateEnd) ?? Carbon::now()->toDateString();

       // Construcción de la consulta con JOINs para incluir el área del agente
        $query = DB::table('assistance as a')
                    ->join('agents as ag', 'a.agent_id', '=', 'ag.id')
                    ->join('areas as ar', 'ag.area_id', '=', 'ar.id') // Relación con áreas
                    ->select(
                        'a.date',  // Agregamos la fecha para la agrupación
                        'a.agent_id',
                        'ag.name as agent_name',
                        'ag.lastname as last_name',
                        'ar.name as area_name', // Nombre del área del agente
                        'a.hour',
                        'a.type',
                        'a.observation'
                    )
                    ->whereBetween('a.date', [$startDate, $endDate]) 
                    ->orderBy('a.date', 'DESC')  // Ordenamos por fecha
                    ->orderBy('a.hour', 'ASC');

        // Si se ingresó un nombre de agente, aplicamos el filtro
        if (!empty($nombre)) {
            $query->where(DB::raw("CONCAT(ag.name, ' ', ag.lastname)"), 'LIKE', "%{$nombre}%");
        }

        if (!empty($area)) {
            $query->where('ag.area_id', $area);
        }

        // Obtener los resultados
        $assistances = $query->get();

        // **Nueva estructura** para mostrar correctamente las fechas
        $formattedData = [];
        $types = ['IN', 'IN-BREAK', 'OUT-BREAK', 'OUT']; // Tipos fijos

        foreach ($assistances as $record) {
            $date = Carbon::parse($record->date)->format('d/m/Y'); // Formateamos la fecha a DD/MM/YYYY
            $agentName = $record->agent_name . " " . $record->last_name;
            $area = $record->area_name; // Se añade el área
    
            $type = $record->type;
    
            $formattedData[$date][$agentName]['area'] = $area; // Se almacena el área en la estructura
            $formattedData[$date][$agentName][$type][] = [
                'hour' => $record->hour,
                'observation' => $record->observation
            ];
        }

        return response()->json(["view"=>view('partTime.components.tabAssistance', compact('assistances', 'formattedData', 'types'))->render()]);
    }

    // Función para convertir string dd/mm/yyyy a Y-m-d
    private function parseDate($date)
    {
        try {
            return Carbon::createFromFormat('d/m/Y', $date)->format('Y-m-d');
        } catch (Exception $e) {
            return null;
        }
    }

    // Formateo limpio
    // private function formatAssistances($assistances)
    // {
    //     $formatted = [];
    //     $types = ['IN', 'IN-BREAK', 'OUT-BREAK', 'OUT'];

    //     foreach ($assistances as $record) {
    //         $date = Carbon::parse($record->date)->format('d/m/Y');
    //         $agentName = $record->agent_name . " " . $record->last_name;
    //         $type = $record->type;

    //         $formatted[$date][$agentName]['area'] = $record->area_name;
    //         $formatted[$date][$agentName][$type][] = [
    //             'hour' => $record->hour,
    //             'observation' => $record->observation
    //         ];
    //     }

    //     return $formatted;
    // }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function descargarReportePDF(Request $request)
    {
        $dateStart = $request->input('date_start');
        $dateEnd = $request->input('date_end');
        $areaId = $request->input('area');
        $code = $request->input('code');

        $query = Assistance::with('agent')
            ->select('agent_id', 'date', 'hour', 'type', 'observation')
            ->join('agents', 'assistance.agent_id', '=', 'agents.id');

        if ($dateStart && $dateEnd) {
            $start = Carbon::createFromFormat('d/m/Y', $dateStart)->format('Y-m-d');
            $end = Carbon::createFromFormat('d/m/Y', $dateEnd)->format('Y-m-d');
            $query->whereBetween('assistance.date', [$start, $end]);
        }

        if ($areaId) {
            $query->where('agents.area_id', $areaId);
        }

        if ($code) {
            $query->where(function ($q) use ($code) {
                $q->where('agents.name', 'like', '%' . $code . '%')
                ->orWhere('agents.lastname', 'like', '%' . $code . '%')
                ->orWhere('agents.code_voiso', 'like', '%' . $code . '%');
            });
        }

        $data = $query->orderBy('date')->orderBy('hour')->get();

        // Agrupar por fecha + agente
        $grouped = $data->groupBy(fn($a) => $a->date . '_' . $a->agent_id);

        $assistances = collect();

        foreach ($grouped as $group) {
            $first = $group->first();
            $agent = $first->agent;

            $record = [
                'date' => $first->date,
                'agent' => $agent->name . ' ' . $agent->lastname,
                'IN' => '',
                'INBREAK' => '',
                'OUTBREAK' => '',
                'OUT' => '',
            ];

            foreach ($group as $entry) {
                $value = $entry->hour;
                if (!empty($entry->observation)) {
                    $value .= "<br><small>" . $entry->observation . "</small>";
                }

                switch ($entry->type) {
                    case 'IN': $record['IN'] = $value; break;
                    case 'IN-BREAK': $record['INBREAK'] = $value; break;
                    case 'OUT-BREAK': $record['OUTBREAK'] = $value; break;
                    case 'OUT': $record['OUT'] = $value; break;
                }
            }

            $assistances->push($record);
        }

        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $options->set('isHtml5ParserEnabled', true);

        $pdf = new Dompdf($options);
        $pdf->loadHtml(view('report.assistance_pdf', ['assistances' => $assistances])->render());
        $pdf->setPaper('A4', 'landscape');
        $pdf->render();

        return $pdf->stream('asistencia.pdf');
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function descargarReporteExcel(Request $request)
    {
        try {
            return Excel::download(
                new AsistenciasExport(
                    $request->input('date_start'),
                    $request->input('date_end'),
                    $request->input('area'),
                    $request->input('code')
                ),
                'asistencias.xlsx'
            );
        } catch (Throwable $e) {
            dd($e->getMessage());
            return response($e->getMessage(), 500); // Devuelve el mensaje exacto
        }
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function registerVacations(Request $request)
    {
        $title = "Error";
        $mensaje = "Error desconocido";
        $status = "error";
        $user_id = Auth::user()->id;
        if ($user_id) {
            $title = "Error";
            $mensaje = "Hubo un error con el usuario";
            $status = "error";
        }
        $agent = Agent::where('user_id', $user_id)->first();
        if ($agent) {
            $title = "Error";
            $mensaje = "Hubo un error con el agente";
            $status = "error";
        }

        $assistance = new Assistance();
        $assistance->hour = '00:00:00';
        $assistance->date = $request->dateInitVacations;
        $assistance->date_end = $request->dateEndVacations;
        $assistance->type = 'VACATION';
        $assistance->observation = $request->observation;
        $assistance->agent_id = $agent->id;
        if ($assistance->save()) {
            $title = "Correcto";
            $mensaje = "Su asistencia se registró correctamente";
            $status = "success";
        } else {
            $title = "Error";
            $mensaje = "Hubo un error al registrar su asistencia";
            $status = "error";
        }

        $dateIn = Assistance::where('date', date('Y-m-d'))->where('type', 'IN')->where('agent_id', $agent->id)->first();
        $dateBreakIn = Assistance::where('date', date('Y-m-d'))->where('type', 'IN-BREAK')->where('agent_id', $agent->id)->first();
        $dateBreakOut = Assistance::where('date', date('Y-m-d'))->where('type', 'OUT-BREAK')->where('agent_id', $agent->id)->first();
        $dateOut = Assistance::where('date', date('Y-m-d'))->where('type', 'OUT')->where('agent_id', $agent->id)->first();

        // Obtener la fecha actual en formato YYYY-MM-DD
        $currentDate = Carbon::now()->toDateString();

        $assistances = DB::table('assistance as a')
                        ->join('agents as ag', 'a.agent_id', '=', 'ag.id') // Unir con la tabla de agentes
                        ->join('areas as ar', 'ag.area_id', '=', 'ar.id')
                        ->select(
                            'a.date',  // Agregamos la fecha para la agrupación
                            'a.agent_id',
                            'ag.name as agent_name',
                            'ag.lastname as last_name',
                            'ar.name as area_name', // Nombre del área del agente
                            'a.hour',
                            'a.type',
                            'a.observation'
                        )
                        ->where('a.date', $currentDate) 
                        ->orderBy('a.date', 'DESC')
                        ->orderBy('a.hour', 'ASC')
                        ->get();

        $formattedData = [];
        $types = ['IN', 'IN-BREAK', 'OUT-BREAK', 'OUT']; // Tipos fijos

        foreach ($assistances as $record) {
            $date = Carbon::parse($record->date)->format('d/m/Y'); // Formateamos la fecha a DD/MM/YYYY
            $agentName = $record->agent_name . " " . $record->last_name;
            $area = $record->area_name; // Se añade el área
            $type = $record->type;
        
            // Guardamos los tipos de asistencia como claves
            $types[$type] = true;
        
            $formattedData[$date][$agentName]['area'] = $area; // Se almacena el área en la estructura
            // Reorganizamos la estructura de datos
            $formattedData[$date][$agentName][$type][] = [
                'hour' => $record->hour,
                'observation' => $record->observation
            ];
        }


        return response()->json(["view"=>view('partTime.components.panelButton', compact('dateIn', 'dateBreakIn', 'dateBreakOut', 'dateOut'))->render(), "viewTable"=>view('partTime.components.tabAssistance', compact('assistances', 'formattedData', 'types'))->render(), "title"=>$title, "text"=>$mensaje, "status"=>$status]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
