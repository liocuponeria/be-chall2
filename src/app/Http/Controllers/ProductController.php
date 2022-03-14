<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProductService;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    public function search($type, $category)
    {
        
        $productService = new ProductService;;

        $result = $productService->search($type, $category);
        
        return response()->json($result);
    }

    public function brands($brand)
    {
        
        $productService = new ProductService;;

        $result = $productService->brands($brand);
        
        return response()->json($result);
    }

    public function buy(Request $request){
        $transactionId = Str::random(50);
        $price = number_format($request->price, 2, '.', '');
        $date = date('Y-d-m', strtotime($request->date));

        
        $transaction = new Transaction();
        $transaction->transactionId = $transactionId;
        $transaction->productId = $request->productId;
        $transaction->userId = $request->userId;
        
        $transaction->price = $price;
        $transaction->date = $date;
        $transaction->save();

        $select = DB::table('Transaction')->where('transactionId', $transactionId);

        $result = [
            'id'=> $transactionId, 
            'select'=> $select->toSql(),
            'data' => $select->get()
        ];

        return response()->json($result);
    }
}
