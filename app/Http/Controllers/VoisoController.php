<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
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
        $response = Http::post('https://{cluster_id}.voiso.com/api/v1/{contact_center_api_key}/click2call', [
            'agent' => 347,
            'number' => '16461572020',
            'account_id' => 12345678,
            'crm' => 'my_crm',
        ]);

        if ($response->successful()) {
            // La solicitud fue exitosa, puedes acceder a los datos de la respuesta si es necesario
            $responseData = $response->json();
            // Realiza las operaciones necesarias con $responseData
            return response()->json($responseData);
        } else {
            // La solicitud falló
            $errorCode = $response->status();
            $errorMessage = $response->body();
            // Maneja el error según sea necesario
            return response()->json(['error' => $errorMessage], $errorCode);
        }
    }
}
