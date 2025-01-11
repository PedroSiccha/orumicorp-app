<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\MailDevelop;
use App\Models\Agent;
use App\Models\Customers;
use App\Models\Email;
use App\Services\BrevoService;
use Carbon\Carbon;
use DrewM\MailChimp\MailChimp;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class MailchimpController extends Controller
{
    protected $mailchimp;
    protected $brevoEmailService;

    public function __construct(
        BrevoService $brevoEmailService
    )
    {
        $this->mailchimp = new MailChimp(env('MAILCHIMP_APIKEY'));
        $this->brevoEmailService = $brevoEmailService;
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

    public function sendMailClient(Request $request) {

        $title = 'Error';
        $mensajeResp = 'Error desconocido';
        $status = 'error';

        $mensaje = $request->mensaje;
        $asunto = $request->asunto;

        $emailData = [
            "sender" => [
                "name" => "OrumiCorp",
                "email" => "francisco.siccha.07@gmail.com",
            ],
            "to" => [
                [
                    "email" => $request->email,
                    "name" => $request->name,
                ]
            ],
            "htmlContent" => "<!DOCTYPE html> <html> <body> <h1>$mensaje</h1> </html>",
            "subject" => $asunto,
        ];


        try {
            $response = $this->brevoEmailService->sendTransactionalEmail($emailData);
            $messageId = $response['messageId'];

            if ($messageId) {
                $title = 'Correcto';
                $mensajeResp = 'Mensaje enviado correctamente';
                $status = 'success';
            }
        } catch (Exception $e) {
            $title = 'Error';
            $mensajeResp = 'Ocurrió un error: '.$e->getMessage();
            $status = 'error';
            $messageId = 'Ocurrió un error: '.$e->getMessage();
        }

        $user_id = Auth::user()->id;
        $agent = Agent::where('user_id', $user_id)->first();

        $correo = new Email();
        $correo->customer_id = $request->clienteId;
        $correo->agent_id = $agent->id;
        $correo->subject = $asunto;
        $correo->body = $mensaje;
        $correo->sent_at = Carbon::now();
        $correo->status = "PENDIENTE";
        $correo->responseEmail = $messageId;
        $correo->save();

        return response()->json(["title" => $title, "text" => $mensajeResp, "status" => $status]);
    }

    public function sendMail(Request $request) {

        $title = 'Error';
        $mensajeResp = 'Error desconocido';
        $status = 'error';

        $mensaje = $request->mensaje;
        $asunto = $request->asunto;
        $clienteData = $request->cliente;

        $client = Customers::where('code', $clienteData)->orWhere('id', $clienteData)->first();

        $emailData = [
            "sender" => [
                "name" => "OrumiCorp",
                "email" => "francisco.siccha.07@gmail.com",
            ],
            "to" => [
                [
                    "email" => $client->email,
                    "name" => $client->name,
                ]
            ],
            "htmlContent" => "<!DOCTYPE html> <html> <body> <h1>$mensaje</h1> </html>",
            "subject" => $asunto,
        ];

        try {
            $response = $this->brevoEmailService->sendTransactionalEmail($emailData);
            $messageId = $response['messageId'];

            if ($messageId) {
                $title = 'Correcto';
                $mensajeResp = 'Mensaje enviado correctamente';
                $status = 'success';
            }
        } catch (Exception $e) {
            $title = 'Error';
            $mensajeResp = 'Ocurrió un error: '.$e->getMessage();
            $status = 'error';
            $messageId = 'Ocurrió un error: '.$e->getMessage();
        }

        $user_id = Auth::user()->id;
        $agent = Agent::where('user_id', $user_id)->first();

        $correo = new Email();
        $correo->customer_id = $client->id;
        $correo->agent_id = $agent->id;
        $correo->subject = $asunto;
        $correo->body = $mensaje;
        $correo->sent_at = Carbon::now();
        $correo->status = "PENDIENTE";
        $correo->responseEmail = $messageId;
        $correo->save();

        return response()->json(["title" => $title, "text" => $mensajeResp, "status" => $status]);
    }

    public function verEnviados() {
        $user_id = Auth::user()->id;
        $agent = Agent::where('user_id', $user_id)->first();
        $emails = Email::where('agent_id', $agent->id)->with(['customer', 'agent'])->get();
        return response()->json(["view"=>view('mail.components.detailMail', compact('emails'))->render()]);
    }

}
