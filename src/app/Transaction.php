<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $guarded = ['id'];
    protected $primaryKey = 'transaction_id';
    protected $keyType = 'string';
    public $timestamps = false;

    public $incrementing = false;
}
