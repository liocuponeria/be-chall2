<?php

namespace App\Services;

use App\Models\Transaction;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

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

        return $this->convertCurrency(json_decode( (string) $response->getBody()));
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
        $products = [
            $this->getHighPrice($allBrandProducts),
            $this->getLowPrice($allBrandProducts)
            
        ];
        return $this->convertCurrency($products);
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

    /**
     * Validate and save new transaction
     *
     * @param Request $request
     * @return void
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'productId' => 'required|integer',
            'userId' => 'required|integer',
            'price' => 'required|numeric',
            'date' => 'date'
        ]);

        if (  $validator->fails()) {
            return $validator->errors();
        }
        DB::enableQueryLog();
        $registry = Transaction::create($request->all());

        return [
            'id' => $registry->id,
            'query' => last(DB::getQueryLog()),
        ];

        
    }

    /**
     * Add new propriety price_brl, converting USD to BRL values
     *
     * @param [type] $products
     * @return array
     */
    private function convertCurrency(array $products) : array
    {
        $currencyService = new CurrencyService();
        $baseValue = $currencyService->convert(1);
        $return = [];

        foreach($products as $index => $product)
        {
            
            $product->price_brl = $product->price * $baseValue->result->BRL;
            $return[$index] = $product;
        }

        return $return;
    }
}