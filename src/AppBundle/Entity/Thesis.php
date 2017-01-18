<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Thesis
 *
 * @ORM\Table(name="thesis")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ThesisRepository")
 */
class Thesis
{
    const STATUS_DRAFT = 'draft';
    const STATUS_FINAL = 'final';
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=200)
     */
    private $title;

    /**
     * @var Topic
     *
     * @ORM\ManyToOne(targetEntity="Topic")
     * @ORM\JoinColumn(name="topic_id",referencedColumnName="id")
     */
    private $topic;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=50)
     */
    private $status;
    /**
     * @var Student[]|ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Student", mappedBy="theses", cascade={"all"})
     */
    private $students;

    /**
     * @var Review[]|ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Review")
     */
    private $reviews;

    /**
     * @var Worker[]|ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Worker")
     */
    private $reviewers;

    public function __construct()
    {
        $this->status = self::STATUS_DRAFT;
        $this->students = new ArrayCollection();
        $this->reviews = new ArrayCollection();
        $this->reviewers = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Thesis
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return Topic
     */
    public function getTopic()
    {
        return $this->topic;
    }

    /**
     * @param Topic $topic
     */
    public function setTopic($topic)
    {
        $this->topic = $topic;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status)
    {
        $this->status = $status;
    }

    /**
     * @return Student[]|ArrayCollection
     */
    public function getStudents()
    {
        return $this->students;
    }

    public function addStudent(Student $student)
    {
        $this->students->add($student);
    }

    /**
     * @return Review[]|ArrayCollection
     */
    public function getReviews()
    {
        return $this->reviews;
    }

    public function addReview(Review $review)
    {
        $this->reviews->add($review);
    }

    /**
     * @return Worker[]|ArrayCollection
     */
    public function getReviewers()
    {
        return $this->reviewers;
    }

    public function addReviewer(Worker $worker)
    {
        $this->reviewers->add($worker);
    }

    public function getSupervisor()
    {
        return $this->topic->getSupervisor();
    }
}

