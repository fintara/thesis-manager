<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Draft
 *
 * @ORM\Table(name="draft")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DraftRepository")
 */
class Draft
{
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
     * @ORM\Column(name="filename", type="string", length=100)
     */
    private $filename;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="text")
     */
    private $comment;

    /**
     * @var int
     *
     * @ORM\Column(name="version", type="integer")
     */
    private $version;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var Student
     * @ORM\ManyToOne(targetEntity="Student")
     * @ORM\JoinColumn(name="student_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $student;

    /**
     * @var Thesis
     * @ORM\ManyToOne(targetEntity="Thesis", inversedBy="drafts")
     * @ORM\JoinColumn(name="thesis_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $thesis;

    /**
     * @var Feedback|null
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Feedback", mappedBy="draft")
     */
    private $feedback;

    /** @var null|UploadedFile */
    private $file;

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
     * Set filename
     *
     * @param string $filename
     *
     * @return Draft
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;

        return $this;
    }

    /**
     * Get filename
     *
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * @return string
     */
    public function getComment(): string
    {
        return $this->comment;
    }

    /**
     * @param string $comment
     */
    public function setComment(string $comment)
    {
        $this->comment = $comment;
    }

    /**
     * Set version
     *
     * @param integer $version
     *
     * @return Draft
     */
    public function setVersion($version)
    {
        $this->version = $version;

        return $this;
    }

    /**
     * Get version
     *
     * @return int
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @return Student
     */
    public function getStudent(): Student
    {
        return $this->student;
    }

    /**
     * @param Student $student
     */
    public function setStudent(Student $student)
    {
        $this->student = $student;
    }

    /**
     * @return Thesis
     */
    public function getThesis(): Thesis
    {
        return $this->thesis;
    }

    /**
     * @param Thesis $thesis
     */
    public function setThesis(Thesis $thesis)
    {
        $this->thesis = $thesis;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Draft
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @return Feedback|null
     */
    public function getFeedback()
    {
        return $this->feedback;
    }

    /**
     * @return null|UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param null|UploadedFile $file
     */
    public function setFile($file)
    {
        $this->file = $file;
    }
}

