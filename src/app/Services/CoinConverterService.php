<?php

namespace App\Services;

use App\Services\DataSource\CoinConverterSourceInterface;

class CoinConverterService
{
    public function __construct(CoinConverterSourceInterface $dataSource)
    {
        $this->dataSource = $dataSource;
    }

    public function usdToBrl(float $amount) : float
    {
        return $this->dataSource->convert(
            $amount,
            CoinConverterSourceInterface::SYMBOL_USD,
            CoinConverterSourceInterface::SYMBOL_BRL
        );
    }
   
}