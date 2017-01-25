<?php
/**
 * Created by PhpStorm.
 * User: fintara
 * Date: 25/01/2017
 * Time: 16:23
 */

namespace AppBundle\Security\Voters;


use AppBundle\Entity\Student;
use AppBundle\Entity\Thesis;
use AppBundle\Entity\Topic;
use AppBundle\Entity\User;
use AppBundle\Entity\Worker;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\Role\RoleInterface;

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

        $token = $this->createMock(TokenInterface::class);
        $token->method('getUser')->willReturn($student);

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

        $token = $this->createMock(TokenInterface::class);
        $token->method('getUser')->willReturn($studentOther);

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

        $token = $this->createMock(TokenInterface::class);
        $token->method('getUser')->willReturn($supervisor);

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

        $token = $this->createMock(TokenInterface::class);
        $token->method('getUser')->willReturn($worker);

        $thesis = new Thesis();
        $thesis->setTopic($topic);

        $attributes = [ThesisVoter::VIEW_DRAFTS];

        $voterOutcome = $this->voter->vote($token, $thesis, $attributes);
        $this->assertEquals(VoterInterface::ACCESS_DENIED, $voterOutcome);
    }


}
