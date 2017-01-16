<?php
/**
 * Created by PhpStorm.
 * User: fintara
 * Date: 15/01/2017
 * Time: 19:33
 */

namespace AppBundle\Services;


use AppBundle\Entity\Reservation;
use AppBundle\Entity\Student;
use AppBundle\Entity\Topic;
use AppBundle\Repository\ReservationRepository;
use AppBundle\Repository\TopicRepository;

class TopicService
{
    private $repository;

    public function __construct(TopicRepository $topicRepository, ReservationRepository $reservationRepository)
    {
        $this->topicRepo = $topicRepository;
        $this->reservationRepo = $reservationRepository;
    }

    public function reserve(Topic $topic, Student $student): Reservation
    {
        $reservation = new Reservation();

        $reservation->setTopic($topic);
        $reservation->setStudent($student);
        $reservation->setCreatedAt(new \DateTime());

        $this->reservationRepo->save($reservation);

        return $reservation;
    }
}