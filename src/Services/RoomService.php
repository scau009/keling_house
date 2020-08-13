<?php


namespace App\Services;


use App\Document\Room;
use App\Repository\Builder\RoomQueryBuilder;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Component\HttpFoundation\Request;

class RoomService
{
    private DocumentManager $documentManager;

    public function __construct(DocumentManager $documentManager)
    {
        $this->documentManager = $documentManager;
    }

    public function getRoomsByRequest(Request $request)
    {
        /** @var RoomQueryBuilder $roomQueryBuilder */
        $roomQueryBuilder = $this->documentManager->getRepository(Room::class)->createQueryBuilder();
        $roomQueryBuilder->setByRequest($request);
        return $roomQueryBuilder->getQuery();
    }

    public function getRoomsCollectionInHouse(string $status = '')
    {
        if (!$status) {
            $rooms = $this->documentManager->getRepository(Room::class)->findAll();
        }else{
            $rooms = $this->documentManager->getRepository(Room::class)->findBy(['status'=>$status]);
        }
        $collection = [];
        /** @var Room $room */
        foreach ($rooms as $room) {
            if (!isset($collection[$room->getHouse()->getId()])) {
                $collection[$room->getHouse()->getId()][] = [];
            }
            $collection[$room->getHouse()->getId()][] = $room;
        }
        return $collection;
    }
}