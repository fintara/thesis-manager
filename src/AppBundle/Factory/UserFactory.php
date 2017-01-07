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

class UserFactory
{
    public function getUser(string $type)
    {
        if ($type === Student::TYPE) {
            return new Student();
        } elseif ($type === Worker::TYPE) {
            return new Worker();
        }

        throw new \Exception('Unknown user type "'.$type.'"');
    }
}