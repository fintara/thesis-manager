<?php
/**
 * Created by PhpStorm.
 * User: fintara
 * Date: 07/01/2017
 * Time: 15:19
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Student extends User
{

    /**
     * @var Thesis[]
     * @ORM\ManyToMany(targetEntity="Thesis", inversedBy="students")
     * @ORM\JoinTable(name="students_theses")
     */
    private $theses;

    /**
     * @var Reservation[]
     * @ORM\OneToMany(targetEntity="Reservation", mappedBy="student")
     */
    private $reservations;
}