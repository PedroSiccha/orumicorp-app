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
        $email = $request->input('email');
        $subject = $request->input('subject', 'Correo de Prueba');
        $body = $request->input('body', 'Este es el cuerpo del correo.');

        $subscriberHash = md5(strtolower($email));

        $subscriber = $this->mailchimp->get("lists/" . env('MAILCHIMP_LIST_ID') . "/members/{$subscriberHash}");

        if (isset($subscriber['status']) && $subscriber['status'] == 'subscribed') {
            return response()->json(['message' => 'El correo ya está suscrito a la lista.']);
        }

        if (isset($subscriber['status']) && $subscriber['status'] == 404) {
            $addSubscriber = $this->mailchimp->post("lists/" . env('MAILCHIMP_LIST_ID') . "/members", [
                'email_address' => $email,
                'status' => 'subscribed',
            ]);

            if (!isset($addSubscriber['id'])) {
                return response()->json(['error' => 'Error al agregar el suscriptor a la lista.'], 500);
            }
        }

        $campaign = $this->mailchimp->post('pedro', [
            'type' => 'regular',
            'recipients' => [
                'list_id' => env('MAILCHIMP_LIST_ID'),
            ],
            'settings' => [
                'subject_line' => $subject,
                'title' => 'Mi Campaña',
                'from_name' => 'Tu Nombre o Empresa',
                'reply_to' => 'tu_email@example.com',
            ],
        ]);

        if (!isset($campaign['id'])) {
            return response()->json(['error' => 'Error al crear la campaña en Mailchimp.'], 500);
        }

        $content = $this->mailchimp->put("campaigns/{$campaign['id']}/content", [
            'html' => "<html><body><p>$body</p></body></html>",
        ]);

        if (!isset($content['plain_text'])) {
            return response()->json(['error' => 'Error al configurar el contenido del correo.'], 500);
        }

        $sendCampaign = $this->mailchimp->post("campaigns/{$campaign['id']}/actions/send");

        if (isset($sendCampaign['status']) && $sendCampaign['status'] == 'sent') {
            return response()->json(['success' => 'Correo enviado exitosamente.']);
        } else {
            return response()->json(['error' => 'Error al enviar el correo.'], 500);
        }

    }

}
