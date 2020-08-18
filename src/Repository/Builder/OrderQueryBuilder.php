<?php


namespace App\Repository\Builder;


use App\Document\Order;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Query\Builder;
use Symfony\Component\HttpFoundation\Request;

class OrderQueryBuilder extends Builder
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
            $this->field('status')->notEqual(Order::STATUS_DELETED);
        }
        if ($houseId = $request->get('houseId')) {
            $this->setHouseId($houseId);
        }
        if ($roomId = $request->get('roomId')) {
            $this->setRoomId($roomId);
        }

        if ($orderId = $request->get('orderId')) {
            $this->setId($orderId);
        }

        return $this;
    }

    private function setId(string $id)
    {
        $this->field('id')->equals($id);
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