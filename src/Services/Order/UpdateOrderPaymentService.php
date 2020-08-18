<?php


namespace App\Services\Order;


use App\Document\Order;
use App\Services\BaseService;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UpdateOrderPaymentService extends BaseService
{
    public function update(Order $order,float $paid)
    {
        $this->check($order,$paid);
        $payment = $order->getPayment();
        $payment->setPaid($payment->getPaid()+$paid);
        if ($payment->getPaid() >= $payment->getTotal()) {
            $order->setStatus(Order::STATUS_PAID);
        }else if ($payment->getPaid() >0 ){
            $order->setStatus(Order::STATUS_SECTION_PAID);
        }
        $this->documentManager->persist($order);
        $this->documentManager->flush();
        return $order;
    }

    private function check(Order $order,float $paid)
    {
        if (empty($order)) {
            throw new NotFoundHttpException('找不到账单');
        }
        if ($order->getStatus() == Order::STATUS_PAID) {
            throw new BadRequestHttpException('订单已支付');
        }
        if ($paid <=0) {
            throw new BadRequestHttpException('请输入正确的收款金额');
        }
    }
}