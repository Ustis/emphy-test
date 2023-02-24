<?php

namespace App\Service\Lead;

use App\Http\Clients\KommoSimpleApiClient;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class LeadApiService implements LeadApiServiceInterface
{
    private KommoSimpleApiClient $api;

    public function __construct()
    {
        $this->api = new KommoSimpleApiClient();
    }

    /**

     * @throws HttpException
     */
    public function getLeads()
    {
        return $this->api->getLeads();
    }

    /**

     * @throws HttpException
     */
    public function getLinkedProductsByLeadId(int $id)
    {
        $leads = $this->api->getLeadLinksById($id);
        return array_filter($leads, function ($item) {
            if ($item->to_entity_type == 'catalog_elements')
                return $item;
        });
    }
}
