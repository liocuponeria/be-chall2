<?php
namespace App\Services\DataSource;

interface ProductSourceInterface
{

    const FILTER_BRAND_PARAM = 'brand';
    const FILTER_CATEGORY_PARAM = 'product_category';
    const FILTER_TYPE_PARAM = 'product_type';

    public function find(array $filters) : array;

}