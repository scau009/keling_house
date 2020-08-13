<?php


namespace App\Controller\Api;

use App\Services\RoomService;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class RoomApiController
 * @package App\Controller\Api
 * @Route(path="/api/rooms")
 */
class RoomApiController extends BaseApiController
{
    protected RoomService $roomService;

    public function __construct(DocumentManager $documentManager, SerializerInterface $serializer, RoomService $roomService)
    {
        parent::__construct($documentManager, $serializer);
        $this->roomService = $roomService;
    }

    /**
     * @param Request $request
     * @return object[]
     * @Route(path="/",methods={"GET"},name="api_get_rooms")
     */
    public function getRooms(Request $request)
    {
        $rooms = $this->roomService->getRoomsByRequest($request);
        return new JsonResponse([
            'rooms' => $this->serializer->normalize($rooms,'json',['groups'=>'api']),
        ]);
    }
}