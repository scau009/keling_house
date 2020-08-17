<?php


namespace App\Repository;


use App\Document\Room;
use App\Repository\Builder\OrderQueryBuilder;
use Doctrine\ODM\MongoDB\Repository\DocumentRepository;

class OrderRepository extends DocumentRepository
{
    public function createQueryBuilder(): OrderQueryBuilder
    {
        return new OrderQueryBuilder($this->dm, $this->documentName);
    }
}