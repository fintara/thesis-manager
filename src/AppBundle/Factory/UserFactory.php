<?php
/**
 * Created by PhpStorm.
 * User: fintara
 * Date: 07/01/2017
 * Time: 22:58
 */

namespace AppBundle\Factory;


use AppBundle\Entity\Student;
use AppBundle\Entity\User;
use AppBundle\Entity\Worker;
use AppBundle\Exceptions\UnknownUserTypeException;

class UserFactory
{
    /**
     * @param string $type Worker or Student
     * @return User
     * @throws UnknownUserTypeException Thrown if user type is unknown
     */
    public function createUser(string $type): User
    {
        $clazz = $this->resolveClass($type);
        return new $clazz();
    }

    /**
     * @param string $type  Worker or Student
     * @return string       Class for user of this type
     * @throws UnknownUserTypeException Thrown if user type is unknown
     */
    public function resolveClass(string $type): string
    {
        if ($type === Student::TYPE) {
            return Student::class;
        } elseif ($type === Worker::TYPE) {
            return Worker::class;
        }

        throw new UnknownUserTypeException('Unknown user type "'.$type.'"');
    }
}