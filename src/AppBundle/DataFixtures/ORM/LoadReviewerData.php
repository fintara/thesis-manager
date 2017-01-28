<?php


namespace AppBundle\DataFixtures\ORM;


use AppBundle\Entity\Review;
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

        // teacher | thesis | review_grade
        $reviewers = [
            [0, 1],
            [0, 2, 4.5],
            [1, 2, 2.0],
        ];

        for($i = 0; $i < count($reviewers); $i++) {
            $this->assignReviewer($reviewers[$i]);

            if (count($reviewers[$i]) > 2) {
                $this->addReview($reviewers[$i]);
            }
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

    private function addReview(array $data)
    {
        /** @var Thesis $thesis */
        $thesis = $this->getReference('thesis-'.$data[1]);
        /** @var Worker $worker */
        $worker = $this->getReference('teacher-'.$data[0]);

        $review = new Review();
        $review->setFilename('dummy');
        $review->setReviewer($worker);
        $review->setThesis($thesis);
        $review->setTitle('Review');
        $review->setCreatedAt(new \DateTime());
        $review->setGrade($data[2]);

        $this->om->persist($review);
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