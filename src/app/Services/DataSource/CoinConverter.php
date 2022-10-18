<?php
namespace App\Services\DataSource;

use Illuminate\Support\Facades\Http;

class CoinConverter implements CoinConverterSourceInterface
{

    private $url = "https://api.fastforex.io";
    private $exchangeRates = [];

    public function __construct()
    {

    }
    

    private function get(string $endpoint, array $params)
    {
        $uri = $this->url . $endpoint;

        $requestParams = array_merge([
            'api_key' => env('FAST_FOREX_API_KEY'),
        ], $params);

        $apiResponse = json_decode(Http::get($uri, $requestParams)->getBody()->getContents(), true);

        if (isset($apiResponse['error'])) {
            throw new \Exception('Fast Forex Error: ' . $apiResponse['error'], 1);   
        }
        
        return $apiResponse;
    }

    public function convert(float $amount, string $from, string $to) : float
    {
        
        $rate = $this->getExchangeRate($from, $to);

        $brlAmount = (float) ($amount * $rate);
        $brlAmount = (float) number_format($brlAmount, 2, '.', '');
        
        return $brlAmount;
    }

    private function getExchangeRate($from, $to)
    {
        if (isset($this->exchangeRates[$from][$to])) {
            return $this->exchangeRates[$from][$to];
        }

        $converter = $this->get('/fetch-one', [
            'from' => $from,
            'to' => $to
        ]);

        $rate = (float) $converter['result']['BRL'];
        $this->exchangeRates[$from][$to] = $rate;
        
        return $rate;
    }
}