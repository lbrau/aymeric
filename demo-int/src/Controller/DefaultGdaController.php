<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Grdf\SofitBundle\Client\SofitClient;

class DefaultGdaController extends AbstractController
{

    private $serializer;
    private $sofitClient;

    public function __construct(SerializerInterface $serializer, SofitClient $sofitClient)
    {
        $this->serializer = $serializer;
        $this->sofitClient = $sofitClient;
    }

    /**
     * @Route("/", name="default_gda")
     */
    public function index(): Response
    {

    }
}
