<?php

namespace App\Service\Product;

interface ProductApiServiceInterface
{
    public function getProductByCatalogId(int $id);
}
