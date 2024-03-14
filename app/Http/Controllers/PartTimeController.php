<?php

namespace App\Http\Controllers;

use App\Exports\AsistenciasExport;
use App\Models\Agent;
use App\Models\Area;
use App\Models\Assistance;
use App\Models\Customers;
use App\Models\Premio;
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

        return view('partTime.index', compact('premios1', 'premios2', 'dataUser', 'dateIn', 'dateBreakIn', 'dateBreakOut', 'dateOut', 'assistances', 'rouletteSpin', 'areas'));
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


        return response()->json(["view"=>view('partTime.components.panelButton', compact('dateIn', 'dateBreakIn', 'dateBreakOut', 'dateOut'))->render(), "viewTable"=>view('partTime.components.tabAssistance', compact('assistances'))->render(), "title"=>$title, "text"=>$mensaje, "status"=>$status]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function filterAssistance(Request $request)
    {

        $codigo = $request->code;
        $nombre = $request->code;

        $user_id = Auth::user()->id;
        $agent = Agent::where('user_id', $user_id)->first();
        $dateInit = DateTime::createFromFormat('m/d/Y', $request->dateInit)->format('Y-m-d');
        $dateEnd = DateTime::createFromFormat('m/d/Y', $request->dateEnd)->format('Y-m-d');
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
        ->where(function ($query) use ($codigo, $nombre) {
            $query->where('agents.code', 'LIKE', '%' . $codigo . '%')
                ->orWhere(DB::raw("CONCAT(agents.name, ' ', agents.lastname)"), 'LIKE', '%' . $nombre . '%');
        })
        ->where('agents.area_id', $request->area)
        ->whereBetween('assistance.date', [$dateInit, $dateEnd])
        ->groupBy('agents.name', 'agents.lastname', 'assistance.date')
        ->get();
        return response()->json(["view"=>view('partTime.components.tabAssistance', compact('assistances'))->render()]);
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
    public function update(Request $request, $id)
    {
        //
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
