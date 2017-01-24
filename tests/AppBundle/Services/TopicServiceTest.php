<?php

namespace Tests\AppBundle\Services;

use AppBundle\Entity\Reservation;
use AppBundle\Entity\Student;
use AppBundle\Entity\Topic;
use AppBundle\Repository\ReservationRepositoryInterface;
use AppBundle\Repository\TopicRepositoryInterface;
use AppBundle\Services\TopicService;

class TopicServiceTest extends \PHPUnit_Framework_TestCase
{
    /** @var TopicRepositoryInterface */
    private $topicRepo;

    /** @var ReservationRepositoryInterface */
    private $reservationRepo;

    /** @var TopicService */
    private $service;

    protected function setUp()
    {
        $this->topicRepo = new class implements TopicRepositoryInterface {

            public function findByIdAndStatus(int $id, string $status)
            {
                // TODO: Implement findByIdAndStatus() method.
            }

            public function findByStatus(string $status)
            {
                // TODO: Implement findByStatus() method.
            }
        };

        $this->reservationRepo = new class implements ReservationRepositoryInterface {

            public function save(Reservation $reservation, bool $flush = true)
            {
                // TODO: Implement save() method.
            }
        };

        $this->service = new TopicService($this->topicRepo, $this->reservationRepo);
    }

    public function testReserveFirstTime()
    {
        $topic = new Topic();
        $topic->setTitle('Test topic');

        $student = new Student();
        $email = 'abc@student.org';
        $student->setEmail($email);

        $reservation = $this->service->reserve($topic, $student);
        $this->assertEquals($email, $reservation->getStudent()->getEmail());
    }

}
