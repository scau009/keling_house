<?php


namespace App\Repository\Builder;


use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Query\Builder;
use Symfony\Component\HttpFoundation\Request;

class ContractQueryBuilder extends Builder
{
    public function __construct(DocumentManager $dm, $documentName = null)
    {
        parent::__construct($dm, $documentName);
    }

    public function setByRequest(Request $request)
    {
        return $this;
    }
}