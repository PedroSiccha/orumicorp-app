<?php

namespace App\Http\Controllers;

use App\Models\Views;
use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Services\ViewsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Log;
use Svg\Tag\Rect;

class ViewsController extends Controller
{

    protected $viewsService;

    public function __construct(ViewsService $viewsService) {
        $this->viewsService = $viewsService;
    }

    public function saveViews(Request $request)
    {
        try {
            $data = $this->viewsService->saveViews($request);
            $views = $data->views;
            return response()->json(["view"=>view('views.table.tableViews', compact('views'))->render(), "resp"=>$resp]);
        } catch (Exception $e) {
            Log::error("Error en ViewsController: " . $e->getMessage());
        }
    }

    public function getViews(Request $request)
    {
        try {
            $data = $this->viewsService->getViews($request);
            $views = $data->views;
            return response()->json(["view"=>view('views.table.tableViews', compact('views'))->render(), "resp"=>$resp]);
        } catch (Exception $e) {
            Log::error("Error en ViewsController: " . $e->getMessage());
        }
    }

}
