<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model 
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'productId ', 'price',
    ];
    public $incrementing = false;
    protected $primaryKey = 'transactionId';
    protected $keyType = 'string';
    protected $connection = 'sqlite';
    protected $table = 'transaction';

}
