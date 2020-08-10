<?php


namespace App\Repository;


use App\Repository\Builder\RoomQueryBuilder;
use Doctrine\ODM\MongoDB\Repository\DocumentRepository;

class RoomRepository extends DocumentRepository
{
    public function createQueryBuilder(): RoomQueryBuilder
    {
        return new RoomQueryBuilder($this->dm,$this->documentName);
    }
}