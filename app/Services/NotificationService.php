<?php

namespace App\Services;
use GuzzleHttp\Client;

class NotificationService{
    private $config;
    public function __construct($config)
    {
        $this->config = $config;
        $this->client = new Client($config);
    }
    public function sendNotice(): bool
    {
        $response = $this->client->request('GET','');
        if($response->getStatusCode() === 200)
        {
            $body = json_decode($response->getBody());
            if($body->message === 'Autorizado')
            {
                return true;
            }
        }
        return false;
    }
}
