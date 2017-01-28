<?php
/**
 * Created by PhpStorm.
 * User: fintara
 * Date: 24/01/2017
 * Time: 14:34
 */

namespace AppBundle\Repository;

use AppBundle\Entity\Draft;
use AppBundle\Entity\Thesis;

/**
 * Interface DraftRepositoryInterface
 * @package AppBundle\Repository
 */
interface DraftRepositoryInterface
{
    /**
     * Returns the number version of last uploaded draft or 0.
     *
     * @param  Thesis $thesis Thesis which drafts will be taken into account
     * @return int The last draft's version or 0 if none uploaded so far.
     */
    public function findLastVersion(Thesis $thesis): int;

    /**
     * Returns list of drafts ordered by version (newest on top).
     *
     * @param  Thesis $thesis Thesis which drafts will be taken into account
     * @return array List of drafts
     */
    public function findNewest(Thesis $thesis): array;

    /**
     * Saves and uploads the draft.
     *
     * @param  Draft $draft Draft to be saved
     * @param  bool $flush  Whether to immediately save to database
     * @return Draft
     */
    public function save(Draft $draft, bool $flush = true): Draft;

    /**
     * @param string $directory Directory where draft files are saved.
     */
    public function setDirectory(string $directory): void;
}