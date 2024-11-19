<?php

namespace App\Repositories;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

class FatoorahRepository
{
    private $requestClient;
    private $baseURL;
    private $headers;

    function __construct(Client $requestClient)
    {

        $this->requestClient = $requestClient;

        $this->baseURL = env('FATOORAH_BASE_URL');

        $this->headers = [
            'Content-Type' => 'Application/json',
            'authorization' => 'Bearer ' . env('FATOORAH_TOKEN')
        ];
    }

    function buildRequest($url, $method, $body = [])
    {
        $request = new Request($method, $this->baseURL . $url, $this->headers);

        if (!$body) {
            return false;
        }

        $response = $this->requestClient->send($request, [
            'json' => $body
        ]);

        if ($response->getStatusCode() != 200) {
            return false;
        }

        $response = json_decode($response->getBody(), true);

        return $response;
    }

    function sendPayment($data)
    {
        $response = $this->buildRequest('v2/SendPayment', 'POST', $data);

        return $response;


    }

    function GetPaymentStatus($data)
    {
        $response = $this->buildRequest('v2/getPaymentStatus', 'POST', $data);

        return $response;
    }
}
