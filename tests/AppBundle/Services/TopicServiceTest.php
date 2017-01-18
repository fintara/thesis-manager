<?php

namespace Tests\AppBundle\Services;

use AppBundle\Entity\Student;
use AppBundle\Entity\Topic;
use AppBundle\Services\TopicService;

class TopicServiceTest extends \PHPUnit_Framework_TestCase
{
    private $topic;

    protected function setUp()
    {
        $this->service = new TopicService($this->topic, $this->student);
    }

    public function testReserveFirstTime()
    {

    }

}
