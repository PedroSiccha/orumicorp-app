<?php

namespace App\Services;

use Sendinblue\Client\Configuration;
use Sendinblue\Client\Api\TransactionalEmailsApi;
use Sendinblue\Client\Model\SendSmtpEmail;
use Exception;

class BrevoService
{
    protected $emailApi;

    public function __construct()
    {
        $config = Configuration::getDefaultConfiguration()->setApiKey('api-key', env('BREVO_API_KEY'));
        $this->emailApi = new TransactionalEmailsApi(null, $config);
    }

    public function sendEmail($toEmail, $toName, $subject, $htmlContent)
    {
        $email = new SendSmtpEmail([
            'sender' => [
                'name' => env('MAIL_FROM_NAME'),
                'email' => env('MAIL_FROM_ADDRESS'),
            ],
            'to' => [
                [
                    'email' => $toEmail,
                    'name' => $toName,
                ],
            ],
            'subject' => $subject,
            'htmlContent' => $htmlContent,
        ]);

        try {
            $response = $this->emailApi->sendTransacEmail($email);
            return $response;
        } catch (Exception $e) {
            throw new Exception('Error sending email: ' . $e->getMessage());
        }
    }
}
