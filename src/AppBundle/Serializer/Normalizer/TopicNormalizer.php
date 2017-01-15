<?php

namespace AppBundle\Serializer\Normalizer;

use AppBundle\Entity\Topic;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\scalar;
use Symfony\Component\Serializer\SerializerAwareInterface;
use Symfony\Component\Serializer\SerializerAwareTrait;
use Symfony\Component\Serializer\SerializerInterface;

class TopicNormalizer implements NormalizerInterface, SerializerAwareInterface {
    use SerializerAwareTrait;

    /**
     * @param Topic $object
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
            'id'            => $object->getId(),
            'title'         => $object->getTitle(),
            'supervisor'    => $this->serializer->normalize($object->getSupervisor()),
            'reservations'  => [
                'count' => $object->getReservations()->count(),
            ],
        ];
    }

    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof Topic;
    }
}
