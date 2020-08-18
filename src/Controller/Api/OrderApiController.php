<?php


namespace App\Controller\Api;


use App\Document\Order;
use App\Services\Order\UpdateOrderPaymentService;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class OrderApiController  extends BaseApiController
{
    private UpdateOrderPaymentService $updateOrderPaymentService;

    public function __construct(DocumentManager $documentManager, SerializerInterface $serializer, UpdateOrderPaymentService $updateOrderPaymentService)
    {
        parent::__construct($documentManager, $serializer);
        $this->updateOrderPaymentService = $updateOrderPaymentService;
    }

    /**
     * @Route(path="/update/payment",methods={"POST"},name="update_payment")
     * @param Request $request
     */
    public function updatePayment(Request $request)
    {
        /** @var Order $order */
        $order = $this->documentManager->getRepository(Order::class)->find($request->get('order'));
        try {
            $this->updateOrderPaymentService->update($order,$request->get('paid'));
            return new JsonResponse([
                'code'=> 200,
                'data'=>'',
                'message'=>'更新成功！']);
        } catch (\Exception $exception) {
            return new JsonResponse([
                'code'=> $exception->getCode(),
                'data'=>'',
                'message'=>'更新失败！']);
        }
    }
}