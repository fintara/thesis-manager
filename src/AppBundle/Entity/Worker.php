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
class Worker extends User
{
    /**
     * @var Topic[]
     *
     * @ORM\OneToMany(targetEntity="Topic",mappedBy="supervisor")
     */
    private $topics;

    /**
     * @return Topic[]
     */
    public function getTopics()
    {
        return $this->topics;
    }

    /**
     * @param Topic[] $topics
     */
    public function setTopics($topics)
    {
        $this->topics = $topics;
    }


}