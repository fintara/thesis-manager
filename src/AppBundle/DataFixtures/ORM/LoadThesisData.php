<?php
/**
 * Created by PhpStorm.
 * User: fintara
 * Date: 17/01/2017
 * Time: 15:46
 */

namespace AppBundle\DataFixtures\ORM;


use AppBundle\Entity\Student;
use AppBundle\Entity\Thesis;
use AppBundle\Entity\Topic;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class LoadThesisData extends AbstractFixture
implements OrderedFixtureInterface, ContainerAwareInterface
{
    use ContainerAwareTrait;
    /**
     * @var ObjectManager
     */
    private $om;

    public function load(ObjectManager $manager)
    {
        $this->om = $manager;

        $theses = [
            [Thesis::STATUS_DRAFT, 1, 0],
            [Thesis::STATUS_FINAL, 0, 1],
            [Thesis::STATUS_FINAL, 13, 2],
            [Thesis::STATUS_FINAL, 5, 3],
            [Thesis::STATUS_FINAL, 22, 4],
            [Thesis::STATUS_FINAL, 30, 5],
        ];

        for($i = 0; $i < count($theses); $i++) {
            $thesis = $this->createThesis($theses[$i]);
        }

        $this->om->flush();
    }

    protected function createThesis(array $data): Thesis
    {
        $t = new Thesis();

        /** @var Topic $topic */
        $topic = $this->getReference('topic-'.$data[1]);

        /** @var Student $student */
        $student = $this->getReference('student-'.$data[2]);

        $t->setTopic($topic);
        $t->setTitle($topic->getTitle());
        $t->setStatus($data[0]);
        $t->addStudent($student);

        $student->addThesis($t);

        $this->om->persist($t);
        $this->om->persist($student);

        return $t;
    }

    public function getOrder()
    {
        return 3;
    }
}