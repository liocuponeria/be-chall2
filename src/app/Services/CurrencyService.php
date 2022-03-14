<?php

namespace App\Services;
use Illuminate\Support\Facades\Http;

class CurrencyService
{
    protected $endpoint;
    protected $apiKey = '54e765d732-3d195a2b2c-r8j7hm';

    public function __construct()
    {
        $this->endpoint = 'https://api.fastforex.io/';
    }

    public function getBRL()
    {
        $this->endpoint .= "fetch-one?api_key={$this->apiKey}&rom=USD&to=BRL";
        $data = Http::get($this->endpoint);
        $result = json_decode($data->body());

        return $result->result->BRL;
    }
}