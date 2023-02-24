<?php

namespace App\Http\Clients;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class KommoSimpleApiClient
{
    private $baseUri = 'https://stepanovmihailwork.kommo.com/api/v4';
    private $client;
    private $token = '';

    public function __construct()
    {
        $this->token = env('KOMMO_INTEGRATION_TOKEN', 'error');
        if ($this->token == 'error')
            throw new HttpException('Token dont exist', 500);
        $this->client = new Client(["headers" => ['Authorization' => 'Bearer ' . $this->token]]);
    }

    /**
     * @throws HttpException
     */
    private function getRequest(string $url)
    {
        try {
            $req = $this->client->request('GET', $url)->getBody();
        } catch (GuzzleException $exception) {
            if ($exception->getCode() == 401) {
                throw new HttpException(401, 'Token expired');
            }
            throw new HttpException(500,
                'Unknown GuzzleException' . $exception->getMessage() . $exception->getTraceAsString());
        } catch (Exception $exception) {
            throw new HttpException(500, 'Unknown error' . $exception->getMessage() . (string)$exception);
        }
        $req = $req->read($req->getSize());
        return json_decode($req);
    }

    /**
     * @throws HttpException
     */
    public function getLeads()
    {
        $req = $this->getRequest($this->baseUri . '/leads');
        return $req->_embedded->leads;
    }

    /**
     * @throws HttpException
     */
    public function getLeadLinksById(int $id)
    {
        $req = $this->getRequest($this->baseUri . '/leads/' . $id . '/links');
        return $req->_embedded->links;
    }

    /**
     * @throws HttpException
     */
    public function getCatalogs()
    {
        $req = $this->getRequest($this->baseUri . '/catalogs');
        return $req->_embedded->catalogs;
    }

    /**
     * @throws HttpException
     */
    public function getProductsFromCatalogId(int $id)
    {
        $req = $this->getRequest($this->baseUri . '/catalogs/' . $id . '/elements');
        return $req->_embedded->elements;
    }
}
