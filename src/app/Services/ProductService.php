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
     * @param [string] $type
     * @param [string] $category
     * @return array
     */
    public function search(string $type, string $category) : array
    {
        $response = $this->httpClient->request('GET', $this->uri_base,[
            'query' => [
                'product_type' => $type,
                'product_category' => $category,
            ]
        ]);

        return json_decode( (string) $response->getBody(), true);
    }

    /**
     * Return all products by brand
     *
     * @param [string] $brand
     * @return array
     */
    public function brand($brand) : array
    {
        $response = $this->httpClient->request('GET', $this->uri_base,[
            'query' => [
                'brand' => $brand,
            ]
        ]
        );
    
        return json_decode( (string) $response->getBody(), true);
    }

    /**
     * return two products, highest and lowest priced
     *
     * @param [type] $brand
     * @return void
     */
    public function brandHiLowPrice($brand)
    {
        $allBrandProducts = $this->brand($brand);
        return [
            $this->getHighPrice($allBrandProducts),
            $this->getLowPrice($allBrandProducts)
            
        ];
    }

    /**
     * return lowest price product from a list
     *
     * @param [array] $products
     * @return array
     */
    private function getLowPrice(array $products) : array
    {
        usort($products, function($old, $new){
            return $old['price'] > $new['price'];
        });
        return $products[0];
    }

    /**
     * Return a Highest price product from a list
     *
     * @param array $products
     * @return array
     */
    private function getHighPrice(array $products) : array
    {
        usort($products, function($old, $new){
            return $old['price'] < $new['price'];
        });
        return $products[0];
    }
}