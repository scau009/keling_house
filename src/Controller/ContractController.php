<?php


namespace App\Controller;


use App\Document\Contract;
use App\Document\House;
use App\Document\Room;
use App\Document\Tenant;
use App\Repository\Builder\ContractQueryBuilder;
use App\Repository\Builder\RoomQueryBuilder;
use App\Services\RoomService;
use Doctrine\ODM\MongoDB\DocumentManager;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ContractController
 * @package App\Controller
 * @Route(path="/contract")
 */
class ContractController extends BaseController
{
    private RoomService $roomService;

    public function __construct(DocumentManager $documentManager,RoomService $roomService)
    {
        parent::__construct($documentManager);
        $this->roomService = $roomService;
    }

    /**
     * @Route(path="/list",methods={"GET"},name="contract_list")
     * @Template(template="contract/index.html.twig")
     */
    public function index(Request $request,PaginatorInterface $pagination)
    {
        /** @var ContractQueryBuilder $roomQueryBuilder */
        $roomQueryBuilder = $this->documentManager->getRepository(Contract::class)->createQueryBuilder();
        $roomQueryBuilder->setByRequest($request);
        $contracts = $pagination->paginate($roomQueryBuilder->getQuery(), $request->get('page', 1), $request->get('itemPerPage', 20));
        return compact('contracts');
    }

    public function show()
    {
        
    }

    public function edit()
    {
        
    }

    /**
     * @Route(path="?tenant={tenant}",name="create_contract",methods={"GET","POST"})
     */
    public function create(Tenant $tenant, Request $request)
    {
        if ($request->isMethod('GET')) {
            $houses = $this->documentManager->getRepository(House::class)->findAll();
            $rooms = $this->roomService->getRoomsCollectionInHouse();
            return $this->render('contract/add.html.twig',['tenant'=>$tenant,'houses'=>$houses,'rooms'=>$rooms]);
        }else{
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
            $contract->setNetworkPrice($request->get('networkPrice'));
            $contract->setManagementPrice($request->get('managementPrice'));
            $contract->setOtherPrice($request->get('otherPrice'));
            $contract->setStatus(Room::STATUS_BUSY);
            $this->documentManager->persist($contract);
            $this->documentManager->flush();
            return $this->redirectToRoute('contract_list');
        }
    }

    public function delete()
    {
        
    }

    /**
     * @Route(name="contract_template",path="/contract/template")
     * @Template(template="contract/template.html.twig")
     */
    public function template()
    {

    }
}