<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProductService;
use App\Services\TransactionService;

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

    public function buy(Request $request, TransactionService $transactionService)
    {
        $this->validate($request, [
            'productId' => 'required|numeric',
            'UserId' => 'required|numeric',
            'Price' => 'required|numeric',
            'Date' => 'required|date',
        ]);
   
        $requestData = $request->all();

        $transactionEloquent = $transactionService->saveWithEloquent($requestData);
        $transactionQueryBuilder = $transactionService->saveWithQueryBuilder($requestData);
        $transactionRawSql = $transactionService->saveWithRawSql($requestData);

        return response()->json([
            'transactions' => [
                'eloquent' => $transactionEloquent,
                'query_builder' => $transactionQueryBuilder,
                'raw_sql' => $transactionRawSql,
            ]
            ]);
    }
}
