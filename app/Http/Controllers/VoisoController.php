<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class VoisoController extends Controller
{
    public function clickToCall(Request $request)
    {
        $client = new Client();

        try {
            $response = $client->post('https://developers.voiso.com/api/v1/2a517cb66609906663cf7e5bd337ff168286eeacb0364d1d/click2call', [
                'json' => [
                    'agent' => '347',
                    'number' => '16461572020',
                    'account_id' => '12345678',
                    'crm' => 'my_crm'
                ]
            ]);

            $statusCode = $response->getStatusCode();
            $content = $response->getBody()->getContents();

            return response()->json(['status' => 'success', 'data' => $content]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function initiateCall(Request $request)
    {
        $user_id = Auth::user()->id;
        $codeVoiso = Agent::where('user_id', $user_id)->first();
        //dd($codeVoiso->code);
        $data = [
            'agent' => $codeVoiso->code,
            'number' => $request->phone,
        ];
        $response = Http::post('https://cc-dal01.voiso.com/api/v1/2a517cb66609906663cf7e5bd337ff168286eeacb0364d1d/click2call', $data);
        if ($response->successful()) {
            return response()->json(["errorMessage"=>$response->json(), "errorStatus"=>"", "status"=>$response->status()]);
        } else {
            $errorResponse = json_decode($response->body(), true);
            $errorMessage = $errorResponse['error'] ?? 'Error desconocido';
            $errorStatus = $errorResponse['status'] ?? 'Error de estado';
            return response()->json(["errorMessage"=>$errorMessage, "errorStatus"=>$errorStatus, "status"=>$response->status()]);
        }
    }
}
