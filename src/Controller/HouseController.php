<?php


namespace App\Controller;


use App\Document\House;
use App\Services\SystemConfigService;
use Doctrine\ODM\MongoDB\DocumentManager;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class HouseController
 * @package App\Controller
 * @Route(path="/houses")
 */
class HouseController extends BaseController
{
    private SystemConfigService $configService;

    public function __construct(DocumentManager $documentManager,SystemConfigService $configService)
    {
        parent::__construct($documentManager);
        $this->configService = $configService;
    }

    /**
     * @Route(path="/list",name="house_list")
     * @Template(template="house/index.html.twig")
     */
    public function index(Request $request,PaginatorInterface $pagination)
    {
        $query = $this->documentManager->getRepository(House::class)->createQueryBuilder()->setByRequest($request);
        $houses = $pagination->paginate($query, $request->get('page', 1), $request->get('itemPerPage', 20));
        return compact('houses');
    }

    /**
     * @param Request $request
     * @Route(path="/",name="create_house",methods={"GET","POST"})
     */
    public function createHouse(Request $request)
    {
        if ($request->isMethod("GET")) {
            return $this->render('house/add.html.twig');
        }else{
            $house = new House();
            $house->setName($request->get('name'));
            $house->setAddress($request->get('address',''));
            $house->setUpdateAt((new \DateTime()));
            $house->setCreateAt((new \DateTime()));
            $house->setConfig($this->configService->getConfigByRequest($request));
            $this->documentManager->persist($house);
            $this->documentManager->flush();
            $this->addFlash('success','添加成功！');
            return $this->redirectToRoute('house_list');
        }
    }

    /**
     * @Route(path="/{id}",methods={"GET"},name="show_house")
     * @Template(template="house/edit.html.twig",vars={"house"})
     */
    public function showHouse(House $house)
    {

    }

    /**
     * @param Request $request
     * @param House $house
     * @Route(path="/{id}",methods={"POST"},name="edit_house")
     */
    public function editHouse(House $house, Request $request)
    {
        $house->setName($request->get('name'));
        $house->setAddress($request->get('address',''));
        $house->setUpdateAt((new \DateTime()));
        $house->setConfig($this->configService->getConfigByRequest($request));
        $this->documentManager->persist($house);
        $this->documentManager->flush();
        $this->addFlash('success','修改成功！');
        return $this->redirectToRoute('show_house', ['id' => $house->getId()]);
    }

    /**
     * @Route(path="/delete/{id}",methods={"POST"},name="delete_house")
     */
    public function deleteHouse(House $house)
    {
        $this->documentManager->remove($house);
        $this->documentManager->flush();
        $this->addFlash('success','删除成功！');
        return $this->redirectToRoute('house_list');
    }
}