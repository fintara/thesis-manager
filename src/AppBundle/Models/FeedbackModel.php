<?php

namespace AppBundle\Models;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

class FeedbackModel
{

    /**
     * @var UploadedFile
     *
     * @Assert\File(maxSize="512000000")
     */
    public $file;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     */
    public $comment;

    public $draft;
    public $supervisor;

}