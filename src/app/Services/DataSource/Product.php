<?php
namespace App\Services\DataSource;

use Illuminate\Support\Facades\Http;

class Product implements ProductSourceInterface
{

    private $endpoint = "http://makeup-api.herokuapp.com/api/v1/products.json";

    public function __construct(string $modelClass)
    {
        $this->modelClass = $modelClass;
    }
    
    /**
     * Request makeup-api and return a filtered results by $filters param
     *
     * @param array $filters
     * @return array
     */
    public function find(array $filters) : array
    {
        $apiResponse = Http::acceptJson()->get($this->endpoint, $filters);
        $products = json_decode($apiResponse->getBody(), true);

        return array_map(function($product){
            return new $this->modelClass($product);
        }, $products);
    }
}