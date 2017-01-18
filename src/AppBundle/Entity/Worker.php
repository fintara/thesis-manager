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
    const TYPE = 'worker';
  
    /**
     * @var Topic[]
     *
     * @ORM\OneToMany(targetEntity="Topic",mappedBy="supervisor")
     */
    private $topics;

    /**
     * @var array
     *
     * @ORM\Column(name="degrees", type="array")
     */
    private $degrees = [];
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
    public function canReview(Thesis $thesis)
    {
        return $thesis->getReviewers()->contains($this);
    }
    public function addDegree(string $degree): void
    {
        if (in_array($degree, $this->degrees)) {
            return;
        }

        $this->degrees[] = $degree;
    }

    public function removeDegree(string $degree): void
    {
        $idx = array_search($degree, $this->degrees);

        if ($idx === false) {
            return;
        }

        unset($this->degrees[$idx]);
    }

    public function getDegrees(): array
    {
        return $this->degrees;
    }
}