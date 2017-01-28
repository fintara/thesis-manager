<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Reservation;

/**
 * Interface ReservationRepositoryInterface
 * @package AppBundle\Repository
 */
interface ReservationRepositoryInterface
{
    /**
     * @param  Reservation $reservation Reservation to be saved
     * @param  bool $flush              Whether to immediately save to database
     * @return Reservation
     */
    public function save(Reservation $reservation, bool $flush = true): Reservation;
}