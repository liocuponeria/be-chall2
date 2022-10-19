<?php

namespace App\Services;

use App\Model\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TransactionService
{

    /**
     * This method create a new Transaction model with $requestData and
     * save it using Eloquent
     *
     * @param array $requestData
     * @return Transaction
     */
    public function saveWithEloquent(array $requestData): Transaction
    {
        $transaction = new Transaction;
        $transaction->productId = $requestData['productId'];
        $transaction->userId = $requestData['UserId'];
        $transaction->price = $requestData['Price'];
        $transaction->date = $requestData['Date'];
        $transaction->save();

        return $transaction;
    }

    /**
     * This method create a new Transaction model with $requestData and
     * save it using Query Builder
     *
     * @param array $requestData
     * @return Transaction
     */
    public function saveWithQueryBuilder(array $requestData): Transaction
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

    /**
     * This method create a new Transaction model with $requestData and
     * save it using Raw SQL
     *
     * @param array $requestData
     * @return Transaction
     */
    public function saveWithRawSql(array $requestData): Transaction
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
}