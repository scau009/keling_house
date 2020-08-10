<?php


namespace App\Repository;


use App\Repository\Builder\HouseQueryBuilder;
use Doctrine\ODM\MongoDB\Repository\DocumentRepository;

class HouseRepository extends DocumentRepository
{
    public function createQueryBuilder(): HouseQueryBuilder
    {
        return new HouseQueryBuilder($this->dm, $this->documentName);
    }
}