<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use DrewM\MailChimp\MailChimp;
use Illuminate\Http\Request;

class MailchimpController extends Controller
{
    protected $mailchimp;

    public function __construct()
    {
        $this->mailchimp = new MailChimp(env('MAILCHIMP_APIKEY'));
    }

    public function crearYEnviarCorreo(Request $request)
    {
        // Captura los datos del request
        $email = $request->input('email');
        $subject = $request->input('subject', 'Correo de Prueba'); // Asunto del correo
        $body = $request->input('body', 'Este es el cuerpo del correo.'); // Cuerpo del correo

        // Convertir el correo en un hash MD5 como lo requiere la API de Mailchimp
        $subscriberHash = md5(strtolower($email));

        // Paso 1: Verificar si el suscriptor ya existe en la lista
        $subscriber = $this->mailchimp->get("lists/" . env('MAILCHIMP_LIST_ID') . "/members/{$subscriberHash}");

        if (isset($subscriber['status']) && $subscriber['status'] == 'subscribed') {
            // El suscriptor ya está en la lista
            return response()->json(['message' => 'El correo ya está suscrito a la lista.']);
        }

        // Si el suscriptor no existe, se agrega a la lista
        if (isset($subscriber['status']) && $subscriber['status'] == 404) {
            // Paso 2: Agregar el destinatario a la lista
            $addSubscriber = $this->mailchimp->post("lists/" . env('MAILCHIMP_LIST_ID') . "/members", [
                'email_address' => $email,
                'status' => 'subscribed',  // También puedes usar 'pending' para doble opt-in
            ]);

            // Verificar si hubo un error al agregar el suscriptor
            if (!isset($addSubscriber['id'])) {
                return response()->json(['error' => 'Error al agregar el suscriptor a la lista.'], 500);
            }
        }

        // Paso 1: Crear la campaña en Mailchimp
        $campaign = $this->mailchimp->post('campaigns', [
            'type' => 'regular',
            'recipients' => [
                'list_id' => env('MAILCHIMP_LIST_ID'),  // ID de la lista de Mailchimp
            ],
            'settings' => [
                'subject_line' => $subject,  // Asunto del correo
                'title' => 'Mi Campaña',  // Título interno de la campaña
                'from_name' => 'Tu Nombre o Empresa',  // Nombre de quien envía el correo
                'reply_to' => 'tu_email@example.com',  // Dirección de correo de respuesta
            ],
        ]);

        // dd($campaign);

        // Verifica si la campaña se creó correctamente
        if (!isset($campaign['id'])) {
            return response()->json(['error' => 'Error al crear la campaña en Mailchimp.'], 500);
        }

        // Paso 2: Configurar el contenido de la campaña
        $content = $this->mailchimp->put("campaigns/{$campaign['id']}/content", [
            'html' => "<html><body><p>$body</p></body></html>",  // Cuerpo HTML del correo
        ]);

        // Verifica si el contenido fue configurado correctamente
        if (!isset($content['plain_text'])) {
            return response()->json(['error' => 'Error al configurar el contenido del correo.'], 500);
        }

        // Paso 3: Enviar la campaña
        $sendCampaign = $this->mailchimp->post("campaigns/{$campaign['id']}/actions/send");

        // Verifica si el correo fue enviado correctamente
        if (isset($sendCampaign['status']) && $sendCampaign['status'] == 'sent') {
            return response()->json(['success' => 'Correo enviado exitosamente.']);
        } else {
            return response()->json(['error' => 'Error al enviar el correo.'], 500);
        }

        // return response()->json(['success' => 'Correo enviado exitosamente']);
    }

}
