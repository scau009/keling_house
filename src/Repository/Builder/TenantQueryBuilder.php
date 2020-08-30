<?php


namespace App\Repository\Builder;


use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Query\Builder;
use Symfony\Component\HttpFoundation\Request;

class TenantQueryBuilder extends Builder
{
    public function __construct(DocumentManager $dm, $documentName = null)
    {
        parent::__construct($dm, $documentName);
    }

    public function setByRequest(Request $request)
    {
        if ($status = $request->get('status')) {
            $this->setStatus($status);
        }else{
            $this->field('status')->notEqual('deleted');
        }
        return $this;
    }

    public function setStatus(string $status)
    {
        $this->field('status')->equals($status);
        return $this;
    }
}