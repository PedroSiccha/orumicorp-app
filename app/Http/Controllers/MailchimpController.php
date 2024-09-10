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
        $body = $request->input('body', 'Este es un correo de prueba');

        $campaign = $this->mailchimp->post('campaigns', [
            'type' => 'regular',
            'recipients' => [
                'list_id' => env('MAILCHIMP_LIST_ID'), // ID de tu audiencia
            ],
            'settings' => [
                'subject_line' => $subject,
                'title' => 'Mi Campaña',
                'from_name' => 'Tu Nombre',
                'reply_to' => 'tu_email@example.com',
            ],
        ]);

        if (!$campaign || isset($campaign['status']) && $campaign['status'] != 'sent') {
            return response()->json(['error' => 'Error al crear la campaña'], 500);
        }

        $content = $this->mailchimp->put("campaigns/{$campaign['id']}/content", [
            'html' => "<html><body><p>$body</p></body></html>",
        ]);

        $sendCampaign = $this->mailchimp->post("campaigns/{$campaign['id']}/actions/send");

        if (!$sendCampaign || isset($sendCampaign['status']) && $sendCampaign['status'] != 'sent') {
            return response()->json(['error' => 'Error al enviar el correo'], 500);
        }

        return response()->json(['success' => 'Correo enviado exitosamente']);
    }

}
