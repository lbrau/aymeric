<?php

namespace App\Controller;

use Grdf\GdaApiBundle\Accreditation\Client\GdaClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultGdaController extends AbstractController
{
    private $gdaClient;

    public function __construct(GdaClient $gdaClient)
    {
        $this->gdaClient = $gdaClient;
    }

    /**
     * @Route("/", name="default_gda")
     */
    public function index(): Response
    {
        dump($this->gdaClient->getUserAccreditation('toto', 'titi'));die;
    }
}
