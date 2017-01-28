<?php
/**
 * Created by PhpStorm.
 * User: fintara
 * Date: 24/01/2017
 * Time: 14:21
 */

namespace AppBundle\Services;


use AppBundle\Entity\Review;
use AppBundle\Entity\Thesis;
use AppBundle\Entity\Worker;
use AppBundle\Models\ReviewModel;
use AppBundle\Repository\ReviewRepositoryInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ReviewServiceTest extends \PHPUnit_Framework_TestCase
{
    /** @var ReviewRepositoryInterface */
    private $repo;

    /** @var  ReviewService */
    private $service;

    protected function setUp()
    {
        $this->repo = new class implements ReviewRepositoryInterface {

            public function save(Review $review, bool $flush = true): Review
            {
                return $review;
            }

            public function setDirectory($directory)
            {
                // TODO: Implement setDirectory() method.
            }
        };

        $this->service = new ReviewService($this->repo);
    }

    public function testCreateFromModel()
    {
        $reviewer = new Worker();

        $model = new ReviewModel();
        $model->file = new UploadedFile(__DIR__.'/ReviewServiceTest.php', '');
        $model->grade = 5.0;
        $model->reviewer = $reviewer;
        $model->title = 'Title';

        $obj = $this->service->create($model, false);
        $this->assertEquals($model->file, $obj->getFile());
        $this->assertEquals($model->title, $obj->getTitle());
        $this->assertEquals($model->grade, $obj->getGrade());
    }

    public function testAssignReview()
    {
        $thesis = new Thesis();
        $reviewsCnt = $thesis->getReviews()->count();

        $review = new Review();

        $this->service->assign($review, $thesis);
        $this->assertEquals($reviewsCnt + 1, $thesis->getReviews()->count());
    }
}
