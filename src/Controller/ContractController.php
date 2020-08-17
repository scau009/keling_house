<?php


namespace App\Controller;


use App\Document\Contract;
use App\Document\House;
use App\Document\Tenant;
use App\Repository\Builder\ContractQueryBuilder;
use App\Services\Contract\CreateContractService;
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

    private CreateContractService $contractService;

    public function __construct(DocumentManager $documentManager, RoomService $roomService, CreateContractService $contractService)
    {
        parent::__construct($documentManager);
        $this->roomService = $roomService;
        $this->contractService = $contractService;
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

    /**
     * @Route(path="/{id}",methods={"GET"},name="show_contract")
     * @Template(template="contract/edit.html.twig")
     */
    public function show(Contract $contract)
    {
        return compact('contract');
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
            try {
                $this->contractService->createContract($tenant,$request);
                return $this->redirectToRoute('contract_list');
            } catch (\Exception $exception) {
                $this->addFlash('errors',$exception->getMessage());
                return $this->redirectToRoute('create_contract',['tenant'=>$tenant->getId()]);
            }
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