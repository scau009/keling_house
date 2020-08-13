<?php


namespace App\Repository\Builder;


use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Query\Builder;
use Symfony\Component\HttpFoundation\Request;

class RoomQueryBuilder extends Builder
{
    public function __construct(DocumentManager $dm, $documentName = null)
    {
        parent::__construct($dm, $documentName);
    }

    public function setByRequest(Request $request)
    {
        if ($houseId = $request->get('houseId')) {
            $this->setHouseId($houseId);
        }
        if ($roomId = $request->get('roomId')) {
            $this->setRoomId($roomId);
        }
        if ($status = $request->get('status')) {
            $this->setStatus($status);
        }
        return $this;
    }

    private function setHouseId(string $houseId)
    {
        $this->field('house')->equals($houseId);
        return $this;
    }

    private function setRoomId(string $roomId)
    {
        $this->field('room')->equals($roomId);
        return $this;
    }

    private function setStatus(string $status)
    {
        $this->field('status')->equals($status);
        return $this;
    }
}