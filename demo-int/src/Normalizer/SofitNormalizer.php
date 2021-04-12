<?php
namespace App\Normalizer;


use App\Model\Person;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;
use Symfony\Component\PropertyInfo\PropertyTypeExtractorInterface;
use Symfony\Component\Serializer\Mapping\ClassDiscriminatorResolverInterface;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactoryInterface;
use Symfony\Component\Serializer\NameConverter\NameConverterInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class SofitNormalizer
{
//    private $normalizer;
//
//    public function __construct(ObjectNormalizer $normalizer)
//    {
//        $this->normalizer = $normalizer;
//    }
//
//    public function setAttributeValue(object $object, string $attribute, $value, string $format = null, array $context = [])
//    {
//        dump($object, $attribute, $value);
//        if ('mail' === $attribute) {
//            $object->mail = $value[0];
//        }
//
//        parent::setAttributeValue( $object,  $attribute, $value,  $format ,  $context );
//    }

    /**
     * @var NormalizerInterface
     */
    private $objectNormalizer;

    public function __construct(NormalizerInterface $objectNormalizer) {
        $this->objectNormalizer = $objectNormalizer;
    }

    public function denormalize($data, string $type, string $format = null, array $context = [])
    {
        $person = $this->objectNormalizer->denormalize($data, $type, $format, $context);
        $person->setEmail($data[0]);

        dump($data,  $type, $person);
    }

    public function supportsDenormalization($data, string $type, string $format = null) {
        return $type === Person::class;
        // ici à priori tu dois cibler une classe précise
    }
}