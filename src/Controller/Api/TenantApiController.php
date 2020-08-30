<?php


namespace App\Controller\Api;


use App\Document\Tenant;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TenantApiController
 * @package App\Controller\Api
 * @Route(path="/api/tenant")
 */
class TenantApiController extends BaseApiController
{
    /**
     * @Route(path="/delete",methods={"POST"},name="delete_tenant")
     */
    public function delete(Request $request)
    {
        /** @var Tenant $tenant */
        $tenant = $this->documentManager->getRepository(Tenant::class)->find($request->get('tenant'));
        if (!empty($tenant->getHouses()) || count($tenant->getRooms()->toArray()) != 0) {
            return new JsonResponse([
                'code'=> 400,
                'data'=>'',
                'message'=>'此租客关联了房间或房屋，请先解绑！']);
        }
        $this->documentManager->remove($tenant);
        $this->documentManager->flush();
        return new JsonResponse([
            'code'=> 200,
            'data'=>'',
            'message'=>'删除成功']);
    }

}