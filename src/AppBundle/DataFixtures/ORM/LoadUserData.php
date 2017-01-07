<?php
/**
 * Created by PhpStorm.
 * User: fintara
 * Date: 07/01/2017
 * Time: 23:38
 */

namespace AppBundle\DataFixtures\ORM;


use AppBundle\Entity\Student;
use AppBundle\Entity\Worker;
use AppBundle\Models\UserModel;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadUserData implements FixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $userService = $this->container->get('user.service');

        $student = new UserModel();
        $student->type = Student::TYPE;
        $student->email = 'abc@student.org';
        $student->password = '123';
        $student->firstName = 'John';
        $student->lastName = 'Doe';
        $student = $userService->create($student);
        $student->addRole('ROLE_STUDENT');

        $manager->persist($student);

        $dean = new UserModel();
        $dean->type = Worker::TYPE;
        $dean->email = 'abc@worker.org';
        $dean->password = '123';
        $dean->firstName = 'Bob';
        $dean->lastName = 'Marley';
        $dean = $userService->create($dean);
        $dean->addRole('ROLE_DEAN');

        $manager->persist($dean);

        $manager->flush();
    }

    /**
     * Sets the container.
     *
     * @param ContainerInterface|null $container A ContainerInterface instance or null
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}