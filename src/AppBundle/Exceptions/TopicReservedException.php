<?php

namespace AppBundle\Exceptions;

use Exception;

class TopicReservedException extends \Exception
{
    public function __construct($message = "", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
