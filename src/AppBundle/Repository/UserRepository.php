<?php

namespace AppBundle\Repository;

use AppBundle\Entity\User;
use AppBundle\Factory\UserFactory;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping;

class UserRepository extends EntityRepository implements UserRepositoryInterface
{
    /** @var UserFactory */
    private $userFactory;

    public function findByType(string $type): array
    {
        return $this->getEntityManager()->getRepository(
            $this->userFactory->getClass($type)
        )->findAll();
    }

    public function save(User $user): User
    {
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();

        return $user;
    }

    public function setUserFactory(UserFactory $userFactory)
    {
        $this->userFactory = $userFactory;
    }
}
