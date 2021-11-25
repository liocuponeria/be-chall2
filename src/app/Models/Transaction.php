<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;
use App\Traits\Uuids;
use GuzzleHttp\Psr7\Request;

class Transaction extends Model
{
    use Uuids;

    protected $table = 'transaction';
    protected $keyType = 'string';
    protected $fillable = ['productId', 'userId', 'price', 'date'];


}