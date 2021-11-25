<?php

namespace App\Http\Controllers;

use App\Services\ProductService;

class ProductController extends Controller
{

    protected $productService;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->productService = new ProductService();
    }

    /**
     * Controller function to search products by type and category
     *
     * @param [type] $type
     * @param [type] $category
     * @return string
     */
    public function search(string $type, string $category) 
    {
        return ($this->productService->search($type, $category));
    }

    /**
     * get highest and lowest prices products by brand
     *
     * @param string $brand
     * @return string
     */
    public function brand(string $brand)
    {
        return ($this->productService->brandHiLowPrice($brand));
    }
}
