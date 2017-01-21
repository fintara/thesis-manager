<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * topic
 *
 * @ORM\Table(name="topic")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TopicRepository")
 */
class Topic
{
    const STATUS_PENDING = 'pending';
    const STATUS_NEW = 'new';
    const STATUS_APPROVED = 'approved';
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
     * @ORM\Column(name="title", type="string", length=150)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255)
     */
    private $status;

    /**
     * @var Worker
     *
     * @ORM\ManyToOne(targetEntity="Worker", inversedBy="topics")
     * @ORM\JoinColumn(name="supervisor_id", referencedColumnName="id", onDelete="CASCADE")
     *
     */
    private $supervisor;

    /**
     * @var Reservation[]|ArrayCollection
     * @ORM\OneToMany(targetEntity="Reservation", mappedBy="topic")
     */
    private $reservations;

    public static function getStatuses()
    {
        return [
            self::STATUS_APPROVED,
            self::STATUS_NEW,
            self::STATUS_PENDING,
        ];
    }

    public function __construct()
    {
        $this->status = self::STATUS_NEW;
        $this->reservations = new ArrayCollection();
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
     * @return Topic
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
     * Set status
     *
     * @param string $status
     *
     * @return Topic
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return Worker
     */
    public function getSupervisor(): Worker
    {
        return $this->supervisor;
    }

    /**
     * @param Worker $supervisor
     */
    public function setSupervisor(Worker $supervisor = null)
    {
        $this->supervisor = $supervisor;
    }

    /**
     * @return Reservation[]|ArrayCollection
     */
    public function getReservations()
    {
        return $this->reservations;
    }

    /**
     * @param Student $student
     * @return bool|Reservation
     */
    public function getReservationFor(Student $student)
    {
        return $this->reservations->filter(function ($reservation) use ($student) {
            /** @var Reservation $reservation */
            return $reservation->getStudent() === $student;
        })->first();
    }

    public function isReservedFor(Student $student): bool
    {
        return $this->getReservationFor($student) !== false;
    }

    public function addReservation(Reservation $reservation)
    {
        $this->reservations->add($reservation);
    }

}

