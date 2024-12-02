<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;

class CallbellService
{
    protected $baseUrl;
    protected $token;

    public function __construct()
    {
        $this->baseUrl = config('services.callbell.url');
        $this->token = config('services.callbell.token');
    }

    public function sendMessage($phone, $message)
    {
        // dd("BASE URL: ".$this->baseUrl. "\n TOKEN".$this->token);
        if (!$this->baseUrl || !$this->token) {
            throw new \Exception('Callbell API URL o Token no configurados.');
        }

        $url = "{$this->baseUrl}/send";

        $response = Http::withToken($this->token)
                    ->post($url, [
                        'to' => $phone,
                        'from' => 'whatsapp', // Cambia 'whatsapp' si usas otro canal
                        'type' => 'text',
                        'content' => [
                            'text' => $message,
                        ],
        ]);

            if ($response->failed()) {
                \Log::error('Error al enviar mensaje a Callbell', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                    'data_sent' => [
                        'phone' => $phone,
                        'text' => $message,
                    ],
                ]);
                throw new \Exception('Error al enviar el mensaje a la API de Callbell. Verifica los logs para más detalles.');
            }

        return $response->json();
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

            \Log::info("Estado del mensaje: {$status}", ['uuid' => $uuid]);

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
            \Log::error('Error al obtener estado del mensaje', [
                'status' => $response->status(),
                'body' => $response->body(),
                'uuid' => $uuid,
            ]);
            throw new \Exception('Error al obtener el estado del mensaje en la API de Callbell.');
        }

        return $response->json();
    }


}
