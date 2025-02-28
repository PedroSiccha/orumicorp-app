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

class PartTimeController extends Controller
{

    protected $partTimeService;

    public function __construct(PartTimeService $partTimeService) {
        $this->partTimeService = $partTimeService;
    }

    public function index()
    {
        try {
            $data = $this->partTimeService->getPartTimeData();
            $dateIn = $data->dateIn;
            $dateBreakIn = $data->dateBreakIn;
            $dateBreakOut = $data->dateBreakOut;
            $dateOut = $data->dateOut;
            $assistances = $data->assistances;
            $rouletteSpin = $data->rouletteSpin;
            $areas = $data->areas;
            $formattedData = $data->formattedData;
            $types = $data->types;
            return view('partTime.index', compact('premios1', 'premios2', 'dataUser', 'dateIn', 'dateBreakIn', 'dateBreakOut', 'dateOut', 'assistances', 'rouletteSpin', 'areas', 'formattedData', 'types'));
        } catch (Exception $e) {
            Log::error("Error en PartTimeController: " . $e->getMessage());
            return redirect()->route('home')->with('error', 'No se pudieron cargar los datos de tiempo parcial.');
        }
    }

    public function registerAssistance(AssistanceRequest $request)
    {
        try {
            $data = $this->partTimeService->registerAssistance($request);
            $dateIn = $data->dateIn;
            $dateBreakIn = $data->dateBreakIn;
            $dateBreakOut = $data->dateBreakOut;
            $dateOut = $data->dateOut;
            return response()->json(["view"=>view('partTime.components.panelButton', compact('dateIn', 'dateBreakIn', 'dateBreakOut', 'dateOut'))->render(), "viewTable"=>view('partTime.components.tabAssistance', compact('assistances', 'formattedData', 'types'))->render(), "title"=>$title, "text"=>$mensaje, "status"=>$status]);
        } catch (Exception $e) {
            Log::error("Error en PartTimeController: " . $e->getMessage());
        }
    }

    public function filterAssistance(AssistanceRequest $request)
    {
        try {
            $data = $this->partTimeService->filterAssistance($request);
            $assistances = $data->assistances;
            $formattedData = $data->formattedData;
            $types = $data->types;
            return response()->json(["view"=>view('partTime.components.tabAssistance', compact('assistances', 'formattedData', 'types'))->render()]);
        } catch (Exception $e) {
            Log::error("Error en PartTimeController: " . $e->getMessage());
        }

    }

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

    public function descargarReporteExcel()
    {
        return Excel::download(new AsistenciasExport, 'asistencias.xlsx');
    }

    public function registerVacations(PartTimeRequest $request)
    {
        try {
            $data = $this->partTimeService->registerVacations($request);
            $dateIn = $data->dateIn;
            $dateBreakIn = $data->dateBreakIn;
            $dateBreakOut = $data->dateBreakOut;
            $dateOut = $data->dateOut;
            return response()->json(["view"=>view('partTime.components.panelButton', compact('dateIn', 'dateBreakIn', 'dateBreakOut', 'dateOut'))->render(), "viewTable"=>view('partTime.components.tabAssistance', compact('assistances', 'formattedData', 'types'))->render(), "title"=>$title, "text"=>$mensaje, "status"=>$status]);
        } catch (Exception $e) {
            Log::error("Error en PartTimeController: " . $e->getMessage());
        }
    }
}
