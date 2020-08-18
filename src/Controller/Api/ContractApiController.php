<?php


namespace App\Controller\Api;

use App\Document\Contract;
use App\Services\Contract\CloseContractService;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class ContractApiController
 * @package App\Controller\Api
 * @Route(path="/api/contract")
 */
class ContractApiController extends BaseApiController
{
    private CloseContractService $closeContractService;

    public function __construct(DocumentManager $documentManager, SerializerInterface $serializer,CloseContractService $closeContractService)
    {
        parent::__construct($documentManager, $serializer);
        $this->closeContractService = $closeContractService;
    }

    /**
     * @Route(path="/close",methods={"POST"},name="close_contract")
     */
    public function closeContract(Request $request)
    {
        /** @var Contract $contract */
        $contract = $this->documentManager->getRepository(Contract::class)->find($request->get('contract'));
        try {
            $this->closeContractService->close($contract);
            return new JsonResponse([
                'code'=> 200,
                'data'=>'',
                'message'=>'退房成功']);
        } catch (\Exception $exception) {
            return new JsonResponse([
                'code'=> $exception->getCode(),
                'data'=>'',
                'message'=>$exception->getMessage()]);
        }
    }

    /**
     * @Route(path="/delete",methods={"POST"},name="delete_contract")
     */
    public function delete(Request $request)
    {
        /** @var Contract $contract */
        $contract = $this->documentManager->getRepository(Contract::class)->find($request->get('contract'));
        if ($contract->getStatus() == Contract::STATUS_RUNNING) {
            return new JsonResponse([
                'code'=> 400,
                'data'=>'',
                'message'=>'合同正在履行中，无法删除！']);
        }
        $this->documentManager->remove($contract);
        $this->documentManager->flush();
        return new JsonResponse([
            'code'=> 200,
            'data'=>'',
            'message'=>'删除成功']);
    }

}