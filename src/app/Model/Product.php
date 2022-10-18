<?php
namespace App\Model;

use Jenssegers\Model\Model;
use App\Services\CoinConverterService;

class Product extends Model {

    protected $visible = ['name', 'price', 'description'];

    public function getPriceAttribute()
    {
        $coinConverter = app(CoinConverterService::class);
        $usdPrice = $brlPrice = (float) $this->attributes['price'];

        if (! empty($usdPrice)) {
            $brlPrice = (float) $coinConverter->usdToBrl($usdPrice);
        }

        return $brlPrice;

    }

}