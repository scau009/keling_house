<?php


namespace App\Repository;


use App\Repository\Builder\RoomQueryBuilder;
use App\Repository\Builder\TenantQueryBuilder;
use Doctrine\ODM\MongoDB\Repository\DocumentRepository;

class TenantRepository extends DocumentRepository
{
    public function createQueryBuilder(): TenantQueryBuilder
    {
        return new TenantQueryBuilder($this->dm,$this->documentName);
    }
}