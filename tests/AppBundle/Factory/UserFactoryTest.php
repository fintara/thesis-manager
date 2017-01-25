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
    /** @var UserFactory */
    private $factory;

    protected function setUp()
    {
        $this->factory = new UserFactory();
    }

    public function testStudent()
    {
        $obj = $this->factory->createUser(Student::TYPE);

        $this->assertEquals(Student::TYPE, $obj->getType());
    }

    public function testWorker()
    {
        $obj = $this->factory->createUser(Worker::TYPE);

        $this->assertEquals(Worker::TYPE, $obj->getType());
    }

    public function testUnknown()
    {
        $this->expectException(UnknownUserTypeException::class);
        $this->expectExceptionMessage('Unknown user type "unknown"');
        $this->factory->createUser('unknown');
    }
}
