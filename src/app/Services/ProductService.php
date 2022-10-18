<?php

namespace App\Services;

use App\Services\DataSource\ProductSourceInterface;

class ProductService
{
    public function __construct(ProductSourceInterface $dataSource)
    {
        $this->dataSource = $dataSource;
    }

    public function searchByTypeAndCategory(string $type, string $category)
    {
        $products = $this->dataSource->find([
            ProductSourceInterface::FILTER_CATEGORY_PARAM => $category,
            ProductSourceInterface::FILTER_TYPE_PARAM => $type
        ]);

        return $products;
    }

    public function searchCheapestAndMostExpensiveByBrand(string $brand)
    {
        $products = $this->dataSource->find([
            ProductSourceInterface::FILTER_BRAND_PARAM => $brand,
        ]);

        $cheapestProduct = $mostExpensiveProduct = array_shift($products);

        foreach($products as $product) {
            $currentPrice = (float) $product->price;
            $cheapestPrice = (float) $cheapestProduct->price;
            $mostExpensivePrice = (float) $mostExpensiveProduct->price;

            if ($currentPrice < $cheapestPrice) {
                $cheapestProduct = $product;
            }

            if ($currentPrice > $mostExpensivePrice) {
                $mostExpensiveProduct = $product;
            }
        }

        return [
            'cheapest' => $cheapestProduct,
            'most_expensive' => $mostExpensiveProduct
        ];
    }
}