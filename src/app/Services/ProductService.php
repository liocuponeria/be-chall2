<?php

namespace App\Services;

use GuzzleHttp\Client;

class ProductService
{

    protected $httpClient, $uri_base;

    public function __construct()
    {
        $this->httpClientStart();
    }

    /**
     * Start Guzzle client and set base URI
     *
     * @return void
     */
    private function httpClientStart()
    {
        $this->uri_base = 'http://makeup-api.herokuapp.com/api/v1/products.json/';
        $this->httpClient = new Client();
    }

    /**
     * Search products by Type and Category
     *
     * @param [type] $type
     * @param [type] $category
     * @return void
     */
    public function search($type, $category)
    {
        
        $uri = $type . '/' . $category;

        $response = $this->httpClient->request('GET', $this->uri_base,[
            'query' => [
                'product_type' => $type,
                'product_category' => $category,
            ]
        ]);

        return json_decode( (string) $response->getBody(), true);
    }


    
}