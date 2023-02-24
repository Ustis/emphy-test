<?php

namespace App\Service\Catalog;

use App\Http\Clients\KommoSimpleApiClient;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class CatalogApiService implements CatalogApiServiceInterface
{
    private KommoSimpleApiClient $api;

    public function __construct()
    {
        $this->api = new KommoSimpleApiClient();
    }

    /**

     * @throws HttpException
     */
    public function getAllCatalogs()
    {
        return $this->api->getCatalogs();
    }

    /**

     * @throws HttpException
     */
    public function getProductCatalogs()
    {
        $catalogs = $this->getAllCatalogs();
        return array_filter($catalogs, function ($item) {
            if ($item->type == 'products')
                return $item;
        });
    }
}
