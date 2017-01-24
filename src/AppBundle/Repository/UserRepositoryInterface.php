<?php
/**
 * Created by PhpStorm.
 * User: fintara
 * Date: 24/01/2017
 * Time: 14:35
 */

namespace AppBundle\Repository;


use AppBundle\Entity\User;

interface UserRepositoryInterface
{
    public function findByType(string $type): array;
    public function save(User $user): User;
}