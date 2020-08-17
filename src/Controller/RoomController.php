<?php


namespace App\Controller;

use App\Document\House;
use App\Document\Room;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class RoomController
 * @package App\Controller
 * @Route(path="/room")
 */
class RoomController extends BaseController
{
    /**
     * @Route(path="?house={id}",name="room_list",methods={"GET"})
     * @Template(template="room/index.html.twig")
     */
    public function index(House $house,Request $request,PaginatorInterface $pagination)
    {
        $request->query->set('houseId', $house->getId());
        $query = $this->documentManager->getRepository(Room::class)->createQueryBuilder()->setByRequest($request);
        $rooms = $pagination->paginate($query, $request->get('page', 1), $request->get('itemPerPage', 20));
        return compact('house','rooms');
    }

    /**
     * @Route(path="/create?house={id}",name="create_room",methods={"GET","POST"})
     */
    public function createRoom(House $house, Request $request)
    {
        if ($request->isMethod("GET")) {
            return $this->render('room/add.html.twig',['house'=>$house]);
        }else{
            $room = new Room();
            $room->setName($request->get('name'));
            $room->setDeposit($request->get('deposit'));
            $room->setElectricityRecord($request->get('electricityRecord'));
            $room->setWaterRecord($request->get('waterRecord'));
            $room->setHouse($house);
            $room->setRent($request->get('rent'));
            $room->setStatus($request->get('status'));
            $this->documentManager->persist($room);
            $this->documentManager->flush();
            return $this->redirectToRoute('room_list',['id'=>$house->getId()]);
        }
    }

    /**
     * @Route(path="/show/{id}",name="show_room",methods={"GET"})
     */
    public function showRoom(Room $room)
    {
        return $this->render('room/edit.html.twig',['room'=>$room]);
    }

    /**
     * @param Room $room
     * @Route(path="/{id}",name="edit_room",methods={"POST"})
     */
    public function editRoom(Room $room,Request $request)
    {
        $room->setName($request->get('name'));
        $room->setDeposit($request->get('deposit'));
        $room->setElectricityRecord($request->get('electricityRecord'));
        $room->setWaterRecord($request->get('waterRecord'));
        $room->setRent($request->get('rent'));
        $room->setStatus($request->get('status'));
        $this->documentManager->persist($room);
        $this->documentManager->flush();
        return $this->redirectToRoute('room_list',['id'=>$room->getHouse()->getId()]);
    }

    /**
     * @Route(path="/delete/{id}",name="delete_room",methods={"POST"})
     */
    public function deleteRoom(Room $room)
    {
        $this->documentManager->remove($room);
        $this->documentManager->flush();
        $this->addFlash('success','删除成功！');
        return $this->redirectToRoute('room_list');
    }
}