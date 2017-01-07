<?php

namespace AppBundle\Services;

use AppBundle\Entity\User;
use AppBundle\Factory\UserFactory;
use AppBundle\Models\UserModel;
use AppBundle\Repository\UserRepository;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserService
{

    private $repository;

    private $factory;

    private $passwordEncoder;

    public function __construct(UserRepository $repository, UserFactory $factory, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->repository = $repository;
        $this->factory    = $factory;
        $this->passwordEncoder = $passwordEncoder;
    }

    public function create(UserModel $model, $save = false): User
    {
        $user = $this->factory->getUser($model->type);

        $user->setEmail($model->email);
        $user->setFirstName($model->firstName);
        $user->setLastName($model->lastName);

        $password = $this->passwordEncoder->encodePassword($user, $model->password);
        $user->setPassword($password);

        if ($save) {
            $user = $this->repository->save($user);
        }

        return $user;
    }

}
