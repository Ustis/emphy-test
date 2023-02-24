<?php

namespace App\Service\Product;

use App\Http\Clients\KommoSimpleApiClient;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ProductApiService implements ProductApiServiceInterface
{
    private KommoSimpleApiClient $api;

    public function __construct()
    {
        $this->api = new KommoSimpleApiClient();
    }

    /**

     * @throws HttpException
     */
    public function getProductByCatalogId(int $id)
    {
        return $this->api->getProductsFromCatalogId($id);
    }
}
