<?php


namespace AppBundle\DataFixtures\ORM;


use AppBundle\Entity\Draft;
use AppBundle\Entity\Review;
use AppBundle\Entity\Student;
use AppBundle\Entity\Thesis;
use AppBundle\Entity\Worker;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class LoadDraftsData extends AbstractFixture
    implements OrderedFixtureInterface, ContainerAwareInterface
{
    use ContainerAwareTrait;
    /**
     * @var ObjectManager
     */
    private $om;

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $this->om = $manager;

        $drafts = [
            ['thesis' => 1, 'ver' => 1, 'student' => 2, 'date' => new \DateTime('-3 days')],
            ['thesis' => 2, 'ver' => 1, 'student' => 3, 'date' => new \DateTime('-1 hour')],
        ];

        for($i = 0; $i < count($drafts); $i++) {
            $this->addDraft($drafts[$i]);
        }

        $this->om->flush();
    }

    private function addDraft(array $data)
    {
        /** @var Thesis $thesis */
        $thesis = $this->getReference('thesis-'.$data['thesis']);

        /** @var Student $student */
        $student = $this->getReference('student-'.$data['student']);

        $draft = new Draft();
        $draft->setCreatedAt($data['date']);
        $draft->setStudent($student);
        $draft->setThesis($thesis);
        $draft->setComment('Dummy');
        $draft->setFilename('dummy');
        $draft->setVersion($data['ver']);

        $thesis->addDraft($draft);

        $this->om->persist($draft);
        $this->om->persist($thesis);
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 5;
    }
}