<?php


namespace App\Controller\Api;


use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\SerializerInterface;

class BaseApiController extends AbstractController
{
    protected DocumentManager $documentManager;

    protected SerializerInterface $serializer;

    public function __construct(DocumentManager $documentManager,SerializerInterface $serializer)
    {
        $this->documentManager = $documentManager;
        $this->serializer = $serializer;
    }

}