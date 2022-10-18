<?php
namespace App\Services\DataSource;

interface CoinConverterSourceInterface
{
    const SYMBOL_USD = 'USD';
    const SYMBOL_BRL = 'BRL';

    public function convert(float $amount, string $from, string $to) : float;
}