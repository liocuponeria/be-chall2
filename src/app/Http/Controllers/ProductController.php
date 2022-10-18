<?php

namespace App\Http\Controllers;

use App\Services\ProductService;

class ProductController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function search(ProductService $productService, string $type, string $category)
    {
        
        $products = $productService->searchByTypeAndCategory($type, $category);

        return response()->json(['products' => $products]);
    }

    public function searchCheapestAndMostExpensiveByBrand(
        ProductService $productService,
        string $brand
    ){

        $products = $productService->searchCheapestAndMostExpensiveByBrand($brand);
        
        return response()->json(['products' => $products]);
    }
}
