<?php


namespace AppBundle\Repository;


interface TopicRepositoryInterface
{
    public function findByIdAndStatus(int $id, string $status);
    public function findByStatus(string $status);
}