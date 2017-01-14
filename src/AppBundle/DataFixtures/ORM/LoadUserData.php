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
use AppBundle\Services\UserService;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadUserData extends AbstractFixture
implements OrderedFixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var UserService
     */
    private $userService;

    /**
     * @var ObjectManager
     */
    private $om;


    public function load(ObjectManager $manager)
    {
        $this->om = $manager;
        $this->loadUsers();

        $manager->flush();
    }

    public function getOrder()
    {
        return 1;
    }

    private function loadUsers()
    {
        $this->userService = $this->container->get('user.service');

        $students = [
            ['abc@student.org', '123', 'John', 'Doe']
        ];
        for ($i = 0; $i < count($students); $i++) {
            $student = $this->createStudent(
                $students[$i][0],
                $students[$i][1],
                $students[$i][2],
                $students[$i][3]
            );

            $this->addReference('student-'.$i, $student);
        }

        $deans = [
            ['abc@dean.org', '123', 'Bob', 'Marley', ['ROLE_DEAN']]
        ];
        for ($i = 0; $i < count($deans); $i++) {
            $dean = $this->createWorker(
                $deans[$i][0],
                $deans[$i][1],
                $deans[$i][2],
                $deans[$i][3],
                $deans[$i][4]
            );

            $this->addReference('dean-'.$i, $dean);
        }

        $teachers = [
            ['abc@teacher.org', '123', 'Jane', 'Doe', ['ROLE_TEACHER']]
        ];
        for ($i = 0; $i < count($teachers); $i++) {
            $teacher = $this->createWorker(
                $teachers[$i][0],
                $teachers[$i][1],
                $teachers[$i][2],
                $teachers[$i][3],
                $teachers[$i][4]
            );

            $this->addReference('teacher-'.$i, $teacher);
        }
    }

    private function createStudent($email, $password, $firstName, $lastName)
    {
        $student = new UserModel();
        $student->type = Student::TYPE;
        $student->email = $email;
        $student->password = $password;
        $student->firstName = $firstName;
        $student->lastName = $lastName;
        $student = $this->userService->create($student);
        $student->addRole('ROLE_STUDENT');

        $this->om->persist($student);

        return $student;
    }

    private function createWorker($email, $password, $firstName, $lastName, array $roles)
    {
        $worker = new UserModel();
        $worker->type = Worker::TYPE;
        $worker->email = $email;
        $worker->password = $password;
        $worker->firstName = $firstName;
        $worker->lastName = $lastName;
        $worker = $this->userService->create($worker);
        $worker->addRole('ROLE_DEAN');

        $this->om->persist($worker);

        return $worker;
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}