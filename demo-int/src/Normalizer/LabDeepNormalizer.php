<?php
namespace App\Normalizer;

use App\Model\DeepModel;
use App\Model\DeepUserModel;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class LabDeepNormalizer implements SerializerInterface, NormalizerInterface, DenormalizerInterface
{
    public function serialize($data, string $format, array $context = [])
    {
//        dump('labDeep');die;
        // TODO: Implement serialize() method.
    }

    public function deserialize($data, string $type, string $format, array $context = [])
    {
        // TODO: Implement deserialize() method.
    }

    public function normalize($object, string $format = null, array $context = [])
    {
        // TODO: Implement normalize() method.
    }

    public function supportsNormalization($data, string $format = null)
    {
        // TODO: Implement supportsNormalization() method.
    }

    public function denormalize($data, string $type, string $format = null, array $context = [])
    {
        $arrayDenormalizer = new ArrayDenormalizer();
        $res = $arrayDenormalizer->denormalize($data, $type, $format, $context);

//        dump($data,$type,$res);
        // TODO: Implement denormalize() method.
    }

    public function supportsDenormalization($data, string $type, string $format = null): bool
    {
        return DeepModel::class === $type;
    }
}