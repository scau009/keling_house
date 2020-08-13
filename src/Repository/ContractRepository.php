<?php


namespace App\Repository;


use App\Repository\Builder\ContractQueryBuilder;
use Doctrine\ODM\MongoDB\Repository\DocumentRepository;

class ContractRepository extends DocumentRepository
{
    public function createQueryBuilder(): ContractQueryBuilder
    {
        return new ContractQueryBuilder($this->dm,$this->documentName);
    }
}