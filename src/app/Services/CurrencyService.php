<?php

namespace App\Services;

use App\Models\Transaction;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CurrencyService
{
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = ENV('CURRENCY_API_KEY');
    }

    public function convert($value, $from = 'USD', $to = 'BRL')
    {
        $client = new \GuzzleHttp\Client();
    
        $response = $client->request('GET', "https://api.fastforex.io/fetch-one?from={$from}&to={$to}&api_key={$this->apiKey}", [
        'headers' => [
            'Accept' => 'application/json',
        ],
        ]);

        return json_decode((string) $response->getBody());

    }
}