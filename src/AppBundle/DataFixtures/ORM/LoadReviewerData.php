<?php


namespace AppBundle\DataFixtures\ORM;


use AppBundle\Entity\Thesis;
use AppBundle\Entity\Worker;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class LoadReviewerData extends AbstractFixture
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

        // teacher | thesis
        $reviewers = [
            [0, 1],
        ];

        for($i = 0; $i < count($reviewers); $i++) {
            $this->assignReviewer($reviewers[$i]);
        }

        $this->om->flush();
    }

    private function assignReviewer(array $data)
    {
        /** @var Thesis $thesis */
        $thesis = $this->getReference('thesis-'.$data[1]);
        /** @var Worker $worker */
        $worker = $this->getReference('teacher-'.$data[0]);

        $thesis->addReviewer($worker);

        $this->om->persist($thesis);
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 4;
    }
}