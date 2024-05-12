<?php

namespace App\Services;

use GuzzleHttp\Client;

class VoisoService
{
    protected $httpClient;
    protected $apiKey;

    public function __construct()
    {
        $this->httpClient = new Client([
            'base_uri' => 'https://api.voiso.com/',
            'headers' => [
                'Authorization' => 'Bearer ' . config('voiso.api_key'),
                'Accept' => 'application/json',
            ],
        ]);

        $this->apiKey = config('voiso.api_key');
    }

    public function makeCall($phoneNumber, $message)
    {
        $response = $this->httpClient->post('calls', [
            'json' => [
                'to' => $phoneNumber,
                'message' => $message,
            ],
        ]);

        return json_decode($response->getBody(), true);
    }
}
