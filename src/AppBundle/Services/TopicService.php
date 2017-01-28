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
use AppBundle\Exceptions\TopicReservedException;
use AppBundle\Repository\ReservationRepositoryInterface;
use AppBundle\Repository\TopicRepositoryInterface;

/**
 * Topic service
 * @package AppBundle\Services
 */
class TopicService
{
    /** @var TopicRepositoryInterface  */
    private $topicRepo;

    /** @var ReservationRepositoryInterface  */
    private $reservationRepo;

    /**
     * TopicService constructor.
     *
     * @param TopicRepositoryInterface $topicRepository
     * @param ReservationRepositoryInterface $reservationRepository
     */
    public function __construct(TopicRepositoryInterface $topicRepository,
                                ReservationRepositoryInterface $reservationRepository)
    {
        $this->topicRepo = $topicRepository;
        $this->reservationRepo = $reservationRepository;
    }

    /**
     * Reserves a topic for a student.
     * @param Topic $topic          Topic a student wants to reserve
     * @param Student $student      Student that wants to reserve a topic
     * @return Reservation          Created reservation
     * @throws TopicReservedException   Thrown if this student has already reserved this topic
     */
    public function reserve(Topic $topic, Student $student): Reservation
    {
        if ($topic->isReservedFor($student)) {
            throw new TopicReservedException();
        }

        $reservation = new Reservation();

        $reservation->setTopic($topic);
        $reservation->setStudent($student);
        $reservation->setCreatedAt(new \DateTime());

        $this->reservationRepo->save($reservation);

        $topic->addReservation($reservation);

        return $reservation;
    }
}