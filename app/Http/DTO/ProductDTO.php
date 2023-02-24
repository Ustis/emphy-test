<?php

namespace App\Http\DTO;

class ProductDTO
{
    public function __construct(string $name, string $quantity, string $price)
    {
        $this->name = $name;
        $this->quantity = $quantity;
        $this->price = $price;
    }
}
