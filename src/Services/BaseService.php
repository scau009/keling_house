<?php


namespace App\Services;


use Doctrine\ODM\MongoDB\DocumentManager;

class BaseService
{
    protected DocumentManager $documentManager;

    public function __construct(DocumentManager $documentManager)
    {
        $this->documentManager = $documentManager;
    }

}