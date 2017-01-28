<?php
/**
 * Created by PhpStorm.
 * User: fintara
 * Date: 24/01/2017
 * Time: 14:35
 */

namespace AppBundle\Repository;


use AppBundle\Entity\User;

/**
 * Interface UserRepositoryInterface
 * @package AppBundle\Repository
 */
interface UserRepositoryInterface
{
    /**
     * Returns a list of users with provided type
     * @param  string $type Worker or Student
     * @return User[]
     */
    public function findByType(string $type): array;

    /**
     * Saves a user
     * @param User $user    User to be saved
     * @return User         Saved user
     */
    public function save(User $user): User;
}