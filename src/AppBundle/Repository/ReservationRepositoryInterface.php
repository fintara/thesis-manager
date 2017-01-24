<?php


namespace AppBundle\Repository;


use AppBundle\Entity\Reservation;

interface ReservationRepositoryInterface
{
    public function save(Reservation $reservation, bool $flush = true);
}