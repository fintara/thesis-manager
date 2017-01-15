<?php

namespace AppBundle\Serializer\Normalizer;

use AppBundle\Entity\User;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\scalar;
use Symfony\Component\Serializer\SerializerAwareInterface;
use Symfony\Component\Serializer\SerializerAwareTrait;

class UserNormalizer implements NormalizerInterface, SerializerAwareInterface {
    use SerializerAwareTrait;

    /**
     * @param User $object
     * @param null $format
     * @param array $context
     * @return array
     * @throws \Exception
     */
    public function normalize($object, $format = null, array $context = array())
    {
        if (!$this->serializer instanceof NormalizerInterface) {
            throw new \Exception('Cannot normalize, injected serializer is not a normalizer');
        }

        return [
            'fullName' => $object->getFullName(),
        ];
    }

    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof User;
    }
}
