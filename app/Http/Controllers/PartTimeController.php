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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

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

        $startDate = $request->dateInit; // Fecha de inicio
        $endDate = $request->dateEnd; // Fecha de fin

        // Convertir fechas al formato YYYY-MM-DD si vienen en MM/DD/YYYY
        if ($startDate) {
            $startDate = Carbon::createFromFormat('m/d/Y', $startDate)->format('Y-m-d');
        } else {
            $startDate = Carbon::now()->toDateString(); // Fecha actual por defecto
        }

        if ($endDate) {
            $endDate = Carbon::createFromFormat('m/d/Y', $endDate)->format('Y-m-d');
        } else {
            $endDate = Carbon::now()->toDateString(); // Fecha actual por defecto
        }

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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function descargarReportePDF()
    {
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
                                    ->groupBy('agents.name', 'agents.lastname', 'assistance.date')
                                    ->get();

        $pdf = new Dompdf();
        $pdf->loadHtml(View::make('report.assistance_pdf', compact('assistances'))->render());
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
    public function descargarReporteExcel()
    {
        return Excel::download(new AsistenciasExport, 'asistencias.xlsx');
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
