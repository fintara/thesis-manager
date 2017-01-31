<?php
/**
 * Created by PhpStorm.
 * User: fintara
 * Date: 31/01/2017
 * Time: 15:55
 */

namespace AppBundle\Factory;


use AppBundle\Entity\User;

interface UserFactoryInterface
{
    public function createUser(string $type): User;
    public function resolveClass(string $type): string;
}