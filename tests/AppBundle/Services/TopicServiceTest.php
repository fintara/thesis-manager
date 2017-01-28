<?php

namespace Tests\AppBundle\Services;

use AppBundle\Entity\Reservation;
use AppBundle\Entity\Student;
use AppBundle\Entity\Topic;
use AppBundle\Exceptions\TopicReservedException;
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
        $this->topicRepo = $this->createMock(TopicRepositoryInterface::class);
        $this->reservationRepo = $this->createMock(ReservationRepositoryInterface::class);

        $this->service = new TopicService($this->topicRepo, $this->reservationRepo);
    }

    public function testReserveFirstTime()
    {
        $topic = new Topic();
        $topic->setTitle('Test topic');
        $reservationCnt = $topic->getReservations()->count();

        $student = new Student();
        $email = 'abc@student.org';
        $student->setEmail($email);

        $reservation = $this->service->reserve($topic, $student);
        $this->assertEquals($reservationCnt + 1, $topic->getReservations()->count());
    }

    public function testReserveAlready()
    {
        $topic = new Topic();
        $topic->setTitle('Test topic');

        $student = new Student();
        $email = 'abc@student.org';
        $student->setEmail($email);

        $this->service->reserve($topic, $student);

        $this->expectException(TopicReservedException::class);
        $this->service->reserve($topic, $student);
    }

}
