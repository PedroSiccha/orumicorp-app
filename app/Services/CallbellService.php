<?php
namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Http;

class CallbellService
{
    protected $baseUrl;
    protected $token;

    protected $client;

    public function __construct()
    {
        $this->client = new Client();
        $this->baseUrl = 'https://api.callbell.eu/v1'; // URL base de la API
        $this->token = env('CALLBELL_API_TOKEN'); // Token desde .env

        // $this->baseUrl = config('services.callbell.url');
        // $this->token = config('services.callbell.token');
    }

    public function sendMessage($phone, $message)
    {
        $templateName = 'bienvenida';
        $templateVariables = ['María', $message];
        $templateUuid = '6a8c731f534e4b898d3b97356cafa732';

        try {
            $response = $this->client->post("{$this->baseUrl}/messages/send", [
                'headers' => [
                    'Authorization' => "Bearer {$this->token}",
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'from' => 'whatsapp', // Canal desde el que envías el mensaje
                    'to' => $phone, // Número del destinatario (incluye el código de país)
                    'type' => 'text', // Tipo de mensaje
                    'content' => [
                        'text' => $message, // Contenido del mensaje
                        'url' => $mediaUrl ?? null, // URL del archivo multimedia (si aplica, opcional)
                    ],
                    'template_uuid' => $templateUuid, // UUID de la plantilla aprobada
                    'optin_contact' => true, // Confirmar si el destinatario ha optado por recibir mensajes
                ],
            ]);

            // Decodificar la respuesta para obtener el UUID
            $responseData = json_decode($response->getBody(), true);
            $uuid = $responseData['message']['uuid'] ?? null;

            if (!$uuid) {
                return [
                    'error' => true,
                    'message' => 'No se pudo obtener el UUID del mensaje enviado.',
                ];
            }

            // Consultar el estado del mensaje
            $status = $this->getMessageNewStatus($uuid);

            return [
                'message' => $responseData,
                'status' => $status,
            ];

        } catch (RequestException $e) {
            return [
                'error' => true,
                'message' => $e->getResponse() ? $e->getResponse()->getBody()->getContents() : $e->getMessage(),
            ];
        }

    }

    public function getMessageNewStatus($uuid)
    {
        try {
            $response = $this->client->get("{$this->baseUrl}/messages/{$uuid}", [
                'headers' => [
                    'Authorization' => "Bearer {$this->token}",
                ],
            ]);

            return json_decode($response->getBody(), true);

        } catch (RequestException $e) {
            return [
                'error' => true,
                'message' => $e->getResponse() ? $e->getResponse()->getBody()->getContents() : $e->getMessage(),
            ];
        }
    }


    public function handleIncomingMessages($data)
    {
        // Procesar respuestas según los datos recibidos
        // Ejemplo: guardar el mensaje en la base de datos
        return $data;
    }

    public function sendMessageAndWaitForDelivery($phone, $message)
    {
        // Paso 1: Enviar el mensaje
        $response = $this->sendMessage($phone, $message);

        // Verificar que el mensaje se haya enviado correctamente
        $uuid = $response['message']['uuid'] ?? null;
        if (!$uuid) {
            throw new \Exception('No se pudo obtener el UUID del mensaje.');
        }

        // Paso 2: Consultar el estado hasta obtener "delivered"
        $status = 'enqueued';
        while ($status !== 'delivered') {
            sleep(5); // Esperar 5 segundos antes de volver a consultar
            $statusResponse = $this->getMessageStatus($uuid);
            $status = $statusResponse['message']['status'] ?? 'unknown';

            // \Log::info("Estado del mensaje: {$status}", ['uuid' => $uuid]);

            // Opcional: Si el estado no progresa en un tiempo razonable, lanzar excepción
            if ($status === 'failed' || $status === 'unknown') {
                throw new \Exception('Error en la entrega del mensaje.');
            }
        }

        return [
            'uuid' => $uuid,
            'status' => $status,
        ];
    }

    public function getMessageStatus($uuid)
    {
        if (!$this->baseUrl || !$this->token) {
            throw new \Exception('Callbell API URL o Token no configurados.');
        }

        $url = "{$this->baseUrl}/status/{$uuid}";

        $response = Http::withToken($this->token)
            ->get($url);

        if ($response->failed()) {
            // \Log::error('Error al obtener estado del mensaje', [
            //     'status' => $response->status(),
            //     'body' => $response->body(),
            //     'uuid' => $uuid,
            // ]);
            throw new \Exception('Error al obtener el estado del mensaje en la API de Callbell.');
        }

        return $response->json();
    }


}
