<?php


namespace App\Services\Contract;


use App\Document\Contract;
use App\Document\House;
use App\Document\Room;
use App\Document\Tenant;
use App\Services\BaseService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class CreateContractService extends BaseService
{
    /**
     * 创建合同
     * @param Tenant $tenant
     * @param Request $request
     * @throws \Doctrine\ODM\MongoDB\MongoDBException
     */
    public function createContract(Tenant $tenant, Request $request)
    {
        /** @var House $house */
        $house = $this->documentManager->getRepository(House::class)->find($request->get('houseId'));
        /** @var Room $room */
        $room = $this->documentManager->getRepository(Room::class)->find($request->get('roomId'));

        if (empty($house) || empty($room)) {
            throw new BadRequestHttpException('请选择房屋和房间，如无请创建');
        }

        if (!$room->isAvailable() && $room->getStatus() == Room::STATUS_CLEANING) {
            throw new BadRequestHttpException($house->getName().$room->getName().'房间已被入住');
        }

        if (!$room->isAvailable() && $room->getStatus() == Room::STATUS_CLEANING) {
            throw new BadRequestHttpException($house->getName().$room->getName().'正在清洁，请修改房间状态');
        }

        if (empty($request->get('zulingqi'))) {
            throw new BadRequestHttpException('请设置租赁期');
        }

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