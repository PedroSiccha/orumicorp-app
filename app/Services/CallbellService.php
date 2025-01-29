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
        $this->baseUrl = env('CALLBELL_API_BASE_URL'); // URL base de la API
        $this->token = env('CALLBELL_API_TOKEN'); // Token desde .env

        if (!$this->baseUrl || !$this->token) {
            throw new \Exception('Callbell API URL o Token no configurados.');
        }

    }

    /**
     * Envía un mensaje utilizando la API de Callbell.
     *
     * @param string $phone Número de teléfono del destinatario.
     * @param string $message Mensaje a enviar.
     * @return array Respuesta del envío y estado del mensaje.
     */

     public function sendMessage($phone, $message)
    {
        // Verificar que el número de teléfono no esté vacío
        if (empty($phone)) {
            throw new \Exception('El número de teléfono no puede estar vacío.');
        }

        // UUID de la plantilla aprobada "bienvenida"
        // $templateUuid = 'c37c5ceb4a664830a99f56911c004138';
        $templateUuid = '2282d2898c724150b641746127216c24';
        $channelUuid = '4e6124ac175f48bf9e10236111718167';
        // $templateValues = [$phone, $message];
        $templateValues = [$message];

        try {
            $response = $this->client->post("{$this->baseUrl}/messages/send", [
                'headers' => [
                    'Authorization' => "Bearer {$this->token}",
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'from' => 'whatsapp', // Asegurar que sea exactamente "whatsapp"
                    'to' => $phone, // Número en formato internacional
                    'type' => 'text',
                    'template_uuid' => $templateUuid, // UUID de la plantilla aprobada
                    'optin_contact' => true, // Confirmar que el usuario ha dado su consentimiento
                    'template_values' => $templateValues,
                    'content' => [
                        'text' => 'Hi' // ✅ Definido correctamente como array
                    ],
                    'channel_uuid' => $channelUuid,
                ],
            ]);

            $responseData = json_decode($response->getBody(), true);
            $uuid = $responseData['message']['uuid'] ?? null;

            if (!$uuid) {
                return [
                    'error' => true,
                    'message' => 'No se pudo obtener el UUID del mensaje enviado.',
                ];
            }

            // Consultar el estado del mensaje
            $status = $this->getMessageStatus($uuid);

            return [
                'message' => $responseData,
                'status' => $status,
            ];

        } catch (RequestException $e) {
            return $this->handleException($e);
        }
    }


     /**
     * Consulta el estado de un mensaje enviado.
     *
     * @param string $uuid UUID del mensaje.
     * @return array Estado del mensaje.
     */

     public function getMessageStatus($uuid)
     {
         try {
             $response = $this->client->get("{$this->baseUrl}/messages/status/{$uuid}", [
                 'headers' => [
                     'Authorization' => "Bearer {$this->token}",
                 ],
             ]);

             return json_decode($response->getBody(), true);

         } catch (RequestException $e) {
             return $this->handleException($e);
         }
     }

     /**
     * Envía un mensaje y espera hasta que se confirme su entrega.
     *
     * @param string $phone Número de teléfono del destinatario.
     * @param string $message Mensaje a enviar.
     * @return array UUID y estado final del mensaje.
     * @throws \Exception Si el mensaje falla o el estado no progresa.
     */


     public function sendMessageAndWaitForDelivery($phone, $message)
     {
         $response = $this->sendMessage($phone, $message);
         $uuid = $response['message']['uuid'] ?? null;

         if (!$uuid) {
             throw new \Exception('No se pudo obtener el UUID del mensaje.');
         }

         // Esperar hasta que el estado sea "delivered"
         $status = 'enqueued';
         while ($status !== 'delivered') {
             sleep(5); // Espera 5 segundos antes de consultar el estado nuevamente
             $statusResponse = $this->getMessageStatus($uuid);
             $status = $statusResponse['message']['status'] ?? 'unknown';

             if ($status === 'failed' || $status === 'unknown') {
                 throw new \Exception('Error en la entrega del mensaje.');
             }
         }

         return [
             'uuid' => $uuid,
             'status' => $status,
         ];
     }

     /**
     * Maneja excepciones de la API.
     *
     * @param RequestException $e Excepción de la solicitud.
     * @return array Mensaje de error procesado.
     */

     private function handleException(RequestException $e)
     {
         return [
             'error' => true,
             'message' => $e->getResponse()
                 ? $e->getResponse()->getBody()->getContents()
                 : $e->getMessage(),
         ];
     }

     // Método para hacer la consulta al API de Callbell usando el número de teléfono
    public function buscarContactoPorTelefono($phone)
    {
        $apiUrl = "{$this->baseUrl}/contacts/phone/{$phone}";

        // Cuerpo con el channel_uuid
        $body = [
            'channel_uuid' => '4e6124ac175f48bf9e10236111718167'
        ];

        // Hacemos la solicitud GET a la API de Callbell
        $response = Http::withHeaders([
            'Authorization' => "Bearer {$this->token}",
            'Content-Type' => 'application/json',
        ])->withBody(json_encode($body), 'application/json')->get($apiUrl);

        // Verificamos si la respuesta fue exitosa
        if ($response->successful()) {
            // Si la respuesta contiene un contacto, retornamos los datos del contacto
            return $response->json();
        }

        // Si la respuesta no fue exitosa, lanzamos un error
        throw new \Exception('No se pudo obtener el contacto.');
    }

}
