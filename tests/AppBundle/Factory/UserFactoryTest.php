<?php
/**
 * Created by PhpStorm.
 * User: fintara
 * Date: 24/01/2017
 * Time: 13:50
 */

namespace AppBundle\Factory;


use AppBundle\Entity\Student;
use AppBundle\Entity\Worker;
use AppBundle\Exceptions\UnknownUserTypeException;

class UserFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testStudent()
    {
        $factory = new UserFactory();

        $obj = $factory->getUser(Student::TYPE);

        $this->assertEquals(Student::TYPE, $obj->getType());
    }

    public function testWorker()
    {
        $factory = new UserFactory();

        $obj = $factory->getUser(Worker::TYPE);

        $this->assertEquals(Worker::TYPE, $obj->getType());
    }

    public function testUnknown()
    {
        $factory = new UserFactory();

        $this->expectException(UnknownUserTypeException::class);
        $this->expectExceptionMessage('Unknown user type "unknown"');
        $obj = $factory->getUser('unknown');
    }
}
