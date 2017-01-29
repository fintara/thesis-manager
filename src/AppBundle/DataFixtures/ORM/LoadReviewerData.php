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
            ['thesis' => 6, 'teacher' => 2, 'grade' => 2.0],
            ['thesis' => 6, 'teacher' => 3, 'grade' => 3.0],
            ['thesis' => 7, 'teacher' => 3, 'grade' => null],
            ['thesis' => 7, 'teacher' => 4, 'grade' => null],
        ];

        for($i = 0; $i < count($reviewers); $i++) {
            $this->assignReviewer($reviewers[$i]);

            if ($reviewers[$i]['grade'] !== null) {
                $this->addReview($reviewers[$i]);
            }
        }

        $this->om->flush();
    }

    private function assignReviewer(array $data)
    {
        /** @var Thesis $thesis */
        $thesis = $this->getReference('thesis-'.$data['thesis']);
        /** @var Worker $worker */
        $worker = $this->getReference('teacher-'.$data['teacher']);

        $thesis->addReviewer($worker);

        $this->om->persist($thesis);
    }

    private function addReview(array $data)
    {
        /** @var Thesis $thesis */
        $thesis = $this->getReference('thesis-'.$data['thesis']);
        /** @var Worker $worker */
        $worker = $this->getReference('teacher-'.$data['teacher']);

        $review = new Review();
        $review->setFilename('dummy');
        $review->setReviewer($worker);
        $review->setThesis($thesis);
        $review->setTitle('Review');
        $review->setCreatedAt(new \DateTime());
        $review->setGrade($data['grade']);

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