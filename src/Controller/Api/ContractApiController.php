<?php


namespace App\Controller\Api;

use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class ContractApiController
 * @package App\Controller\Api
 * @Route(path="/api/contract")
 */
class ContractApiController extends BaseApiController
{
    public function __construct(DocumentManager $documentManager, SerializerInterface $serializer)
    {
        parent::__construct($documentManager, $serializer);
    }

    // todo
    public function closeContract()
    {

    }
}