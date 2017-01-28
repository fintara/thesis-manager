<?php

namespace AppBundle\Models;

class UserModel
{
    /** @var string Valid email */
    public $email;

    /** @var string Password */
    public $password;

    /** @var string First name */
    public $firstName;

    /** @var string Last name */
    public $lastName;

    /** @var string User type */
    public $type;

}