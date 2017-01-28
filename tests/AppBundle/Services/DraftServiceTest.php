<?php
/**
 * Created by PhpStorm.
 * User: fintara
 * Date: 26/01/2017
 * Time: 12:01
 */

namespace AppBundle\Services;


use AppBundle\Entity\Draft;
use AppBundle\Entity\Student;
use AppBundle\Entity\Thesis;
use AppBundle\Models\DraftModel;
use AppBundle\Repository\DraftRepositoryInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class DraftServiceTest extends \PHPUnit_Framework_TestCase
{
    /** @var  DraftRepositoryInterface */
    private $repo;

    /** @var DraftService */
    private $service;

    protected function setUp()
    {
        $this->repo = new class implements DraftRepositoryInterface {

            /**
             * Returns the number version of last uploaded draft or 0.
             *
             * @param  Thesis $thesis Thesis which drafts will be taken into account
             * @return int The last draft's version or 0 if none uploaded so far.
             */
            public function findLastVersion(Thesis $thesis): int
            {
                return 5;
            }

            /**
             * Returns list of drafts ordered by version (newest on top).
             *
             * @param  Thesis $thesis Thesis which drafts will be taken into account
             * @return array List of drafts
             */
            public function findNewest(Thesis $thesis): array
            {
                return [];
            }

            /**
             * Saves and uploads the draft.
             *
             * @param  Draft $draft Draft to be saved
             * @param  bool $flush Whether to immediately save to database
             * @return Draft
             */
            public function save(Draft $draft, bool $flush = true): Draft
            {
                return $draft;
            }

            /**
             * @param string $directory Directory where draft files are saved.
             */
            public function setDirectory(string $directory): void
            {
                // TODO: Implement setDirectory() method.
            }
        };

        $this->service = new DraftService($this->repo);
    }

    public function testCreateDraft()
    {
        $model = new DraftModel();
        $model->comment = 'Test comment';
        $model->file = new UploadedFile(__DIR__.'/../../dummy_file.zip', '');
        $model->student = new Student();
        $model->thesis = new Thesis();

        $obj = $this->service->create($model);

        $this->assertEquals(6, $obj->getVersion());
    }
}
