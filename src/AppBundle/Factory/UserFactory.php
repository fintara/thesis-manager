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

/**
 * User factory
 *
 * @package AppBundle\Factory
 */
class UserFactory
{
    /**
     * Creates an instance of provided user type.
     *
     * @param   string $type Type of user to be created
     * @return  User
     * @throws  UnknownUserTypeException Thrown if user type is unknown
     */
    public function createUser(string $type): User
    {
        $clazz = $this->resolveClass($type);
        return new $clazz();
    }

    /**
     * Provides class name of provided user type.
     *
     * @param   string $type    Type of user
     * @return  string
     * @throws  UnknownUserTypeException Thrown if user type is unknown
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