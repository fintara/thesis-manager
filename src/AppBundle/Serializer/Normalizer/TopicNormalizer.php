<?php

namespace AppBundle\Serializer\Normalizer;

use AppBundle\Entity\Reservation;
use AppBundle\Entity\Student;
use AppBundle\Entity\Topic;
use AppBundle\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\scalar;
use Symfony\Component\Serializer\SerializerAwareInterface;
use Symfony\Component\Serializer\SerializerAwareTrait;
use Symfony\Component\Serializer\SerializerInterface;

class TopicNormalizer implements NormalizerInterface, SerializerAwareInterface {
    use SerializerAwareTrait;

    private $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

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

        $arr = [
            'id'            => $object->getId(),
            'title'         => $object->getTitle(),
            'supervisor'    => $this->serializer->normalize($object->getSupervisor()),
            'reservation'   => false,
            'reservations'  => [
                'count' => $object->getReservations(Reservation::STATUS_NEW)->count(),
            ],
        ];

        $user = $this->getUser();
        if ($user && $user->getType() === Student::TYPE && $object->isReservedFor($user)) {
            $arr['reservation'] = [
                'status' => $object->getReservationFor($user)->getStatus(),
            ];
        }

        return $arr;
    }

    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof Topic;
    }

    /**
     * @return null|User
     */
    protected function getUser()
    {
        if (($token = $this->tokenStorage->getToken()) === null) {
            return null;
        }

        return $token->getUser();
    }
}
