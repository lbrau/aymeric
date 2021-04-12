<?php

namespace App\Service;

use Grdf\GdaApiBundle\Accreditation\Client\GdaClient;
use Grdf\GdaApiBundle\Accreditation\Client\GdaSoapClient;
use Grdf\GdaApiBundle\Accreditation\Model\GdaResponse;
use Grdf\GdaApiBundle\Encoder\DataEncoderInterface;
use Grdf\GdaApiBundle\Helper\LogFormalizer;
use Grdf\GdaApiBundle\Normalizer\DataNormalizerInterface;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Serializer;

class GdaManagerTest extends TestCase
{
    private $gdaClient;
    private $dataEncoder;
    private $httpClientMock;

    public function setUp(): void
    {
        $logger = $this->getMockBuilder(LoggerInterface::class)
            ->allowMockingUnknownTypes()
            ->disableOriginalClone()
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $this->dataEncoder = $this->getMockBuilder(DataEncoderInterface::class)
            ->setMethods(['encode'])
            ->allowMockingUnknownTypes()
            ->disableOriginalClone()
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $finder = new Finder();
        $finder->files()->in(__DIR__ . '/../../Stream');
        $responses = [];
        foreach ($finder as $key => $file) {
            $responses[] = new MockResponse($file->getContents(), []);
        }

        $this->httpClientMock = new MockHttpClient($responses);

        $dataNormalizer = $this->getMockBuilder(DataNormalizerInterface::class)
            ->setMethods(['normalize', 'buildJsonPayload'])
            ->allowMockingUnknownTypes()
            ->disableOriginalClone()
            ->disableOriginalConstructor()
            ->getMock()
        ;

//        $dataNormalizer = new ObjectNormalizer(null, new CamelCaseToSnakeCaseNameConverter());

        $gdaSoapClient = $this->getMockBuilder(GdaSoapClient::class)
            ->allowMockingUnknownTypes()
            ->disableOriginalClone()
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $this->gdaClient = new GdaClient(
            'http://google.com/',
            $this->dataEncoder,
            $dataNormalizer,
            $gdaSoapClient,
            $this->httpClientMock,
            new Serializer([new GetSetMethodNormalizer()], ['json' => new JsonEncoder()]),
            new LogFormalizer($logger),
            '**token**'
        );
    }
    public function testManage(): void
    {
        self::assertInstanceOf(GdaResponse::class, $this->gdaClient->getAccreditations([]));
    }
}