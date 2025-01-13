<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MessageWhatsappModel;
use App\Services\CallbellService;
use Illuminate\Http\Request;

class CallbellController extends Controller
{
    protected $callbellService;

    public function __construct(CallbellService $callbellService)
    {
        $this->callbellService = $callbellService;
    }

    public function sendMessage(Request $request)
    {
        $validated = $request->validate([
            'phone' => 'required',
            'message' => 'required',
        ]);

        // dd($request->phone);

        // try {
        //     $service = new CallbellService(); // Instancia del servicio
        //     $deliveryStatus = $service->sendMessageAndWaitForDelivery($request->phone, $request->message);

        //     return response()->json([
        //         'success' => true,
        //         'status' => $deliveryStatus,
        //     ]);
        // } catch (\Exception $e) {
        //     return response()->json([
        //         'success' => false,
        //         'error' => $e->getMessage(),
        //     ], 500);
        // }

        $response = $this->callbellService->sendMessage($validated['phone'], $validated['message']/*$request->phone, $request->message*/);

        MessageWhatsappModel::create([
            'phone' => $request->phone,
            'message' => $request->message,
            'status' => $response['message']['status'] ?? 'unknown',
            'agent_id' => 1,
            'customer_id' => 1
        ]);

        return response()->json($response);
    }

    public function viewHistory()
    {
        $messages = MessageWhatsappModel::all();
        return view('callbell.history', compact('messages'));
    }
}
