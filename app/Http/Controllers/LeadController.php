<?php

namespace App\Http\Controllers;

use App\Http\DTO\ProductDTO;
use App\Service\BusinessLogic\WidgetBusinessLogicService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    private WidgetBusinessLogicService $businessLogicService;

    public function __construct(WidgetBusinessLogicService $businessLogicService)
    {
        $this->businessLogicService = $businessLogicService;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getLeadsAndLinkedProducts(Request $request): JsonResponse
    {
        try {
            $products = $this->businessLogicService->getLeadAndLinkedProducts($request->all()['id']);
        } catch (HttpException $exception) {
            return response()->json(array('Error message' => $exception->getMessage()), $exception->getStatusCode());
        }
        $productDTOs = array();
        $getValue = function (array $custom_fields){
            foreach ($custom_fields as $custom_field) {
                if($custom_field->field_name == 'Price') {
                    return $custom_field->values[0]->value;
                }
            }
            return '';
        };

        foreach ($products as $product) {
            $productDTOs[] = new ProductDTO($product->name,
                $product->metadata->quantity,
                $getValue($product->custom_field));
        }
        return response()->json($productDTOs, 200);
    }
}
