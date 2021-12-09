<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Str;


class ProductController extends BaseController
{
    public function search($type, $category)
    {
        $url = "http://makeup-api.herokuapp.com/api/v1/products.json?product_category=$type&product_type=$category";
        $request = Http::get($url);

        return $this->selectProduct($request->json(), false);
    }

    public function brand($brand)
    {
        $brand = 'nyx';
        $url = "http://makeup-api.herokuapp.com/api/v1/products.json?brand=$brand";
        $request = Http::get($url);
        
        $productlist = $this->selectProduct($request->json());
        return $this->minmaxPrice($productlist);
    }

    public function purchase(Request $request) 
    {
        $transaction = new Transaction();
        $transaction->transactionId = Str::random(50);
        $transaction->productId = $request->productId;
        $transaction->userId = $request->UserId;
        $transaction->price = $request->Price;
        $data = date('Y-d-m', strtotime($request->Date));
        $transaction->date = $data;
        $transaction->save();
        
        return response()->json(['id'=> $transaction->transactionId, 'select'=> $this->find()]);
    }

    public function find() 
    {
        $query = DB::table('Transaction')->where('productId', 11);
        $sql = $query->toSql();
        return [$sql, $query->get()];
    }

    private function selectProduct($products)
    {
        $countlst = 0;
        $list = [];
        
        foreach ($products as $prodLst)  {
            $list[$countlst]['name'] =  $prodLst['name'];
            $list[$countlst]['price_original'] =  $prodLst['price'];  
            $list[$countlst]['price_in_BRL'] = $this->convertToBRL($prodLst['currency'], $prodLst['price']);
            $list[$countlst]['description'] =  $prodLst['description'];
             $countlst++;
        }
        
        return $list;
    }
       
    //https://api.fastforex.io/convert?from=USD&to=BRL&amount=1.00&api_key=231fa23661-afea7a3c9e-r3hr84
    private function convertToBRL($from, $amount) 
    {
        if ($amount > 0) {
            $url = "https://api.fastforex.io/convert?from=$from&to=BRL&amount=$amount&api_key=231fa23661-afea7a3c9e-r3hr84";
            $request = Http::get($url);
            return $request['result']['BRL'];
        }
        return "0.00";
    }

    private function minmaxPrice($productList) 
    {
        $minPrice = 0;
        $maxPrice = 0;
        $minmax =[];
        
        foreach ($productList as $prodLst)  {
            if ($maxPrice == 0 and $minPrice == 0) {
                $minPrice = floatval($prodLst['price']);  
                $maxPrice = floatval($prodLst['price']);  
            }
            if ($maxPrice < floatval($prodLst['price'])) {
                $minmax['maxprice']['name'] =  $prodLst['name'];
                $minmax['maxprice']['price_original'] =  $prodLst['price'];
                $minmax['maxprice']['price_in_BRL'] =  $prodLst['priceBRL'];
                $minmax['maxprice']['description'] =  $prodLst['description'];
                $maxPrice =$prodLst['price'];
            }
            if ($minPrice > floatval($prodLst['price'])) {
                $minmax['minprice']['name'] =  $prodLst['name'];
                $minmax['minprice']['price_original'] =  $prodLst['price'];
                $minmax['minprice']['price_in_BRL'] =  $prodLst['priceBRL'];
                $minmax['minprice']['description'] =  $prodLst['description'];
                $minPrice =$prodLst['price'];
            }
        }
        return $minmax;
    }

}
