<?php
/**
 * Created by PhpStorm.
 * User: Mauri
 * Date: 17-Jan-17
 * Time: 14:06
 */

namespace AppBundle\Models;


final class Degree
{
    public const PHD = 'phd';
    public const BACHELOR = 'bachelor';
    public const MASTER = 'master';
    public const DOCTOR = 'doc';
    public const JURIS_DOCTOR = 'jdoc';

    private function __construct()
    {
    }
}