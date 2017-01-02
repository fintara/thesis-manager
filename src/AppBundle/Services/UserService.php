<?php

namespace AppBundle\Services;

use AppBundle\Entity\User;
use AppBundle\Models\UserModel;
use AppBundle\Repository\UserRepository;

class UserService
{

    private $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(UserModel $model): User
    {
        $user = new User();

        $user->setEmail($model->email);
        $user->setPlainPassword($model->password);
        $user->setFirstName($model->firstName);
        $user->setLastName($model->lastName);

        // hash password here

        $user = $this->repository->save($user);

        return $user;
    }

}
