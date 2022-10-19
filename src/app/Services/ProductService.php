<?php

namespace App\Services;

use App\Services\DataSource\ProductSourceInterface;

class ProductService
{
    public function __construct(ProductSourceInterface $dataSource)
    {
        $this->dataSource = $dataSource;
    }

    /**
     * Search a product by type and category
     *
     * @param string $type The product's type
     * @param string $category The product's category
     * @return array Return an array of Product
     */
    public function searchByTypeAndCategory(string $type, string $category): array
    {
        $products = $this->dataSource->find([
            ProductSourceInterface::FILTER_CATEGORY_PARAM => $category,
            ProductSourceInterface::FILTER_TYPE_PARAM => $type
        ]);

        return $products;
    }

    /**
     * Search de cheapest and the most expensive product by brand
     *
     * @param string $brand The product's brand
     * @return array Return an array with the cheapest an most expensive product
     */
    public function searchCheapestAndMostExpensiveByBrand(string $brand): array
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