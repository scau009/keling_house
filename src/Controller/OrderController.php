<?php


namespace App\Controller;


use App\Document\House;
use App\Document\Order;
use App\Document\Room;
use App\Services\Order\CreateOrderService;
use App\Services\Order\EditOrderService;
use Doctrine\ODM\MongoDB\DocumentManager;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class OrderController
 * @package App\Controller
 * @Route(path="/orders")
 */
class OrderController extends BaseController
{
    protected CreateOrderService $createOrderService;

    protected EditOrderService $editOrderService;

    public function __construct(DocumentManager $documentManager,CreateOrderService $createOrderService,EditOrderService $editOrderService)
    {
        parent::__construct($documentManager);
        $this->createOrderService = $createOrderService;
        $this->editOrderService = $editOrderService;
    }

    /**
     * @Route(path="/list",name="order_list",methods={"GET"})
     * @Template(template="order/index.html.twig")
     */
    public function index(Request $request,PaginatorInterface $pagination)
    {
        $query = $this->documentManager->getRepository(Order::class)->createQueryBuilder()->setByRequest($request);
        $orders = $pagination->paginate($query, $request->get('page', 1), $request->get('itemPerPage', 20));
        $houses = $this->documentManager->getRepository(House::class)->findAll();
        $houseId = $request->get('houseId');
        if (!empty($houseId)) {
            $rooms = $this->documentManager->getRepository(Room::class)->findBy(['house'=>$houseId]);
        }else if (!empty($houses) && empty($houseId)) {
            /** @var House $house */
            $house = $houses[0];
            $rooms = $this->documentManager->getRepository(Room::class)->findBy(['house'=>$house->getId()]);
        }else{
            $rooms = [];
        }
        return compact('orders','houses','rooms');
    }

    /**
     * @Route(path="/?room={id}",name="create_order",methods={"GET","POST"})
     */
    public function create(Room $room,Request $request)
    {
        if ($request->isMethod("GET")) {
            $endDay = date('Y-m-d');
            $startDay = '';
            return $this->render('order/add.html.twig',['room'=>$room,'startDay'=>$startDay,'endDay'=>$endDay]);
        }else{
            try {
                $order = $this->createOrderService->create($room,
                    $request->get('startDay'),
                    $request->get('endDay'),
                    $request->get('waterRecord'),
                    $request->get('electricityRecord'),
                    $request->get('remark'));
                return $this->redirectToRoute('show_order',['id'=>$order->getId()]);

            } catch (\Exception $exception) {
                $this->addFlash('errors',$exception->getMessage());
                return $this->redirectToRoute('create_order', ['id' => $room->getId()]);
            }
        }
    }

    /**
     * @Route(path="/show/{id}",name="show_order",methods={"GET"})
     * @Template(template="order/show.html.twig")
     */
    public function show(Order $order)
    {
        return compact('order');
    }

    /**
     * @Route(path="/batch-create",name="batch_create_orders",methods={"GET","POST"})
     * @Template(template="order/batch_add.html.twig")
     */
    public function batchCreate(Request $request)
    {
        if ($request->isMethod("GET")) {
            $endDay = date('Y-m-d');
            $startDay = '';
            $houses = $this->documentManager->getRepository(House::class)->findAll();
            $rooms = [];
            if (!empty($houses)) {
                /** @var House $house */
                $house = $houses[0];
                $rooms = $this->documentManager->getRepository(Room::class)->findBy(['house'=>$house->getId(),'status'=>Room::STATUS_BUSY]);
            }
            return compact('houses','endDay','startDay','rooms');
        }else{
            $roomIds = $request->get('roomId');
            if (empty($roomIds)) {
                $this->addFlash('errors','请选择房间');
                return $this->redirectToRoute('batch_create_orders');
            }
            $waterRecords = $request->get('waterRecord');
            $electricityRecords = $request->get('electricityRecord');
            $startDay = $request->get('startDay');
            $endDay = $request->get('endDay');
            $rooms = [];
            foreach ($roomIds as $key => $roomId) {
                /** @var Room $room */
                $rooms[$key] = $room = $this->documentManager->getRepository(Room::class)->find($roomId);
                try {
                    $this->createOrderService->check($room, $startDay,$endDay,$waterRecords[$key],$electricityRecords[$key]);
                } catch (\Exception $exception) {
                    $this->addFlash('errors',$exception->getMessage());
                    return $this->redirectToRoute('batch_create_orders');
                }
            }
            foreach ($rooms as $key => $room) {
                $order = $this->createOrderService->create($room,
                    $startDay,
                    $endDay,
                    $waterRecords[$key],
                    $electricityRecords[$key]);
            }
            return $this->redirectToRoute('order_list');
        }
    }

    /**
     * @Route(path="/edit/{id}",name="edit_order",methods={"GET","POST"})
     */
    public function edit(Order $order,Request $request)
    {
        if ($request->isMethod("GET")) {
            return $this->render('order/edit.html.twig',['order'=>$order]);
        }else{
            try {
                $this->editOrderService->edit($request, $order);
                $this->addFlash('success','修改成功');
                return $this->redirectToRoute('show_order', ['id' => $order->getId()]);
            } catch (\Exception $exception) {
                $this->addFlash('errors',$exception->getMessage());
                return $this->redirectToRoute('edit_order', ['id' => $order->getId()]);
            }
        }
    }
}