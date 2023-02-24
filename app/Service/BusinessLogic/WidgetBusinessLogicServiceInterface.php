<?php

namespace App\Service\BusinessLogic;

interface WidgetBusinessLogicServiceInterface
{
    public function getLeadAndLinkedProducts(int $id): array;
}
