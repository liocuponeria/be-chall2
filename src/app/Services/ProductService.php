<?php

namespace App\Services;
use Illuminate\Support\Facades\Http;
use App\Services\CurrencyService;

class ProductService
{
    protected $endpoint;

    public function __construct()
    {
        $this->endpoint = 'http://makeup-api.herokuapp.com/api/v1/products.json';
    }

    public function search($type, $category)
    {
        $this->endpoint = "{$this->endpoint}?product_type={$type}&product_category={$category}";
        $data = Http::get($this->endpoint);
        $result = json_decode($data->body());

        $currency = new CurrencyService();
        $brl = $currency->getBRL();

        $result = array_map(function($r) use ($brl){
            return [
                'name' => $r->name,
                'price_usd' => $r->price,
                'price_brl' => number_format(($r->price * $brl), 2, '.', ''),
                'description' => $r->description,
            ];
        }, $result);
        
        return $result;
    }

    public function brands($brand)
    {
        $this->endpoint = "{$this->endpoint}?brand={$brand}";
        $data = Http::get($this->endpoint);
        $result = json_decode($data->body());
        
        $currency = new CurrencyService();
        $brl = $currency->getBRL();

        $price = array_column($result, 'price');
        array_multisort($price, SORT_ASC, $result);

        $temp = array();
        array_push($temp, $result[0]); // menor preço
        array_push($temp, end($result)); // maior preço

        $result = array_map(function($r) use ($brl){
            return [
                'name' => $r->name,
                'price_usd' => $r->price,
                'price_brl' => number_format(($r->price * $brl), 2, '.', ''),
                'description' => $r->description,
            ];
        }, $temp);

        return $result;
    }
    
}