<?php


namespace App\Services;


use App\Document\Contract;
use App\Document\House;
use App\Document\Room;
use App\Document\Tenant;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Component\HttpFoundation\Request;

class ContractService
{
    private DocumentManager $documentManager;

    public function __construct(DocumentManager $documentManager)
    {
        $this->documentManager = $documentManager;
    }

    public function createContract(Tenant $tenant, Request $request)
    {
        /** @var House $house */
        $house = $this->documentManager->getRepository(House::class)->find($request->get('houseId'));
        /** @var Room $room */
        $room = $this->documentManager->getRepository(Room::class)->find($request->get('roomId'));

        $contract = new Contract();
        $contract->setHouse($house);
        $contract->setRoom($room);
        $contract->setTenant($tenant);
        $contract->setCreateAt(new \DateTime());
        $contract->setUpdateAt(new \DateTime());
        $date = explode(' 至 ' ,$request->get('zulingqi'));
        $contract->setBeginDay($date[0]);
        $contract->setFinishDay($date[1]);
        $contract->setRent($request->get('rent'));
        $contract->setDeposit($request->get('deposit'));
        $contract->setWaterRecord($request->get('waterRecord'));
        $contract->setElectricityRecord($request->get('electricityRecord'));
        $contract->setWaterPrice($request->get('waterPrice'));
        $contract->setElectricityPrice($request->get('electricityPrice'));
        $contract->setCleanPrice($request->get('cleanPrice'));
        $contract->setTvPrice($request->get('tvPrice'));
        $contract->setKeyPrice($request->get('keyPrice'));
        $contract->setNetworkPrice($request->get('networkPrice'));
        $contract->setManagementPrice($request->get('managementPrice'));
        $contract->setOtherPrice($request->get('otherPrice'));
        $contract->setStatus(Contract::STATUS_RUNNING);

        $this->updateRoom($tenant,$room,$request->get('waterRecord'),$request->get('electricityRecord'));

        $this->documentManager->persist($contract);
        $this->documentManager->flush();
    }

    private function updateRoom(Tenant $tenant,Room $room,float $waterRecord, float $electricityRecord)
    {
        //更新这个房间
        $room->setStatus(Room::STATUS_BUSY);
        $room->setTenant($tenant);
        $room->setResidents([$tenant]);
        $room->setWaterRecord($waterRecord);
        $room->setElectricityRecord($electricityRecord);
        $this->documentManager->persist($room);
    }
}