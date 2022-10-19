<?php

namespace App\Services;

use App\Model\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TransactionService
{

    public function saveWithEloquent($requestData)
    {
        $transaction = new Transaction;
        $transaction->productId = $requestData['productId'];
        $transaction->userId = $requestData['UserId'];
        $transaction->price = $requestData['Price'];
        $transaction->date = $requestData['Date'];
        $transaction->save();

        return $transaction;
    }

    public function saveWithQueryBuilder($requestData)
    {
        $modelUuid = Str::uuid();

        DB::table('transaction')->insert([
            'transactionId' => $modelUuid,
            'productId' => $requestData['productId'],
            'userId' => $requestData['UserId'],
            'price' => $requestData['Price'],
            'date' => $requestData['Date'],
        ]);

        return Transaction::where('transactionId', $modelUuid)->first();
    }

    public function saveWithRawSql($requestData)
    {

        $modelUuid = Str::uuid();
        
        DB::insert(
            'insert into `transaction`(transactionId, productId, userId, price, date) values (?, ?, ?, ?, ?)', 
            [
                $modelUuid,
                $requestData['productId'],
                $requestData['UserId'],
                $requestData['Price'],
                $requestData['Date'],
            ]
        );

        return Transaction::where('transactionId', $modelUuid)->first();
        
    }
          // $transactionService->saveWithEloquent();
        // $transactionService->saveWithQueryBuilder();
        // $transactionService->saveWithRawSql();
}