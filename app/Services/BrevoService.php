<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class BrevoService
{
    protected $apiUrl = 'https://api.brevo.com/v3/smtp/email';

    public function sendTransactionalEmail($emailData)
    {
        $response = Http::withHeaders([
            'api-key' => env('BREVO_API_KEY'),
            'Content-Type' => 'application/json',
        ])->post($this->apiUrl, $emailData);

        return $response->json();
    }
}
