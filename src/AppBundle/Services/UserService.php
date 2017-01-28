<?php

namespace AppBundle\Services;

use AppBundle\Entity\User;
use AppBundle\Factory\UserFactory;
use AppBundle\Models\UserModel;
use AppBundle\Repository\UserRepositoryInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * User service
 * @package AppBundle\Services
 */
class UserService
{
    /** @var UserRepositoryInterface Repository for user */
    private $repository;

    /** @var UserFactory */
    private $factory;

    /** @var UserPasswordEncoderInterface  */
    private $passwordEncoder;


    /**
     * UserService constructor.
     * @param UserRepositoryInterface $repository
     * @param UserFactory $factory
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(UserRepositoryInterface $repository,
                                UserFactory $factory,
                                UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->repository = $repository;
        $this->factory    = $factory;
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * Creates and saves a user.
     *
     * @param UserModel $model  Initial data
     * @param bool      $save   Whether to immediately save to database
     * @return User             Saved user
     */
    public function create(UserModel $model, $save = false): User
    {
        $user = $this->factory->createUser($model->type);

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
