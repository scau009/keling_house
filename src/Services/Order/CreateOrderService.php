<?php


namespace App\Services\Order;


use App\Document\Contract;
use App\Document\Order;
use App\Document\Payment;
use App\Document\Room;
use App\Repository\Builder\OrderQueryBuilder;
use App\Services\BaseService;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class CreateOrderService extends BaseService
{
    public function create(Room $room,string $startDay, string $endDay,float $waterRecord,float $electricityRecord, string $remark = ''): Order
    {
        $this->check($room,$startDay,$endDay,$waterRecord,$electricityRecord);
        $contract = $this->getContract($room);
        $order = new Order();
        $house = $room->getHouse();
        $order->setHouse($house);
        $order->setRoom($room);
        $order->setWaterRecord($waterRecord);
        $order->setElectricityRecord($electricityRecord);
        $order->setStatus(Order::STATUS_CREATED);
        $order->setManagementPrice($contract->getManagementPrice());
        $order->setNetworkPrice($contract->getNetworkPrice());
        $order->setTvPrice($contract->getTvPrice());
        $order->setOtherPrice($contract->getOtherPrice());
        $order->setCleanPrice($contract->getCleanPrice());
        $order->setRent($contract->getRent());
        $order->setWaterPrice($contract->getWaterPrice());
        $order->setElectricityPrice($contract->getElectricityPrice());
        $order->setLastElectricityRecord($room->getElectricityRecord());
        $order->setLastWaterRecord($room->getWaterRecord());
        $order->setWaterAndElectricityLossNumber($house->getConfig()->getWaterAndElectricityLossNumber());
        $order->setRemark($remark);
        $order->setStartDay($startDay);
        $order->setEndDay($endDay);
        $latestOrder = $this->getLatestOrder();
        if ($latestOrder->getStatus() == Order::STATUS_PAID) {
            $order->setLastMonthPrice($latestOrder->getPayment()->getTotal() - $latestOrder->getPayment()->getPaid());
        }
        $payment = new Payment();
        $orderPrice = round($this->getOrderPrice($room, $order, $contract),2);
        $payment->setOrder($orderPrice);
        $payment->setLateFree(0);//todo 暂时不要算滞纳金
        $payment->setTotal($payment->getOrder() + $payment->getLateFree());
        $order->setPayment($payment);
        $order->setPayer($room->getTenant());
        $order->setCreateAt(new \DateTime());
        $order->setUpdateAt(new \DateTime());
        //更新 room
        $room->setWaterRecord($waterRecord);
        $room->setElectricityRecord($electricityRecord);
        $this->documentManager->persist($room);
        $this->documentManager->persist($order);
        $this->documentManager->flush();
        return $order;
    }

    private function getLatestOrder(): ?Order
    {
        /** @var OrderQueryBuilder $orderQueryBuilder */
        $orderQueryBuilder = $this->documentManager->getRepository(Order::class)->createQueryBuilder();
        return $orderQueryBuilder->sort('createAt', -1)->limit(1)->getQuery()->getSingleResult();
    }

    private function getOrderPrice(Room $room, Order $order, Contract $contract)
    {
        $water = $order->getWaterRecord() - $room->getWaterRecord() + $room->getHouse()->getConfig()->getWaterAndElectricityLossNumber();
        $electricity = $order->getElectricityRecord() - $room->getElectricityRecord() + $room->getHouse()->getConfig()->getWaterAndElectricityLossNumber();

        return $order->getRent()
            + round($water * $contract->getWaterPrice(),2)
            + round($electricity * $contract->getElectricityPrice(),2)
            + $order->getNetworkPrice()
            + $order->getManagementPrice()
            + $order->getTvPrice()
            + $order->getCleanPrice()
            + $order->getOtherPrice()
            + $order->getLastMonthPrice();
    }

    private function getContract(Room $room): Contract
    {
        /** @var Contract $contract */
        $contract = $this->documentManager->getRepository(Contract::class)->findOneBy(['room'=>$room->getId(),'tenant'=>$room->getTenant()->getId()]);
        return $contract;
    }

    public function check(Room $room,string $startDay, string $endDay,float $waterRecord,float $electricityRecord)
    {
        if ($room->getStatus() != Room::STATUS_BUSY) {
            throw new BadRequestHttpException('房屋未出租');
        }
        if (empty($startDay)) {
            throw new BadRequestHttpException('请选择开始时间');
        }
        if (empty($endDay)) {
            throw new BadRequestHttpException('请选择结束时间');
        }
        if ($room->getElectricityRecord() > $electricityRecord) {
            throw new BadRequestHttpException('本月电表记录错误，请检查是否抄错');
        }
        if ($room->getWaterRecord() > $waterRecord) {
            throw new BadRequestHttpException('本月水表记录错误，请检查是否抄错');
        }
        return true;
    }
}