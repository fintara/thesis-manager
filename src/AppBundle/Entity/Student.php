<?php
/**
 * Created by PhpStorm.
 * User: fintara
 * Date: 07/01/2017
 * Time: 15:19
 */

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Student extends User
{
    const TYPE = 'student';


    /**
     * @var Thesis[]|ArrayCollection
     * @ORM\ManyToMany(targetEntity="Thesis", mappedBy="students")
     */
    private $theses;

    /**
     * @var Reservation[]
     * @ORM\OneToMany(targetEntity="Reservation", mappedBy="student")
     */
    private $reservations;

    public function __construct()
    {
        parent::__construct();

        $this->theses = new ArrayCollection();
        $this->reservations = new ArrayCollection();
    }

    /**
     * @return Thesis[]|ArrayCollection
     */
    public function getTheses()
    {
        return $this->theses;
    }

    public function addThesis(Thesis $thesis)
    {
        $this->theses->add($thesis);
    }
}