<?php

namespace AppBundle\Models;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

class ReviewModel
{

    /**
     * @var UploadedFile
     *
     * @Assert\NotNull()
     * @Assert\File(maxSize="51200000")
     */
    public $file;

    /**
     * @var string
     *
     * @Assert\Length(max="150")
     */
    public $title;

    /**
     * @var float
     *
     * @Assert\Choice(choices={2.0, 3.0, 3.5, 4.0, 4.5, 5.0, 5.5})
     */
    public $grade;

    public $reviewer;

}