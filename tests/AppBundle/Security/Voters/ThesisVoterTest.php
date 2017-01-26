<?php
/**
 * Created by PhpStorm.
 * User: fintara
 * Date: 25/01/2017
 * Time: 16:23
 */

namespace AppBundle\Security\Voters;


use AppBundle\Entity\Draft;
use AppBundle\Entity\Student;
use AppBundle\Entity\Thesis;
use AppBundle\Entity\Topic;
use AppBundle\Entity\User;
use AppBundle\Entity\Worker;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;

class ThesisVoterTest extends \PHPUnit_Framework_TestCase
{
    /** @var ThesisVoter */
    private $voter;

    protected function setUp()
    {
        $this->voter = new ThesisVoter();
    }

    public function testStudentCanViewDraftsOfTheirThesis()
    {
        $student = new Student();

        $token = $this->getTokenMock($student);

        $thesis = new Thesis();
        $thesis->addStudent($student);

        $attributes = [ThesisVoter::VIEW_DRAFTS];

        $voterOutcome = $this->voter->vote($token, $thesis, $attributes);
        $this->assertEquals(VoterInterface::ACCESS_GRANTED, $voterOutcome);
    }

    public function testStudentCannotViewDraftsOfOthersThesis()
    {
        $studentOwner = new Student();
        $studentOwner->setEmail('owner@abv.bg');

        $studentOther = new Student();
        $studentOther->setEmail('other@abv.bg');

        $token = $this->getTokenMock($studentOther);

        $thesis = new Thesis();
        $thesis->addStudent($studentOwner);

        $attributes = [ThesisVoter::VIEW_DRAFTS];

        $voterOutcome = $this->voter->vote($token, $thesis, $attributes);
        $this->assertEquals(VoterInterface::ACCESS_DENIED, $voterOutcome);
    }

    public function testSupervisorCanViewDraftsOfSupervisedThesis()
    {
        $supervisor = new Worker();
        $topic = new Topic();
        $topic->setSupervisor($supervisor);

        $token = $this->getTokenMock($supervisor);

        $thesis = new Thesis();
        $thesis->setTopic($topic);

        $attributes = [ThesisVoter::VIEW_DRAFTS];

        $voterOutcome = $this->voter->vote($token, $thesis, $attributes);
        $this->assertEquals(VoterInterface::ACCESS_GRANTED, $voterOutcome);
    }

    public function testWorkersCannotViewDraftsOfTheses()
    {
        $worker = new Worker();
        $worker->setEmail('worker@abv.bg');

        $supervisor = new Worker();
        $supervisor->setEmail('sv@abv.bg');
        $topic = new Topic();
        $topic->setSupervisor($supervisor);

        $token = $this->getTokenMock($worker);

        $thesis = new Thesis();
        $thesis->setTopic($topic);

        $attributes = [ThesisVoter::VIEW_DRAFTS];

        $voterOutcome = $this->voter->vote($token, $thesis, $attributes);
        $this->assertEquals(VoterInterface::ACCESS_DENIED, $voterOutcome);
    }

    public function testStudentCanUploadDraftOnce()
    {
        $student = new Student();

        $token = $this->getTokenMock($student);

        $thesis = new Thesis();
        $thesis->addStudent($student);

        $draft = new Draft();
        $draft->setStudent($student);
        $draft->setCreatedAt(new \DateTime());

        $attributes = [ThesisVoter::UPLOAD_DRAFT];

        $voterOutcome = $this->voter->vote($token, $thesis, $attributes);
        $this->assertEquals(VoterInterface::ACCESS_GRANTED, $voterOutcome);
    }

    public function testStudentCanUploadDraftAfter24h()
    {
        $student = new Student();

        $token = $this->getTokenMock($student);

        $thesis = new Thesis();
        $thesis->addStudent($student);

        $draft = new Draft();
        $draft->setStudent($student);
        $draft->setCreatedAt(new \DateTime('-1 days'));

        $attributes = [ThesisVoter::UPLOAD_DRAFT];

        $thesis->addDraft($draft);

        $voterOutcome = $this->voter->vote($token, $thesis, $attributes);
        $this->assertEquals(VoterInterface::ACCESS_GRANTED, $voterOutcome);
    }

    public function testStudentCannotUploadDraftTwiceIn24h()
    {
        $student = new Student();

        $token = $this->getTokenMock($student);

        $thesis = new Thesis();
        $thesis->addStudent($student);

        $draft = new Draft();
        $draft->setStudent($student);
        $draft->setCreatedAt(new \DateTime());

        $attributes = [ThesisVoter::UPLOAD_DRAFT];

        $thesis->addDraft($draft);

        $voterOutcome = $this->voter->vote($token, $thesis, $attributes);
        $this->assertEquals(VoterInterface::ACCESS_DENIED, $voterOutcome);
    }

    public function testOnlyReviewerCanReviewThesis()
    {
        $worker = new Worker();
        $worker->setEmail('abc@worker.bg');
        $worker->addRole('ROLE_TEACHER');

        $token = $this->getTokenMock($worker);

        $thesis = new Thesis();
        $thesis->addReviewer($worker);

        $attributes = [ThesisVoter::ADD_REVIEW];

        $voterOutcome = $this->voter->vote($token, $thesis, $attributes);
        $this->assertEquals(VoterInterface::ACCESS_GRANTED, $voterOutcome);
    }

    public function testOrdinaryTeacherCannotReviewThesis()
    {
        $workerA = new Worker();
        $workerA->setEmail('abc@worker.bg');
        $workerA->addRole('ROLE_TEACHER');
        $workerB = new Worker();
        $workerB->setEmail('def@worker.bg');
        $workerB->addRole('ROLE_TEACHER');

        $token = $this->getTokenMock($workerA);

        $thesis = new Thesis();
        $thesis->addReviewer($workerB);

        $attributes = [ThesisVoter::ADD_REVIEW];

        $voterOutcome = $this->voter->vote($token, $thesis, $attributes);
        $this->assertEquals(VoterInterface::ACCESS_DENIED, $voterOutcome);
    }

    private function getTokenMock(User $user): TokenInterface
    {
        $token = $this->createMock(TokenInterface::class);
        $token->method('getUser')->willReturn($user);
        return $token;
    }
}
