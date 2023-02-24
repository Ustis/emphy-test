<?php

namespace App\Service\Catalog;

interface CatalogApiServiceInterface
{
    public function getAllCatalogs();

    public function getProductCatalogs();
}
