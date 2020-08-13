<?php


namespace App\Controller;

use App\Document\Tenant;
use App\Services\Uploader;
use Doctrine\ODM\MongoDB\DocumentManager;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\UrlHelper;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TenantController
 * @package App\Controller
 * @Route(path="/tenant")
 */
class TenantController extends BaseController
{
    private Uploader $uploader;

    public function __construct(DocumentManager $documentManager,Uploader $uploader)
    {
        parent::__construct($documentManager);
        $this->uploader = $uploader;
    }

    /**
     * @Route(path="/list",methods={"GET"},name="tenant_list")
     * @Template(template="tenant/index.html.twig")
     */
    public function index(Request $request,PaginatorInterface $pagination)
    {
        $query = $this->documentManager->getRepository(Tenant::class)->createQueryBuilder()->setByRequest($request);
        $tenants = $pagination->paginate($query, $request->get('page', 1), $request->get('itemPerPage', 20));
        return compact('tenants');
    }

    /**
     * @Route(path="/{id}",methods={"GET"},name="show_tenant")
     * @Template(template="tenant/edit.html.twig",vars={"tenant"})
     */
    public function show(Tenant $tenant)
    {
    }

    /**
     * @Route(path="/{id}",methods={"POST"},name="edit_tenant")
     */
    public function edit(Tenant $tenant,Request $request)
    {
        $tenant->setAddress($request->get('address'));
        $tenant->setIdNumber($request->get('idNumber'));
        $tenant->setMobile($request->get('mobile'));
        $tenant->setSex($request->get('sex'));
        $tenant->setRealName($request->get('realname'));
        //处理图片上传
        if ($idCardImage = $request->files->get('idCardImage')) {
            //删除旧的图片
            if ($tenant->getIdCardImage()) {
                $filesystem = new Filesystem();
                $filesystem->remove(__PUBLIC__.'/upload/'.$tenant->getIdCardImage());
            }
            $idCardImageFilePath = $this->uploader->upload($idCardImage);
            $tenant->setIdCardImage($idCardImageFilePath);
        }
        if ($request->get('clickedCancel')) {
            //删除旧的图片
            if ($tenant->getIdCardImage()) {
                $filesystem = new Filesystem();
                $filesystem->remove(__PUBLIC__.'/upload/'.$tenant->getIdCardImage());
            }
            $tenant->setIdCardImage('');
        }
        $this->documentManager->persist($tenant);
        $this->documentManager->flush();
        return $this->redirectToRoute('show_tenant', ['id' => $tenant->getId()]);
    }

    /**
     * @Route(path="/delete/{id}",methods={"POST"},name="delete_tenant")
     */
    public function delete(Tenant $tenant)
    {
        $this->documentManager->remove($tenant);
        $this->documentManager->flush();
        return $this->redirectToRoute('tenant_list');
    }

    /**
     * @Route(path="/",methods={"POST","GET"},name="create_tenant")
     */
    public function create(Request $request)
    {
        if ($request->isMethod("GET")) {
            return $this->render('tenant/add.html.twig');
        }else{
            $tenant = new Tenant();
            $tenant->setAddress($request->get('address'));
            $tenant->setIdNumber($request->get('idNumber'));
            $tenant->setMobile($request->get('mobile'));
            $tenant->setSex($request->get('sex'));
            $tenant->setRealName($request->get('realname'));
            //处理图片上传
            if ($idCardImage = $request->files->get('idCardImage')) {
                $idCardImageFilePath = $this->uploader->upload($idCardImage);
                $tenant->setIdCardImage($idCardImageFilePath);
            }
            $this->documentManager->persist($tenant);
            $this->documentManager->flush();
            return $this->redirectToRoute('tenant_list');
        }
    }
}