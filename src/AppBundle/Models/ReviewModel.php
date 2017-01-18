<?php

namespace AppBundle\Models;

use Symfony\Component\Validator\Constraints as Assert;

class ReviewModel
{

    public $file;

    /**
     * @var string
     *
     * @Assert\NotEqualTo(value="test")
     */
    public $title;
    public $grade;
    public $reviewer;

}