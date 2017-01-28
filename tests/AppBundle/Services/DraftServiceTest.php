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
        $this->repo = $this->createMock(DraftRepositoryInterface::class);
        $this->repo->method('findLastVersion')->willReturn(5);
        
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
