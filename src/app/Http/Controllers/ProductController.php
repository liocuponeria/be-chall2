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
     * @return json string
     */
    public function search($type, $category) 
    {
        return ($this->productService->search($type, $category));
    }
}
