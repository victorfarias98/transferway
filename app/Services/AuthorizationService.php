<?php

namespace App\Services;
use Illuminate\Http\Response;
use GuzzleHttp\Client;

class AuthorizationService
{
    const base_uri = 'http://run.mocky.io/v3/';

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => self::base_uri,
            'timeout'  => 5,
        ]);
    }

    public function authorizeTransaction() : bool
    {
        $response = $this->client->request('GET','8fafdd68-a090-496f-8c9a-3442cf30dae6');
        if($response->getStatusCode() !== Response::HTTP_OK)
        {
            return false;
        }
        $body = json_decode($response->getBody());
        return $body->message === 'Autorizado';
    }
}