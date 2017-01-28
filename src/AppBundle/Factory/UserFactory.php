<?php
/**
 * Created by PhpStorm.
 * User: fintara
 * Date: 07/01/2017
 * Time: 22:58
 */

namespace AppBundle\Factory;


use AppBundle\Entity\Student;
use AppBundle\Entity\Worker;
use AppBundle\Exceptions\UnknownUserTypeException;

class UserFactory
{
    public function createUser(string $type)
    {
        $clazz = $this->resolveClass($type);
        return new $clazz();
    }

    public function resolveClass(string $type)
    {
        if ($type === Student::TYPE) {
            return Student::class;
        } elseif ($type === Worker::TYPE) {
            return Worker::class;
        }

        throw new UnknownUserTypeException('Unknown user type "'.$type.'"');
    }
}