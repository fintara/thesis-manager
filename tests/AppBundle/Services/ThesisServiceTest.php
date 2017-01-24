<?php
/**
 * Created by PhpStorm.
 * User: fintara
 * Date: 24/01/2017
 * Time: 14:07
 */

namespace AppBundle\Services;


use AppBundle\Entity\Thesis;
use AppBundle\Entity\Worker;
use AppBundle\Repository\ThesisRepositoryInterface;

class ThesisServiceTest extends \PHPUnit_Framework_TestCase
{
    /** @var ThesisRepositoryInterface */
    private $thesisRepo;

    /** @var ThesisService */
    private $service;

    protected function setUp()
    {
        $this->thesisRepo = new class implements ThesisRepositoryInterface {

            public function findAllToReviewBy(Worker $worker): array
            {
                return [];
            }

            public function findAllSupervisedBy(Worker $worker): array
            {
                return [];
            }

            public function save(Thesis $thesis, bool $flush = true): Thesis
            {
                $thesis->setTitle($thesis->getTitle().'_saved');
                return $thesis;
            }
        };

        $this->service = new ThesisService($this->thesisRepo);
    }

    public function testAssignReviewer()
    {
        $thesis = new Thesis();
        $thesis->setTitle('Name');
        $reviewersCnt = $thesis->getReviewers()->count();

        $reviewer = new Worker();
        $reviewer->setEmail('reviewer@abc.bg');

        $this->service->assignReviewer($thesis, $reviewer);
        $this->assertEquals($reviewersCnt + 1, $thesis->getReviewers()->count());
    }

    public function testAssignFlush()
    {
        $thesis = new Thesis();
        $thesisName = 'Name';
        $thesis->setTitle($thesisName);
        $reviewersCnt = $thesis->getReviewers()->count();

        $reviewer = new Worker();
        $reviewer->setEmail('reviewer@abc.bg');

        $this->service->assignReviewer($thesis, $reviewer, true);
        $this->assertEquals($thesisName.'_saved', $thesis->getTitle());
    }

    public function testAssignNoFlush()
    {
        $thesis = new Thesis();
        $thesisName = 'Name';
        $thesis->setTitle($thesisName);
        $reviewersCnt = $thesis->getReviewers()->count();

        $reviewer = new Worker();
        $reviewer->setEmail('reviewer@abc.bg');

        $this->service->assignReviewer($thesis, $reviewer, false);
        $this->assertEquals($thesisName, $thesis->getTitle());
    }
}
