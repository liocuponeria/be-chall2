<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public $makeup_curl;
    public $currency_curl;
    public $currency_rate;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->makeup_curl = curl_init();
        $this->currency_curl = curl_init();
    }

    /**
     * Pesquisa produtos por tipo e categoria
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function search($type, $category) {
        $makeup_api_url = config('app.api_url') . "?product_type=${type}&product_category=${category}";

        [$makeup_response, $currency_response] = $this->get_apis_responses($makeup_api_url);

        if (count($makeup_response) == 0) {
            return response()->json([
                'status' => 'invalid',
                'message' => 'Não foi encontrado nenhum produto para essa busca!!'
            ], 404);
        }

        if ($currency_response->result === 'error') {
            return response()->json([
                'status' => 'error',
                'message' => 'Houve um error ao buscar a conversão de moeda, por favor verifique a integração!!'
            ], 500);
        }

        $this->currency_rate = $currency_response->conversion_rates->BRL;

        $products = array_map(
            fn($product) => $this->product_filter_fields($product),
            $makeup_response
        );

        return response()->json($products);
    }

    /**
     * Retorna o produto mais caro e o mais barato de uma marca.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function brands($brand) {
        $makeup_api_url = config('app.api_url') . "?brand=${brand}";

        [$makeup_response, $currency_response] = $this->get_apis_responses($makeup_api_url);

        if (count($makeup_response) == 0) {
            return response()->json([
                'status' => 'invalid',
                'message' => 'Não foi encontrado nenhum produto para essa busca!!'
            ], 404);
        }

        if ($currency_response->result === 'error') {
            return response()->json([
                'status' => 'error',
                'message' => 'Houve um error ao buscar a conversão de moeda, por favor verifique a integração!!'
            ], 500);
        }

        $this->currency_rate = $currency_response->conversion_rates->BRL;

        $initial_value = new \stdClass();
        $initial_value->price = "0";

        $cheapest_product = array_reduce(
            $makeup_response,
            fn($carry, $item) => $this->cheapest_product($carry, $item),
            $initial_value
        );

        $cheapest_product = $this->product_filter_fields($cheapest_product);

        $most_expansive_product = array_reduce(
            $makeup_response,
            fn($carry, $item) => $this->most_expansive_product($carry, $item),
            $initial_value
        );

        $most_expansive_product = $this->product_filter_fields($most_expansive_product);

        return response()->json([
            'cheapest_product' => $cheapest_product,
            'most_expansive_product' => $most_expansive_product
        ]);
    }

    /**
     * Insere a transação de um produto.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function buy(Request $request) {
        $validated = $this->validate($request, [
            'product_id' => 'required|numeric',
            'user_id' => 'required|numeric',
            'price' => 'required|numeric',
            'date' => 'required|date',
        ]);

        return response()->json($validated);
    }

    /**
     * Faz a conexão com as API's necessárias
     *
     * @return array
     */
    private function get_apis_responses($makeup_api_url) {
        curl_setopt_array($this->currency_curl, [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => config('app.currency_api.url') . "/" . config('app.currency_api.key') . "/" . "latest/USD"
        ]);
        curl_setopt_array($this->makeup_curl, [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $makeup_api_url
        ]);

        $multi_curl = curl_multi_init();

        curl_multi_add_handle($multi_curl, $this->makeup_curl);
        curl_multi_add_handle($multi_curl, $this->currency_curl);

        $active = null;
        do {
            $mrc = curl_multi_exec($multi_curl, $active);
        } while ($mrc == CURLM_CALL_MULTI_PERFORM);

        while ($active && $mrc == CURLM_OK) {
            if (curl_multi_select($multi_curl) != -1) {
                do {
                    $mrc = curl_multi_exec($multi_curl, $active);
                } while ($mrc == CURLM_CALL_MULTI_PERFORM);
            }
        }

        curl_multi_remove_handle($multi_curl, $this->makeup_curl);
        curl_multi_remove_handle($multi_curl, $this->currency_curl);
        curl_multi_close($multi_curl);

        $makeup_response = curl_multi_getcontent($this->makeup_curl);
        $currency_response = curl_multi_getcontent($this->currency_curl);

        return [
            json_decode($makeup_response),
            json_decode($currency_response)
        ];
    }

    /**
     * Retorna um produto com os campos específicos como requerido.
     * Campos:
     * - Nome (name)
     * - Descrição (description)
     * - Preço original (original_price)
     * - Preço convertido (converted_price)
     *
     * @return \stdClass
     */
    private function product_filter_fields($product) {
        $product_filtered = new \stdClass;
        $product_filtered->name = $product->name;
        $product_filtered->description = $product->description;
        $product_filtered->original_price = $product->price;
        $product_filtered->converted_price = $this->convert_currency($product->price);

        return $product_filtered;
    }

    /**
     * Faz a conversão do valor original (USD) para o valor em BRL.
     *
     * @return string
     */
    private function convert_currency($price) {
        $price = floatval($price);
        return strval(round(($price * $this->currency_rate), 2));
    }

    /**
     * Valida o produto com menor valor.
     *
     * @return \stdClass
     */
    private function cheapest_product($previous_product, $current_product) {
        if (floatval($previous_product->price) < floatval($current_product->price)) {
            return $previous_product;
        }

        return $current_product;
    }

    /**
     * Valida o produto com maior valor.
     *
     * @return \stdClass
     */
    private function most_expansive_product($previous_product, $current_product) {
        if (floatval($previous_product->price) > floatval($current_product->price)) {
            return $previous_product;
        }

        return $current_product;
    }
}
