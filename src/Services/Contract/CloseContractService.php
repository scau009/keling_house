<?php


namespace App\Services\Contract;


use App\Document\Contract;
use App\Document\Room;
use App\Document\Tenant;
use App\Services\BaseService;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class CloseContractService extends BaseService
{
    public function close(Contract $contract)
    {
        $this->check($contract);
        $contract->setStatus(Contract::STATUS_FINISHED);
        $room = $contract->getRoom();
        $room->setStatus(Room::STATUS_OPEN);
        $this->resetTenant($contract);
        $this->resetResidents($contract);
        $this->documentManager->persist($contract);
        $this->documentManager->flush();
        return $contract;
    }

    private function resetTenant(Contract $contract)
    {
        $room = $contract->getRoom();
        $room->setTenant(null);
        $this->documentManager->persist($room);
    }

    private function resetResidents(Contract $contract)
    {
        $room = $contract->getRoom();
        $room->setResidents([]);
        $this->documentManager->persist($room);
    }

    private function check(Contract $contract)
    {
        if ($contract->getStatus() == Contract::STATUS_FINISHED) {
            throw new BadRequestHttpException('合同已结束，请勿重复操作');
        }
    }
}