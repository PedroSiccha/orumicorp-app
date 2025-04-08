<?php

namespace App\Http\Controllers;

use App\Exports\AsistenciasExport;
use App\Http\Requests\AssistanceRequest;
use App\Http\Requests\PartTimeRequest;
use App\Models\Agent;
use App\Models\Area;
use App\Models\Assistance;
use App\Models\Customers;
use App\Models\Premio;
use App\Services\Assistance\ObtenerVistaAsistenciaService;
use App\Services\Assistance\RegistrarAsistenciaService;
use App\Services\PartTimeService;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\View;
use Dompdf\Dompdf;
use Dompdf\Options;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Throwable;

class PartTimeController extends Controller
{

    // protected $partTimeService;

    protected $registrarAsistencia;
    protected $obtenerAsistencia;


    public function __construct(
        // PartTimeService $partTimeService,

        RegistrarAsistenciaService $registrarAsistencia,
        ObtenerVistaAsistenciaService $obtenerAsistencia
    ) {
        // $this->partTimeService = $partTimeService;

        $this->registrarAsistencia = $registrarAsistencia;
        $this->obtenerAsistencia = $obtenerAsistencia;
    }

    public function registerAssistance(Request $request)
    {
        try {
            $data = $request->only(['hour', 'date', 'type', 'observation']);
            $this->registrarAsistencia->ejecutar($data);

            return response()->json([
                'status' => 'success',
                'title' => 'Correcto',
                'text' => 'Asistencia registrada correctamente',
            ], 201); // <- mejor semántica para creación exitosa
        } catch (Exception $e) {
            Log::error('Error registrando asistencia: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'title' => 'Error al registrar asistencia',
                'text' => 'Verifica tu conexión o intenta nuevamente.',
            ], 500);
        }
    }


    public function obtenerAsistencia()
    {
        try {
            $agentId = Auth::user()->agent->id ?? null;

            if (!$agentId) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'El usuario no tiene agente asignado.'
                ], 422);
            }

            $data = $this->obtenerAsistencia->ejecutar($agentId);

            return response()->json([
                'status' => 'success',
                'data' => $data, // Datos estructurados listos para el frontend
            ]);
        } catch (Exception $e) {
            Log::error('Error obteniendo asistencia: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'No se pudo cargar la asistencia',
            ], 500);
        }
    }



    // public function index()
    // {
    //     try {
    //         $data = $this->partTimeService->getPartTimeData();
    //         $dateIn = $data->dateIn;
    //         $dateBreakIn = $data->dateBreakIn;
    //         $dateBreakOut = $data->dateBreakOut;
    //         $dateOut = $data->dateOut;
    //         $assistances = $data->assistances;
    //         $rouletteSpin = $data->rouletteSpin;
    //         $areas = $data->areas;
    //         $formattedData = $data->formattedData;
    //         $types = $data->types;
    //         return view('partTime.index', compact('premios1', 'premios2', 'dataUser', 'dateIn', 'dateBreakIn', 'dateBreakOut', 'dateOut', 'assistances', 'rouletteSpin', 'areas', 'formattedData', 'types'));
    //     } catch (Exception $e) {
    //         Log::error("Error en PartTimeController: " . $e->getMessage());
    //         return redirect()->route('home')->with('error', 'No se pudieron cargar los datos de tiempo parcial.');
    //     }
    // }

    // public function registerAssistance(AssistanceRequest $request)
    // {
    //     try {
    //         $data = $this->partTimeService->registerAssistance($request);
    //         $dateIn = $data->dateIn;
    //         $dateBreakIn = $data->dateBreakIn;
    //         $dateBreakOut = $data->dateBreakOut;
    //         $dateOut = $data->dateOut;
    //         return response()->json(["view"=>view('partTime.components.panelButton', compact('dateIn', 'dateBreakIn', 'dateBreakOut', 'dateOut'))->render(), "viewTable"=>view('partTime.components.tabAssistance', compact('assistances', 'formattedData', 'types'))->render(), "title"=>$title, "text"=>$mensaje, "status"=>$status]);
    //     } catch (Exception $e) {
    //         Log::error("Error en PartTimeController: " . $e->getMessage());
    //     }
    // }

    // public function filterAssistance(AssistanceRequest $request)
    // {

    //     $nombre = $request->code;
    //     $area = $request->area;

    //     $user_id = Auth::user()->id;
    //     $agent = Agent::where('user_id', $user_id)->first();

    //     // Convertir fechas al formato interno (YYYY-MM-DD)
    //     $startDate = $this->parseDate($request->dateInit) ?? Carbon::now()->toDateString();
    //     $endDate = $this->parseDate($request->dateEnd) ?? Carbon::now()->toDateString();

    //    // Construcción de la consulta con JOINs para incluir el área del agente
    //     $query = DB::table('assistance as a')
    //                 ->join('agents as ag', 'a.agent_id', '=', 'ag.id')
    //                 ->join('areas as ar', 'ag.area_id', '=', 'ar.id') // Relación con áreas
    //                 ->select(
    //                     'a.date',  // Agregamos la fecha para la agrupación
    //                     'a.agent_id',
    //                     'ag.name as agent_name',
    //                     'ag.lastname as last_name',
    //                     'ar.name as area_name', // Nombre del área del agente
    //                     'a.hour',
    //                     'a.type',
    //                     'a.observation'
    //                 )
    //                 ->whereBetween('a.date', [$startDate, $endDate]) 
    //                 ->orderBy('a.date', 'DESC')  // Ordenamos por fecha
    //                 ->orderBy('a.hour', 'ASC');

    //     // Si se ingresó un nombre de agente, aplicamos el filtro
    //     if (!empty($nombre)) {
    //         $query->where(DB::raw("CONCAT(ag.name, ' ', ag.lastname)"), 'LIKE', "%{$nombre}%");
    //     }

    //     if (!empty($area)) {
    //         $query->where('ag.area_id', $area);
    //     }

    //     // Obtener los resultados
    //     $assistances = $query->get();

    //     // **Nueva estructura** para mostrar correctamente las fechas
    //     $formattedData = [];
    //     $types = ['IN', 'IN-BREAK', 'OUT-BREAK', 'OUT']; // Tipos fijos

    //     foreach ($assistances as $record) {
    //         $date = Carbon::parse($record->date)->format('d/m/Y'); // Formateamos la fecha a DD/MM/YYYY
    //         $agentName = $record->agent_name . " " . $record->last_name;
    //         $area = $record->area_name; // Se añade el área
    
    //         $type = $record->type;
    
    //         $formattedData[$date][$agentName]['area'] = $area; // Se almacena el área en la estructura
    //         $formattedData[$date][$agentName][$type][] = [
    //             'hour' => $record->hour,
    //             'observation' => $record->observation
    //         ];
    //     }

    //     return response()->json(["view"=>view('partTime.components.tabAssistance', compact('assistances', 'formattedData', 'types'))->render()]);
    // }

    // Función para convertir string dd/mm/yyyy a Y-m-d
    // private function parseDate($date)
    // {
    //     try {
    //         return Carbon::createFromFormat('d/m/Y', $date)->format('Y-m-d');
    //     } catch (Exception $e) {
    //         return null;
    //     }
    // }

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
    // public function descargarReportePDF(Request $request) {
    //     try {
    //         $data = $this->partTimeService->filterAssistance($request);
    //         $assistances = $data->assistances;
    //         $formattedData = $data->formattedData;
    //         $types = $data->types;
    //         return response()->json(["view"=>view('partTime.components.tabAssistance', compact('assistances', 'formattedData', 'types'))->render()]);
    //     } catch (Exception $e) {
    //         Log::error("Error en PartTimeController: " . $e->getMessage());
    //     }

    // }

    // public function descargarReportePDF()
    // {
    //     $dateStart = $request->input('date_start');
    //     $dateEnd = $request->input('date_end');
    //     $areaId = $request->input('area');
    //     $code = $request->input('code');

    //     $query = Assistance::with('agent')
    //         ->select('agent_id', 'date', 'hour', 'type', 'observation')
    //         ->join('agents', 'assistance.agent_id', '=', 'agents.id');

    //     if ($dateStart && $dateEnd) {
    //         $start = Carbon::createFromFormat('d/m/Y', $dateStart)->format('Y-m-d');
    //         $end = Carbon::createFromFormat('d/m/Y', $dateEnd)->format('Y-m-d');
    //         $query->whereBetween('assistance.date', [$start, $end]);
    //     }

    //     if ($areaId) {
    //         $query->where('agents.area_id', $areaId);
    //     }

    //     if ($code) {
    //         $query->where(function ($q) use ($code) {
    //             $q->where('agents.name', 'like', '%' . $code . '%')
    //             ->orWhere('agents.lastname', 'like', '%' . $code . '%')
    //             ->orWhere('agents.code_voiso', 'like', '%' . $code . '%');
    //         });
    //     }

    //     $data = $query->orderBy('date')->orderBy('hour')->get();

    //     // Agrupar por fecha + agente
    //     $grouped = $data->groupBy(fn($a) => $a->date . '_' . $a->agent_id);

    //     $assistances = collect();

    //     foreach ($grouped as $group) {
    //         $first = $group->first();
    //         $agent = $first->agent;

    //         $record = [
    //             'date' => $first->date,
    //             'agent' => $agent->name . ' ' . $agent->lastname,
    //             'IN' => '',
    //             'INBREAK' => '',
    //             'OUTBREAK' => '',
    //             'OUT' => '',
    //         ];

    //         foreach ($group as $entry) {
    //             $value = $entry->hour;
    //             if (!empty($entry->observation)) {
    //                 $value .= "<br><small>" . $entry->observation . "</small>";
    //             }

    //             switch ($entry->type) {
    //                 case 'IN': $record['IN'] = $value; break;
    //                 case 'IN-BREAK': $record['INBREAK'] = $value; break;
    //                 case 'OUT-BREAK': $record['OUTBREAK'] = $value; break;
    //                 case 'OUT': $record['OUT'] = $value; break;
    //             }
    //         }

    //         $assistances->push($record);
    //     }

    //     $options = new Options();
    //     $options->set('defaultFont', 'Arial');
    //     $options->set('isHtml5ParserEnabled', true);

    //     $pdf = new Dompdf($options);
    //     $pdf->loadHtml(view('report.assistance_pdf', ['assistances' => $assistances])->render());
    //     $pdf->setPaper('A4', 'landscape');
    //     $pdf->render();

    //     return $pdf->stream('asistencia.pdf');
    // }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function descargarReporteExcel(Request $request)
    // public function descargarReporteExcel()
    // {
    //     try {
    //         return Excel::download(
    //             new AsistenciasExport(
    //                 $request->input('date_start'),
    //                 $request->input('date_end'),
    //                 $request->input('area'),
    //                 $request->input('code')
    //             ),
    //             'asistencias.xlsx'
    //         );
    //     } catch (Throwable $e) {
    //         dd($e->getMessage());
    //         return response($e->getMessage(), 500); // Devuelve el mensaje exacto
    //     }
    // }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function registerVacations(Request $request)
    // public function registerVacations(PartTimeRequest $request)
    // {
    //     try {
    //         $data = $this->partTimeService->registerVacations($request);
    //         $dateIn = $data->dateIn;
    //         $dateBreakIn = $data->dateBreakIn;
    //         $dateBreakOut = $data->dateBreakOut;
    //         $dateOut = $data->dateOut;
    //         return response()->json(["view"=>view('partTime.components.panelButton', compact('dateIn', 'dateBreakIn', 'dateBreakOut', 'dateOut'))->render(), "viewTable"=>view('partTime.components.tabAssistance', compact('assistances', 'formattedData', 'types'))->render(), "title"=>$title, "text"=>$mensaje, "status"=>$status]);
    //     } catch (Exception $e) {
    //         Log::error("Error en PartTimeController: " . $e->getMessage());
    //     }
    // }
}
