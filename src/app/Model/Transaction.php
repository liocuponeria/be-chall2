<?php
 
namespace App\Model;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
 
class Transaction extends Model
{
    protected $table = 'transaction';
    protected $primaryKey = 'transactionId';
    protected $keyType = 'string';

    public $incrementing = false;
    public $timestamps = false;

    protected $casts = [
        'transactionId' => 'string',
        'productId' => 'integer',
        'userId' => 'integer',
        'price' => 'float',
        'date' => 'date:Y-m-d',
    ];

    protected static function booted()
    {
        static::creating(fn(Transaction $trasnaction) => $trasnaction->transactionId = (string) Str::uuid());
    }
}