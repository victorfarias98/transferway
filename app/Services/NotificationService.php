<?php

namespace App\Services;
use GuzzleHttp\Client;

class NotificationService{

    const base_uri = "http://o4d9z.mocklab.io";

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => self::base_uri,
            'timeout'  => 2.0,
        ]);
    }
    public function sendNotice(): bool
    {
        $response = $this->client->request('GET','/notify');
        if($response->getStatusCode() !== Response::HTTP_OK){
            return false;
        }
        $body = json_decode($response->getBody());
        return $body->message === 'Autorizado';
    }
}