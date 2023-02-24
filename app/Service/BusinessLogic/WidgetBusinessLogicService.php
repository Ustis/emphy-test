<?php

namespace App\Service\BusinessLogic;

use App\Service\Catalog\CatalogApiService;
use App\Service\Catalog\CatalogApiServiceInterface;
use App\Service\Lead\LeadApiService;
use App\Service\Lead\LeadApiServiceInterface;
use App\Service\Product\ProductApiService;
use App\Service\Product\ProductApiServiceInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;

class WidgetBusinessLogicService implements WidgetBusinessLogicServiceInterface
{
    private LeadApiServiceInterface $leadService;
    private CatalogApiServiceInterface $catalogService;
    private ProductApiServiceInterface $productService;

    public function __construct(LeadApiService    $leadService,
                                CatalogApiService $catalogService,
                                ProductApiService $productService)
    {
        $this->leadService = $leadService;
        $this->catalogService = $catalogService;
        $this->productService = $productService;
    }

    /**

     * @throws HttpException
     */
    public function getLeadAndLinkedProducts(int $id): array
    {
        $productsInLead = $this->leadService->getLinkedProductsByLeadId($id);

        $catalogs = $this->catalogService->getProductCatalogs();

        foreach ($catalogs as $catalog) {
            $catalog->products = $this->productService->getProductByCatalogId($catalog->id);
            $productsInCatalog = $this->productService->getProductByCatalogId($catalog->id);
        }

        foreach ($productsInLead as $productInLead) {
            foreach ($catalogs as $catalog) {
                foreach ($catalog->products as $productInCatalog) {
                    if ($productInLead->to_entity_id == $productInCatalog->id) {
                        $productInLead->name = $productInCatalog->name;
                        $productInLead->custom_field = $productInCatalog->custom_fields_values;
                    }
                }
            }
        }

        return $productsInLead;
    }
}
