<?php


namespace App\Services\Order;


use App\Document\Contract;
use App\Document\Order;
use App\Document\Room;
use App\Services\BaseService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class EditOrderService extends BaseService
{
    public function edit(Request $request, Order $order)
    {
        $this->check($request,$order);
        $contract = $this->getContract($order);
        $order->setStartDay($request->get('startDay'));
        $order->setEndDay($request->get('endDay'));
        $order->setWaterRecord($request->get('waterRecord'));
        $order->setElectricityRecord($request->get('electricityRecord'));
        $order->setOtherPrice($request->get('otherPrice'));
        $order->setRemark($request->get('remark'));
        $payment = $order->getPayment();
        $payment->setOrder($this->getOrderPrice($order,$contract));
        $payment->setTotal($payment->getLateFree()+$payment->getOrder());
        $order->setPayment($payment);
        $order->setUpdateAt(new \DateTime());
        //更新房间状态
        $room = $order->getRoom();
        $room->setWaterRecord($request->get('waterRecord'));
        $room->setElectricityRecord($request->get('electricityRecord'));
        $this->documentManager->persist($room);
        $this->documentManager->persist($order);
        $this->documentManager->flush();
        return $order;
    }

    private function getContract(Order $order): Contract
    {
        /** @var Contract $contract */
        $contract = $this->documentManager->getRepository(Contract::class)->findOneBy(['room'=>$order->getRoom()->getId(),'tenant'=>$order->getRoom()->getTenant()->getId()]);
        return $contract;
    }

    private function getOrderPrice(Order $order, Contract $contract)
    {
        $water = $order->getWaterRecord() - $order->getLastWaterRecord() + $order->getHouse()->getConfig()->getWaterAndElectricityLossNumber();
        $electricity = $order->getElectricityRecord() - $order->getLastElectricityRecord() + $order->getHouse()->getConfig()->getWaterAndElectricityLossNumber();

        return $order->getRent()
            + round($water * $contract->getWaterPrice(),2)
            + round($electricity * $contract->getElectricityPrice(),2)
            + $order->getNetworkPrice()
            + $order->getManagementPrice()
            + $order->getTvPrice()
            + $order->getCleanPrice()
            + $order->getOtherPrice();
    }

    private function check(Request $request, Order $order)
    {
        if ($order->getStatus() != Order::STATUS_CREATED) {
            throw new BadRequestHttpException('账单已收款，不支持修改');
        }
        if (empty($request->get('startDay'))) {
            throw new BadRequestHttpException('请选择开始时间');
        }
        if (empty($request->get('endDay'))) {
            throw new BadRequestHttpException('请选择结束时间');
        }
        if ($order->getLastElectricityRecord() > $request->get('electricityRecord')) {
            throw new BadRequestHttpException('本月电表记录错误，请检查是否抄错');
        }
        if ($order->getLastWaterRecord() > $request->get('waterRecord')) {
            throw new BadRequestHttpException('本月水表记录错误，请检查是否抄错');
        }
    }
}