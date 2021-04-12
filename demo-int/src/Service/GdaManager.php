<?php


namespace App\Service;


use Grdf\GdaApiBundle\Accreditation\Client\GdaClient;
use Grdf\GdaApiBundle\Accreditation\Model\GdaResponse;

class GdaManager
{
    private $client;
    public function __construct(GdaClient $client)
    {
        $this->client = $client;
    }

    public function manage(): GdaResponse
    {
        return $this->client->getAccreditations([]);
    }
}