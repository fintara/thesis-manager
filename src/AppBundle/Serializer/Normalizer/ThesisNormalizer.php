<?php

namespace AppBundle\Serializer\Normalizer;

use AppBundle\Entity\Student;
use AppBundle\Entity\Thesis;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\scalar;
use Symfony\Component\Serializer\SerializerAwareInterface;
use Symfony\Component\Serializer\SerializerAwareTrait;

class ThesisNormalizer implements NormalizerInterface, SerializerAwareInterface {
    use SerializerAwareTrait;

    /**
     * @param Thesis $object
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
            'id'        => $object->getId(),
            'title'     => $object->getTitle(),
            'students'  => array_map(function($student) {
                return $this->serializer->normalize($student);
            }, $object->getStudents()->toArray()),
            'topic'     => $this->serializer->normalize($object->getTopic()),
            'supervisor'=> $this->serializer->normalize($object->getSupervisor()),
            'reviewer'  => 0,
        ];
    }

    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof Thesis;
    }
}
