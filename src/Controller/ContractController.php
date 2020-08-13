<?php


namespace App\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ContractController
 * @package App\Controller
 * @Route(path="/contract")
 */
class ContractController extends BaseController
{
    /**
     * @Route(path="/list",methods={"GET"},name="contract_list")
     * @Template(template="contract/index.html.twig")
     */
    public function index()
    {
        
    }

    public function show()
    {
        
    }

    public function edit()
    {
        
    }

    public function create()
    {
        
    }

    public function delete()
    {
        
    }
}